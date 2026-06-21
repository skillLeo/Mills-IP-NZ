@extends('layouts.admin')

@section('title', 'Application #' . $application->id)

@section('content')
<div class="admin-shell">

    @include('admin._sidebar')

    <main class="admin-main">

        <header class="admin-topbar">
            <div>
                <a href="{{ route('admin.application.index') }}" class="back-link">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
                    All Applications
                </a>
                <h1>Application <span class="h1-id">#{{ $application->id }}</span></h1>
            </div>
            <div class="topbar-right">
                <span class="topbar-date">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    {{ $application->submitted_at ? $application->submitted_at->format('d M Y') : 'No date' }}
                </span>
                <span class="status-badge status-{{ strtolower(str_replace(' ','-',$application->status)) }} status-badge--lg">{{ $application->status }}</span>
            </div>
        </header>

        @if(session('success'))
            <div class="flash flash--success">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('info'))
            <div class="flash flash--info">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                {{ session('info') }}
            </div>
        @endif

        <div class="detail-grid">

            {{-- ── Left: Application data ──────────────────────────────── --}}
            <div class="detail-left">

                {{-- Card: Trademark & Business --}}
                <div class="detail-card">
                    <h3 class="detail-card-title">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        Trademark
                    </h3>

                    <div class="detail-block">
                        <div class="detail-block-label">Trademark Description</div>
                        <div class="detail-block-text">{{ $application->trademark_description }}</div>
                        @if($application->logo_file_path)
                            <div class="detail-logo-wrap">
                                <img src="{{ route('admin.application.logo', $application->id) }}" alt="Trademark logo" class="detail-logo-img">
                            </div>
                        @endif
                    </div>

                    <div class="detail-divider"></div>

                    <div class="detail-block">
                        <div class="detail-block-label">Business Description</div>
                        <div class="detail-block-text">{{ $application->business_description }}</div>
                    </div>

                    @if($application->additional_notes)
                        <div class="detail-divider"></div>
                        <div class="detail-block">
                            <div class="detail-block-label">Notes from Applicant</div>
                            <div class="detail-block-text detail-block-text--muted">{{ $application->additional_notes }}</div>
                        </div>
                    @endif
                </div>

                {{-- Card: Owner & Contact --}}
                <div class="detail-card">
                    <h3 class="detail-card-title">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        Owner & Contact
                    </h3>

                    <div class="detail-fields">
                        <div class="detail-field">
                            <span class="df-label">Legal Owner</span>
                            <span class="df-value">{{ $application->legal_owner_name }}</span>
                        </div>
                        <div class="detail-field">
                            <span class="df-label">Owner Type</span>
                            <span class="df-value">{{ ucfirst($application->legal_owner_type) }}</span>
                        </div>
                        <div class="detail-field">
                            <span class="df-label">NZBN</span>
                            <span class="df-value">{{ $application->abn ?: '—' }}</span>
                        </div>
                    </div>

                    <div class="detail-divider"></div>

                    <div class="detail-fields">
                        <div class="detail-field">
                            <span class="df-label">Contact Name</span>
                            <span class="df-value">{{ $application->contact_name }}</span>
                        </div>
                        <div class="detail-field">
                            <span class="df-label">Email</span>
                            <span class="df-value">
                                <a href="mailto:{{ $application->contact_email }}" class="df-link">{{ $application->contact_email }}</a>
                            </span>
                        </div>
                        <div class="detail-field">
                            <span class="df-label">Phone</span>
                            <span class="df-value">
                                <a href="tel:{{ $application->contact_phone }}" class="df-link">{{ $application->contact_phone }}</a>
                            </span>
                        </div>
                        <div class="detail-field">
                            <span class="df-label">Submitted</span>
                            <span class="df-value">{{ $application->submitted_at ? $application->submitted_at->format('d M Y, g:ia') : '—' }}</span>
                        </div>
                    </div>
                </div>

            </div>

            {{-- ── Right: Actions & activity ───────────────────────────── --}}
            <div class="detail-right">

                {{-- Card: Status --}}
                <div class="detail-card">
                    <h3 class="detail-card-title">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                        Status
                    </h3>
                    <div class="current-status-wrap">
                        <span class="status-badge status-{{ strtolower(str_replace(' ','-',$application->status)) }} status-badge--lg">{{ $application->status }}</span>
                    </div>
                    <form action="{{ route('admin.application.status', $application->id) }}" method="POST" style="margin-top:16px">
                        @csrf
                        <select name="status" class="status-select">
                            @foreach($statuses as $s)
                                <option value="{{ $s }}" {{ $application->status === $s ? 'selected' : '' }}>{{ $s }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="status-submit">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                            Update Status
                        </button>
                    </form>
                </div>

                {{-- Card: Internal Notes --}}
                <div class="detail-card">
                    <h3 class="detail-card-title">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        Internal Notes
                    </h3>

                    <form action="{{ route('admin.application.note', $application->id) }}" method="POST" class="note-form">
                        @csrf
                        <textarea name="note_text" class="note-textarea" placeholder="Add an internal note visible only to the team…" rows="3" required></textarea>
                        @error('note_text')<span class="form-error">{{ $message }}</span>@enderror
                        <button type="submit" class="note-submit">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                            Save Note
                        </button>
                    </form>

                    @if($application->notes->isEmpty())
                        <p class="notes-empty">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                            No notes yet.
                        </p>
                    @else
                        <div class="notes-list">
                            @foreach($application->notes->sortByDesc('created_at') as $note)
                            <div class="note-item">
                                <div class="note-meta">
                                    <div class="note-author">
                                        <span class="note-avatar">{{ strtoupper(substr($note->adminUser->name ?? 'A', 0, 1)) }}</span>
                                        <strong>{{ $note->adminUser->name ?? 'Admin' }}</strong>
                                    </div>
                                    <span>{{ $note->created_at->format('d M Y, g:ia') }}</span>
                                </div>
                                <p>{{ $note->note_text }}</p>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>
        </div>

        {{-- ── Full-width: Audit History timeline ─────────────────────── --}}
        <div class="detail-card detail-card--timeline">
            <h3 class="detail-card-title">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                Audit History
            </h3>

            @if($application->history->isEmpty())
                <p class="notes-empty">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    No activity recorded yet.
                </p>
            @else
                <div class="timeline">
                    @foreach($application->history->sortByDesc('created_at') as $entry)
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="timeline-body">
                            <div class="timeline-action">{{ $entry->action }}</div>
                            @if($entry->old_value || $entry->new_value)
                            <div class="timeline-change">
                                @if($entry->old_value)<span class="old-val">{{ $entry->old_value }}</span> <span class="timeline-arrow">→</span> @endif
                                @if($entry->new_value)<span class="new-val">{{ $entry->new_value }}</span>@endif
                            </div>
                            @endif
                            <div class="timeline-meta">
                                {{ $entry->adminUser->name ?? 'Admin' }} &middot; {{ \Carbon\Carbon::parse($entry->created_at)->format('d M Y, g:ia') }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>

    </main>
</div>
@endsection
