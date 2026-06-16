@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="admin-shell">

    @include('admin._sidebar')

    <main class="admin-main">
        <header class="admin-topbar">
            <div>
                <div class="admin-page-eyebrow">Overview</div>
                <h1>Dashboard</h1>
            </div>
            <span class="admin-page-meta">{{ now()->format('d M Y') }}</span>
        </header>

        {{-- KPI cards --}}
        <div class="kpi-grid">
            <div class="kpi-card">
                <div class="kpi-icon kpi-icon--total">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                </div>
                <div class="kpi-body">
                    <strong class="kpi-value">{{ $total }}</strong>
                    <span class="kpi-label">Total Applications</span>
                </div>
            </div>
            <div class="kpi-card">
                <div class="kpi-icon kpi-icon--week">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                </div>
                <div class="kpi-body">
                    <strong class="kpi-value">{{ $thisWeek }}</strong>
                    <span class="kpi-label">This Week</span>
                </div>
            </div>
            <div class="kpi-card">
                <div class="kpi-icon kpi-icon--review">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                </div>
                <div class="kpi-body">
                    <strong class="kpi-value">{{ $needsReview }}</strong>
                    <span class="kpi-label">Needs Review</span>
                </div>
            </div>
            <div class="kpi-card">
                <div class="kpi-icon kpi-icon--done">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
                <div class="kpi-body">
                    <strong class="kpi-value">{{ $counts['Completed'] ?? 0 }}</strong>
                    <span class="kpi-label">Completed</span>
                </div>
            </div>
        </div>

        {{-- Status cards --}}
        @php
        $statusIcons = [
            'Received'  => '<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 12h-6l-2 3h-4l-2-3H2"/><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/></svg>',
            'Reviewing' => '<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>',
            'Quoted'    => '<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>',
            'Filed'     => '<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>',
            'Completed' => '<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>',
            'On Hold'   => '<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="10" y1="15" x2="10" y2="9"/><line x1="14" y1="15" x2="14" y2="9"/></svg>',
            'Rejected'  => '<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>',
        ];
        @endphp
        <div class="status-counts">
            @foreach(['Received','Reviewing','Quoted','Filed','Completed','On Hold','Rejected'] as $s)
                <a href="{{ route('admin.application.index', ['status' => $s]) }}"
                   class="sc-item sc-{{ strtolower(str_replace(' ','-',$s)) }}">
                    <span class="sc-icon-wrap">{!! $statusIcons[$s] !!}</span>
                    <strong>{{ $counts[$s] ?? 0 }}</strong>
                    <span>{{ $s }}</span>
                </a>
            @endforeach
        </div>

        {{-- Recent submissions --}}
        <div class="detail-card">
            <h3 class="detail-card-title">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 12h-6l-2 3h-4l-2-3H2"/><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/></svg>
                Recent Submissions
            </h3>
            @if($recent->isEmpty())
                <p class="notes-empty">No applications yet.</p>
            @else
                <div class="recent-list">
                    @foreach($recent as $app)
                    <a href="{{ route('admin.application.show', $app->id) }}" class="recent-item">
                        <div class="recent-item-main">
                            <div class="recent-item-name">{{ $app->legal_owner_name }}</div>
                            <div class="recent-item-tm">{{ Str::limit($app->trademark_description, 60) }}</div>
                        </div>
                        <span class="status-badge status-{{ strtolower(str_replace(' ','-',$app->status)) }}">{{ $app->status }}</span>
                        <span class="recent-item-date">{{ $app->submitted_at ? $app->submitted_at->format('d M Y') : '—' }}</span>
                    </a>
                    @endforeach
                </div>
                <a href="{{ route('admin.application.index') }}" class="dash-all-link">View all applications →</a>
            @endif
        </div>

    </main>
</div>
@endsection
