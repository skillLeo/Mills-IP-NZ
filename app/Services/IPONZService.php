<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class IPONZService
{
    private const PER_PAGE  = 20;
    private const CACHE_TTL = 600;

    private string $subscriptionKey;
    private string $baseUrl;

    public function __construct()
    {
        $this->subscriptionKey = config('services.iponz.subscription_key') ?? '';
        $this->baseUrl         = rtrim(config('services.iponz.base_url') ?? '', '/');
    }

    // ── HTTP client ───────────────────────────────────────────────────────────

    private function http(array $extraHeaders = []): PendingRequest
    {
        return Http::timeout(10)
            ->connectTimeout(5)
            ->withHeaders(array_merge([
                'Ocp-Apim-Subscription-Key' => $this->subscriptionKey,
            ], $extraHeaders))->withOptions([
                'proxy' => '',
                'curl'  => [CURLOPT_PROXY => '', CURLOPT_NOPROXY => '*'],
            ]);
    }

    // ── Public API ────────────────────────────────────────────────────────────

    public function search(string $query): array
    {
        if (empty($this->subscriptionKey) || empty($this->baseUrl)) {
            return $this->emptyResult();
        }

        $cacheKey = 'iponz_p1_' . md5(strtolower(trim($query)));

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($query) {
            return $this->fetchFirstPage($query);
        });
    }

    public function searchPage(string $query, int $page): array
    {
        if (empty($this->subscriptionKey) || empty($this->baseUrl)) {
            return $this->emptyResult();
        }

        $ids = Cache::get('iponz_ids_' . md5(strtolower(trim($query))), []);

        if (empty($ids)) {
            return $this->emptyResult();
        }

        $total  = count($ids);
        $offset = ($page - 1) * self::PER_PAGE;
        $slice  = array_values(array_slice($ids, $offset, self::PER_PAGE));

        if (empty($slice)) {
            return ['results' => [], 'total' => $total, 'loaded' => $total, 'hasMore' => false];
        }

        try {
            $results = $this->fetchDetails($slice);
            $loaded  = $offset + count($results);

            return [
                'results' => $results,
                'total'   => $total,
                'loaded'  => $loaded,
                'hasMore' => $loaded < $total,
            ];

        } catch (\Exception $e) {
            Log::error('IPONZService searchPage error: ' . $e->getMessage());
            return $this->emptyResult();
        }
    }

    // ── Internal: search ──────────────────────────────────────────────────────

    private function fetchFirstPage(string $query): array
    {
        try {
            $soap = $this->buildSearchSoap($query);

            $response = $this->http([
                'Content-Type' => 'text/xml; charset=utf-8',
                'SOAPAction'   => 'ListTradeMarks',
            ])->withBody($soap, 'text/xml')
              ->post($this->baseUrl . '/trademarksearch');

            if ($response->failed()) {
                Log::error('IPONZ search failed', [
                    'query'  => $query,
                    'status' => $response->status(),
                    'body'   => substr($response->body(), 0, 500),
                ]);
                return $this->emptyResult();
            }

            $ids   = $this->parseApplicationNumbers($response->body());
            $total = count($ids);

            if (empty($ids)) {
                return $this->emptyResult();
            }

            Cache::put('iponz_ids_' . md5(strtolower(trim($query))), $ids, self::CACHE_TTL);

            $firstBatch = array_values(array_slice($ids, 0, self::PER_PAGE));
            $results    = $this->fetchDetails($firstBatch);

            return [
                'results' => $results,
                'total'   => $total,
                'loaded'  => count($results),
                'hasMore' => count($results) < $total,
            ];

        } catch (\Exception $e) {
            Log::error('IPONZService fetchFirstPage error: ' . $e->getMessage());
            return $this->emptyResult();
        }
    }

    // POST /trademarksearch — SOAP/XML request
    // Field names from IPONZ v5 API data dictionary (Trade Mark Search Operation)
    private function buildSearchSoap(string $query): string
    {
        $escaped = htmlspecialchars($query, ENT_XML1 | ENT_QUOTES, 'UTF-8');

        return <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
  <soapenv:Header/>
  <soapenv:Body>
    <ListTradeMarksRequest>
      <Title>{$escaped}</Title>
      <GetGoodsAndServices>false</GetGoodsAndServices>
    </ListTradeMarksRequest>
  </soapenv:Body>
</soapenv:Envelope>
XML;
    }

    // Extract ApplicationNumber values from SOAP search response XML.
    // Uses local-name() XPath to ignore any SOAP/service namespace prefixes.
    private function parseApplicationNumbers(string $xml): array
    {
        try {
            libxml_use_internal_errors(true);
            $doc = simplexml_load_string($xml);
            if (!$doc) {
                return [];
            }

            $nodes = $doc->xpath('//*[local-name()="ApplicationNumber"]');
            if (empty($nodes)) {
                return [];
            }

            $ids = [];
            foreach ($nodes as $node) {
                $val = trim((string) $node);
                if ($val !== '' && is_numeric($val)) {
                    $ids[] = (int) $val;
                }
            }

            return array_values(array_unique($ids));

        } catch (\Exception $e) {
            Log::error('IPONZ parseApplicationNumbers error: ' . $e->getMessage());
            return [];
        }
    }

    // ── Internal: detail ──────────────────────────────────────────────────────

    // GET /trademarks/{trademark-number} — fetched in parallel
    private function fetchDetails(array $ids): array
    {
        $baseUrl         = $this->baseUrl;
        $subscriptionKey = $this->subscriptionKey;

        $responses = Http::pool(function (\Illuminate\Http\Client\Pool $pool) use ($ids, $subscriptionKey, $baseUrl) {
            return array_map(
                fn ($id) => $pool
                    ->timeout(10)
                    ->connectTimeout(5)
                    ->withHeaders(['Ocp-Apim-Subscription-Key' => $subscriptionKey])
                    ->withOptions(['proxy' => '', 'curl' => [CURLOPT_PROXY => '', CURLOPT_NOPROXY => '*']])
                    ->get($baseUrl . '/trademarks/' . $id),
                $ids
            );
        });

        $results = [];
        foreach ($responses as $index => $response) {
            if ($response->successful()) {
                $mapped = $this->parseSingleTrademark($response->body(), $ids[$index]);
                if ($mapped !== null) {
                    $results[] = $mapped;
                }
            }
        }

        return array_values(array_filter($results));
    }

    // Tries XML first (IPONZ v5 responses are XML), falls back to JSON
    private function parseSingleTrademark(string $body, int|string $id): ?array
    {
        $mapped = $this->parseTrademarkXml($body, $id);
        if ($mapped !== null) {
            return $mapped;
        }

        $json = json_decode($body, true);
        if (is_array($json)) {
            return $this->mapTrademarkJson($json, $id);
        }

        return null;
    }

    // Parse GET /trademarks/{trademark-number} XML response.
    // Field names from IPONZ v5 API data dictionary (Trade Mark Information Operations).
    private function parseTrademarkXml(string $xml, int|string $id): ?array
    {
        try {
            libxml_use_internal_errors(true);
            $doc = simplexml_load_string($xml);
            if (!$doc) {
                return null;
            }

            // Bail out if the response is an error
            $errorCode = $this->xval($doc, '//*[local-name()="TransactionErrorCode"]');
            if (!empty($errorCode)) {
                return null;
            }

            $appNum    = $this->xval($doc, '//*[local-name()="ApplicationNumber"]');
            $markTitle = $this->xval($doc, '//*[local-name()="MarkTitle"]');
            if (empty($markTitle)) {
                // MarkVerbalElementText is also a valid title source per the data dictionary
                $markTitle = $this->xval($doc, '//*[local-name()="MarkVerbalElementText"]');
            }
            $status  = $this->xval($doc, '//*[local-name()="MarkCurrentStatusCode"]');
            $appDate = $this->xval($doc, '//*[local-name()="ApplicationDate"]');
            $regDate = $this->xval($doc, '//*[local-name()="RegistrationDate"]');

            // ApplicantAddressBook holds the public name/contact for the trademark owner
            $ownerName = $this->xval($doc, '//*[local-name()="ApplicantAddressBook"]//*[local-name()="Name"]');
            if (empty($ownerName)) {
                $ownerName = $this->xval($doc, '//*[local-name()="Applicant"]//*[local-name()="Name"]');
            }

            // ClassNumber may appear multiple times (one per Nice class)
            $classNodes = $doc->xpath('//*[local-name()="ClassNumber"]');
            $classes    = [];
            foreach ((array) $classNodes as $cn) {
                $val = trim((string) $cn);
                if ($val !== '' && $val !== '0') {
                    $classes[] = $val;
                }
            }

            return [
                'trademark_number'  => $appNum ?: $id,
                'trademark_name'    => strtoupper($markTitle ?: ''),
                'status'            => $status ?: '',
                'owner'             => $ownerName ?: '',
                'class'             => implode(', ', array_unique(array_filter($classes))),
                'application_date'  => $appDate ?: '',
                'registration_date' => $regDate ?: '',
            ];

        } catch (\Exception $e) {
            Log::error('IPONZ parseTrademarkXml error', ['id' => $id, 'error' => $e->getMessage()]);
            return null;
        }
    }

    // JSON fallback in case the gateway returns JSON instead of XML
    private function mapTrademarkJson(array $tm, int|string $id): array
    {
        $name = $tm['MarkTitle']    ?? $tm['markTitle']    ??
                $tm['MarkVerbalElementText'] ??
                (isset($tm['words']) ? implode(' ', (array) $tm['words']) : ($tm['name'] ?? ''));

        // Owner can be nested several ways depending on API version
        $ownerName = '';
        $applicant = $tm['ApplicantDetails']['Applicant']
                  ?? $tm['applicantDetails']['applicant']
                  ?? $tm['applicants'][0]
                  ?? null;
        if ($applicant) {
            $book = $applicant['ApplicantAddressBook'] ?? $applicant['applicantAddressBook'] ?? [];
            $ownerName = $book['Name'] ?? $book['name'] ?? $applicant['name'] ?? '';
        }
        if (empty($ownerName)) {
            $ownerName = $tm['ownerName'] ?? $tm['owner'] ?? '';
        }

        // Class numbers
        $classes = [];
        foreach ((array) ($tm['GoodsAndServices'] ?? $tm['goodsAndServices'] ?? []) as $gs) {
            $cn = $gs['ClassNumber'] ?? $gs['classNumber'] ?? null;
            if ($cn) {
                $classes[] = (string) $cn;
            }
        }

        return [
            'trademark_number'  => $tm['ApplicationNumber']  ?? $tm['applicationNumber']  ?? $id,
            'trademark_name'    => strtoupper($name),
            'status'            => $tm['MarkCurrentStatusCode'] ?? $tm['markCurrentStatusCode'] ?? $tm['status'] ?? '',
            'owner'             => $ownerName,
            'class'             => implode(', ', array_unique(array_filter($classes))),
            'application_date'  => $tm['ApplicationDate']   ?? $tm['applicationDate']   ?? '',
            'registration_date' => $tm['RegistrationDate']  ?? $tm['registrationDate']  ?? '',
        ];
    }

    // ── Utilities ─────────────────────────────────────────────────────────────

    private function xval(\SimpleXMLElement $doc, string $xpath): string
    {
        $nodes = $doc->xpath($xpath);
        return !empty($nodes) ? trim((string) $nodes[0]) : '';
    }

    private function emptyResult(): array
    {
        return ['results' => [], 'total' => 0, 'loaded' => 0, 'hasMore' => false];
    }
}
