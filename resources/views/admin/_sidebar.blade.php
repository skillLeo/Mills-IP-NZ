<aside class="admin-sidebar">
    <div class="sidebar-top">
        <a href="{{ route('admin.dashboard') }}" class="admin-logo">
            <img src="{{ asset('images/logo.png') }}" alt="TM.com.au" class="sidebar-logo-img">
        </a>

        <div class="sidebar-section-label">Navigation</div>
        <nav class="admin-nav">
            <a href="{{ route('admin.dashboard') }}" class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                Dashboard
            </a>
            <a href="{{ route('admin.application.index') }}" class="admin-nav-link {{ request()->routeIs('admin.application.*') ? 'active' : '' }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                Applications
            </a>
        </nav>
    </div>

    <div class="sidebar-bottom">
        <div class="sidebar-user">
            <div class="sidebar-avatar">{{ strtoupper(substr(Auth::guard('admin')->user()->name, 0, 1)) }}</div>
            <div class="sidebar-user-info">
                <strong>{{ Auth::guard('admin')->user()->name }}</strong>
                <span>Administrator</span>
            </div>
        </div>
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="admin-logout-btn">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                Sign Out
            </button>
        </form>
    </div>
</aside>
