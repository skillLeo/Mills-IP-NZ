@if($applications->isEmpty())
    <div class="dash-empty">
        <svg width="38" height="38" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M22 12h-6l-2 3h-4l-2-3H2"/><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/></svg>
        <p>No applications found.</p>
    </div>
@else
    <div class="tbl-header">
        <span class="tbl-count">
            {{ number_format($applications->total()) }} result{{ $applications->total() !== 1 ? 's' : '' }}
            @if($applications->total() > $applications->perPage())
                — showing {{ $applications->firstItem() }}–{{ $applications->lastItem() }}
            @endif
        </span>
    </div>

    <div class="dash-table-wrap">
        <table class="dash-table">
            <thead>
                <tr>
                    <th style="width:52px">#</th>
                    <th>Trademark</th>
                    <th>Legal Owner</th>
                    <th>Contact</th>
                    <th style="width:120px">Status</th>
                    <th style="width:130px">Submitted</th>
                    <th style="width:140px"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($applications as $app)
                <tr>
                    <td class="td-id">#{{ $app->id }}</td>
                    <td class="td-trademark">{{ Str::limit($app->trademark_description, 42) }}</td>
                    <td class="td-owner">{{ $app->legal_owner_name }}</td>
                    <td class="td-contact">
                        <div class="td-contact-name">{{ $app->contact_name }}</div>
                        <div class="td-email">{{ $app->contact_email }}</div>
                    </td>
                    <td>
                        <span class="status-badge status-{{ strtolower(str_replace(' ','-',$app->status)) }}">{{ $app->status }}</span>
                    </td>
                    <td class="td-date">{{ $app->submitted_at ? $app->submitted_at->format('d M Y') : '—' }}</td>
                    <td class="td-actions">
                        <div class="tbl-actions-wrap">
                            <a href="{{ route('admin.application.show', $app->id) }}" class="btn-view">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                View
                            </a>
                            <button class="btn-icon-delete" data-id="{{ $app->id }}" type="button" title="Delete">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="dash-pagination">
        {{ $applications->links('admin.pagination') }}
    </div>
@endif
