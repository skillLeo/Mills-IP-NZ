@extends('layouts.admin')

@section('title', 'Applications')

@section('content')
<div class="admin-shell">

    @include('admin._sidebar')

    <main class="admin-main">
        <header class="admin-topbar">
            <div>
                <div class="admin-page-eyebrow">Admin Workspace</div>
                <h1>Applications</h1>
            </div>
            <span class="admin-page-meta">{{ now()->format('d M Y') }}</span>
        </header>

        @if(session('success'))
            <div class="flash flash--success">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Search --}}
        <form method="GET" action="{{ route('admin.application.index') }}" id="dashForm" class="dash-filters">
            <div class="dash-search-wrap">
                <svg class="dash-search-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="7"/><path d="M20 20l-3.5-3.5"/></svg>
                <input type="text" name="search" id="dashSearch" class="dash-search" placeholder="Search by name, email, or trademark…" value="{{ request('search') }}" autocomplete="off">
                <button type="button" id="dashClear" class="dash-search-clear" title="Clear search" style="{{ request('search') ? '' : 'display:none' }}">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>
            <select name="status" id="dashStatus" class="dash-select">
                <option value="">All Statuses</option>
                @foreach($statuses as $s)
                    <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ $s }}</option>
                @endforeach
            </select>
        </form>

        {{-- Results --}}
        <div id="results-area">
            @include('admin._applications-table')
        </div>

    </main>
</div>

@push('scripts')
<script>
(function () {
    var input    = document.getElementById('dashSearch');
    var clearBtn = document.getElementById('dashClear');
    var select   = document.getElementById('dashStatus');
    var area     = document.getElementById('results-area');
    var timer;
    var BASE     = '/admin/applications';

    function buildUrl() {
        var p  = new URLSearchParams();
        var s  = input ? input.value.trim() : '';
        var st = select ? select.value : '';
        if (s)  p.set('search', s);
        if (st) p.set('status', st);
        var qs = p.toString();
        return BASE + (qs ? '?' + qs : '');
    }

    function loadUrl(url) {
        area.style.opacity = '0.45';
        area.style.transition = 'opacity 0.12s';
        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(function (r) { return r.text(); })
            .then(function (html) {
                area.innerHTML = html;
                area.style.opacity = '1';
                history.replaceState(null, '', url);
            })
            .catch(function () { area.style.opacity = '1'; });
    }

    function syncClear() {
        if (clearBtn) clearBtn.style.display = (input && input.value) ? 'flex' : 'none';
    }

    function run() { syncClear(); loadUrl(buildUrl()); }

    if (input)    input.addEventListener('input', function () { clearTimeout(timer); timer = setTimeout(run, 350); });
    if (clearBtn) clearBtn.addEventListener('click', function () { input.value = ''; run(); });
    if (select)   select.addEventListener('change', run);

    // Pagination inside results area
    area.addEventListener('click', function (e) {
        var link = e.target.closest('a[href*="/admin/applications"]');
        if (!link || link.classList.contains('btn-view')) return;
        e.preventDefault();
        var url = link.href;
        var params = new URL(url, location.origin).searchParams;
        if (input)  input.value  = params.get('search') || '';
        if (select) select.value = params.get('status') || '';
        syncClear();
        loadUrl(url);
    });

    // Delete — AJAX with SweetAlert2 confirmation
    var csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    area.addEventListener('click', function (e) {
        var btn = e.target.closest('.btn-icon-delete');
        if (!btn) return;
        e.preventDefault();

        var row = btn.closest('tr');
        var id  = btn.dataset.id;

        Swal.fire({
            title: 'Delete application?',
            text: 'This cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, delete it',
            cancelButtonText: 'Cancel',
            borderRadius: '14px',
            customClass: {
                popup:         'swal-popup',
                title:         'swal-title',
                htmlContainer: 'swal-text',
                confirmButton: 'swal-btn-confirm',
                cancelButton:  'swal-btn-cancel',
            }
        }).then(function (result) {
            if (!result.isConfirmed) return;

            row.style.opacity = '0.4';

            fetch(BASE + '/' + id, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                if (data.success) {
                    row.style.transition = 'opacity 0.25s';
                    row.style.opacity = '0';
                    setTimeout(function () {
                        row.remove();
                        var countEl = area.querySelector('.tbl-count');
                        if (countEl) {
                            var match = countEl.textContent.match(/[\d,]+/);
                            if (match) {
                                var n = parseInt(match[0].replace(/,/g, ''), 10) - 1;
                                countEl.textContent = n.toLocaleString() + ' result' + (n !== 1 ? 's' : '');
                            }
                        }
                    }, 280);
                    Swal.fire({
                        title: 'Deleted',
                        text: 'The application has been removed.',
                        icon: 'success',
                        timer: 1800,
                        showConfirmButton: false,
                        customClass: { popup: 'swal-popup' }
                    });
                }
            })
            .catch(function () { row.style.opacity = '1'; });
        });
    });
})();
</script>
@endpush
@endsection
