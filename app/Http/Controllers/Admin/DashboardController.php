<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;

class DashboardController extends Controller
{
    public function index()
    {
        $total       = Application::count();
        $thisWeek    = Application::where('submitted_at', '>=', now()->startOfWeek())->count();
        $needsReview = Application::whereIn('status', ['Received', 'Reviewing'])->count();

        $counts = Application::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $recent = Application::orderBy('submitted_at', 'desc')->limit(8)->get();

        return view('admin.dashboard', compact('total', 'thisWeek', 'needsReview', 'counts', 'recent'));
    }
}
