@php
    $statusKey = strtoupper($tm['status'] ?? '');
    $badgeClass = match($statusKey) {
        'REGISTERED'       => 'badge-green',
        'PENDING'          => 'badge-orange',
        'NEVER_REGISTERED',
        'REFUSED',
        'REMOVED'          => 'badge-red',
        default            => 'badge-dim',
    };
    $statusLabel = match($statusKey) {
        'REGISTERED'       => 'Registered',
        'PENDING'          => 'Pending',
        'NEVER_REGISTERED' => 'Lapsed',
        'REFUSED'          => 'Refused',
        'REMOVED'          => 'Removed',
        default            => ucfirst(strtolower($statusKey)) ?: 'Unknown',
    };
@endphp
<article class="tm-card tm-card-item">
    <div class="tm-card-head">
        <div class="tm-name-row">
            <h2 class="tm-name">{{ $tm['trademark_name'] ?? '—' }}</h2>
            <span class="badge {{ $badgeClass }}">{{ $statusLabel }}</span>
        </div>
        @if(!empty($tm['owner']))
            <p class="tm-owner">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                {{ $tm['owner'] }}
            </p>
        @endif
    </div>
    <dl class="tm-facts">
        @if(!empty($tm['trademark_number']))
            <div class="tm-fact"><dt>Number</dt><dd>{{ $tm['trademark_number'] }}</dd></div>
        @endif
        @if(!empty($tm['class']))
            <div class="tm-fact"><dt>Class</dt><dd>{{ $tm['class'] }}</dd></div>
        @endif
        @if(!empty($tm['application_date']))
            <div class="tm-fact"><dt>Filed</dt><dd>{{ $tm['application_date'] }}</dd></div>
        @endif
        @if(!empty($tm['registration_date']))
            <div class="tm-fact"><dt>Registered</dt><dd>{{ $tm['registration_date'] }}</dd></div>
        @endif
    </dl>
</article>
