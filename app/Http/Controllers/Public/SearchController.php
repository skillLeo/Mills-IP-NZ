<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Services\IPONZService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function __construct(private IPONZService $iponz) {}

    public function index(): View
    {
        return view('public.search');
    }

    public function results(Request $request): View
    {
        $request->validate([
            'q' => ['required', 'string', 'min:2', 'max:100'],
        ]);

        set_time_limit(60); // API calls can take longer than the default 30s

        $query   = trim($request->input('q'));

        try {
            $data = $this->iponz->search($query);
        } catch (\Exception $e) {
            \Log::error('Search failed: ' . $e->getMessage());
            $data = ['results' => [], 'total' => 0, 'loaded' => 0, 'hasMore' => false, 'apiError' => true];
        }
        $results  = $data['results']  ?? [];
        $total    = $data['total']    ?? count($results);
        $loaded   = $data['loaded']   ?? count($results);
        $hasMore  = $data['hasMore']  ?? false;
        $apiError = $data['apiError'] ?? false;

        return view('public.results', compact('query', 'results', 'total', 'loaded', 'hasMore', 'apiError'));
    }

    public function loadMore(Request $request): JsonResponse
    {
        $request->validate([
            'q'    => ['required', 'string', 'min:2', 'max:100'],
            'page' => ['required', 'integer', 'min:2'],
        ]);

        $query = trim($request->input('q'));
        $page  = (int) $request->input('page');
        $data  = $this->iponz->searchPage($query, $page);

        $html = '';
        foreach ($data['results'] as $tm) {
            $html .= view('public._tm_card', compact('tm'))->render();
        }

        return response()->json([
            'html'    => $html,
            'total'   => $data['total'],
            'loaded'  => $data['loaded'],
            'hasMore' => $data['hasMore'],
        ]);
    }
}
