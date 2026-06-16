<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class IPAustraliaService
{
    private const PER_PAGE   = 20;
    private const CACHE_TTL  = 600;

    private string $clientId;
    private string $clientSecret;
    private string $tokenUrl;
    private string $baseUrl;

    public function __construct()
    {
        $this->clientId     = config('services.ip_australia.client_id', '');
        $this->clientSecret = config('services.ip_australia.client_secret', '');
        $this->tokenUrl     = config('services.ip_australia.token_url', '');
        $this->baseUrl      = config('services.ip_australia.base_url', '');
    }

    private function getAccessToken(): string
    {
        return Cache::remember('ip_australia_token', 3540, function () {
            $response = $this->http()->asForm()->post($this->tokenUrl, [
                'grant_type'    => 'client_credentials',
                'client_id'     => $this->clientId,
                'client_secret' => $this->clientSecret,
            ]);

            if ($response->failed()) {
                Log::error('IP Australia token fetch failed', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
                throw new \Exception('Unable to connect to IP Australia API.');
            }

            return $response->json('access_token');
        });
    }

    private function http(?string $token = null): PendingRequest
    {
        $request = Http::withOptions([
            'proxy' => '',
            'curl'  => [CURLOPT_PROXY => '', CURLOPT_NOPROXY => '*'],
        ]);

        return $token ? $request->withToken($token) : $request;
    }

    // ── First page search ────────────────────────────────────────────────────

    public function search(string $query): array
    {
        if (empty($this->clientId) || empty($this->tokenUrl) || empty($this->baseUrl)) {
            return $this->emptyResult();
        }

        $cacheKey = 'ip_au_p1_' . md5(strtolower(trim($query)));

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($query) {
            return $this->fetchFirstPage($query);
        });
    }

    private function fetchFirstPage(string $query): array
    {
        try {
            $token = $this->getAccessToken();

            $response = $this->http($token)->post($this->baseUrl . '/search/quick', [
                'query' => $query,
                'sort'  => ['field' => 'NUMBER', 'direction' => 'ASCENDING'],
            ]);

            if ($response->failed()) {
                Log::error('IP Australia search failed', [
                    'query'  => $query,
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
                return $this->emptyResult();
            }

            $json  = $response->json() ?? [];
            $ids   = $this->extractIds($json);
            $total = count($ids);

            if (empty($ids)) {
                return $this->emptyResult();
            }

            // Cache all IDs for subsequent pages
            Cache::put('ip_au_ids_' . md5(strtolower(trim($query))), $ids, self::CACHE_TTL);

            $firstBatch = array_values(array_slice($ids, 0, self::PER_PAGE));
            $results    = $this->fetchDetails($token, $firstBatch);

            return [
                'results' => $results,
                'total'   => $total,
                'loaded'  => count($results),
                'hasMore' => count($results) < $total,
            ];

        } catch (\Exception $e) {
            Log::error('IPAustraliaService error: ' . $e->getMessage());
            return $this->emptyResult();
        }
    }

    // ── Subsequent pages (AJAX) ──────────────────────────────────────────────

    public function searchPage(string $query, int $page): array
    {
        if (empty($this->clientId) || empty($this->tokenUrl) || empty($this->baseUrl)) {
            return $this->emptyResult();
        }

        $ids = Cache::get('ip_au_ids_' . md5(strtolower(trim($query))), []);

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
            $token   = $this->getAccessToken();
            $results = $this->fetchDetails($token, $slice);
            $loaded  = $offset + count($results);

            return [
                'results' => $results,
                'total'   => $total,
                'loaded'  => $loaded,
                'hasMore' => $loaded < $total,
            ];

        } catch (\Exception $e) {
            Log::error('IPAustraliaService searchPage error: ' . $e->getMessage());
            return $this->emptyResult();
        }
    }

    // ── Shared helpers ───────────────────────────────────────────────────────

    private function fetchDetails(string $token, array $ids): array
    {
        $baseUrl = $this->baseUrl;

        $responses = Http::pool(function (\Illuminate\Http\Client\Pool $pool) use ($ids, $token, $baseUrl) {
            return array_map(
                fn ($id) => $pool->withToken($token)
                    ->withOptions(['proxy' => '', 'curl' => [CURLOPT_PROXY => '', CURLOPT_NOPROXY => '*']])
                    ->get($baseUrl . '/trade-mark/' . $id),
                $ids
            );
        });

        $results = [];
        foreach ($responses as $index => $response) {
            if ($response->successful()) {
                $tm = $response->json();
                if (is_array($tm)) {
                    $results[] = $this->mapTrademark($tm, $ids[$index]);
                }
            }
        }

        return array_values(array_filter($results));
    }

    private function emptyResult(): array
    {
        return ['results' => [], 'total' => 0, 'loaded' => 0, 'hasMore' => false];
    }

    private function extractIds(array $data): array
    {
        $items = $data['trademarkIds']       ??
                 $data['tradeMarks']         ??
                 $data['ipRightIdentifiers'] ??
                 $data['data']               ??
                 $data['results']            ??
                 $data;

        if (!is_array($items)) {
            return [];
        }

        $ids = [];
        foreach ($items as $item) {
            if (is_int($item) || is_string($item)) {
                $ids[] = $item;
            } elseif (is_array($item)) {
                $id = $item['ipRightIdentifier'] ?? $item['id'] ?? $item['number'] ?? null;
                if ($id) $ids[] = $id;
            }
        }

        return $ids;
    }

    private function mapTrademark(array $tm, string|int $id): array
    {
        $name = !empty($tm['words']) ? implode(' ', (array) $tm['words']) : ($tm['name'] ?? '');

        return [
            'trademark_number'  => $tm['number']               ?? $id,
            'trademark_name'    => strtoupper($name),
            'status'            => $tm['statusGroup']           ?? $tm['statusCode']        ?? '',
            'owner'             => $this->extractOwner($tm),
            'class'             => $this->extractClasses($tm),
            'application_date'  => $tm['filingDate']            ?? $tm['lodgementDate']     ?? '',
            'registration_date' => $tm['enteredOnRegisterDate'] ?? $tm['registeredFromDate'] ?? '',
        ];
    }

    private function extractOwner(array $tm): string
    {
        $owners = $tm['owner'] ?? $tm['owners'] ?? [];
        if (!empty($owners) && is_array($owners)) {
            $first = $owners[0];
            return is_array($first) ? ($first['name'] ?? '') : (string) $first;
        }
        return $tm['ownerName'] ?? $tm['applicantName'] ?? '';
    }

    private function extractClasses(array $tm): string
    {
        if (!empty($tm['goodsAndServices']) && is_array($tm['goodsAndServices'])) {
            $classes = array_column($tm['goodsAndServices'], 'class');
            if (empty(array_filter($classes))) {
                $classes = array_column($tm['goodsAndServices'], 'classNumber');
            }
            return implode(', ', array_unique(array_filter($classes)));
        }
        if (!empty($tm['classes'])) {
            return implode(', ', (array) $tm['classes']);
        }
        return $tm['class'] ?? '';
    }
}
