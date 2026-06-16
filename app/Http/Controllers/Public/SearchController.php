<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Services\IPAustraliaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function __construct(private IPAustraliaService $ipAustralia) {}

    public function index(): View
    {
        return view('public.search');
    }

    public function results(Request $request): View
    {
        $request->validate([
            'q' => ['required', 'string', 'min:2', 'max:100'],
        ]);

        $query   = trim($request->input('q'));
        $data    = $this->ipAustralia->search($query);
        $results = $data['results'] ?? [];
        $total   = $data['total']   ?? count($results);
        $loaded  = $data['loaded']  ?? count($results);
        $hasMore = $data['hasMore'] ?? false;

        return view('public.results', compact('query', 'results', 'total', 'loaded', 'hasMore'));
    }

    public function loadMore(Request $request): JsonResponse
    {
        $request->validate([
            'q'    => ['required', 'string', 'min:2', 'max:100'],
            'page' => ['required', 'integer', 'min:2'],
        ]);

        $query = trim($request->input('q'));
        $page  = (int) $request->input('page');
        $data  = $this->ipAustralia->searchPage($query, $page);

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
