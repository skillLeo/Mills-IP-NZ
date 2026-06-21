<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'Search the official IPONZ trademark register in real time. Mills IP NZ — New Zealand Trademark Attorneys.')">
    <title>@yield('title', 'Mills IP NZ') | Trademarks and Brand Protection</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&family=Inter:ital,wght@0,400;0,500;0,600;0,700;1,400&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>
<body>

<nav class="site-nav" role="navigation" aria-label="Main navigation">
    <div class="container nav-inner">
        <a href="{{ route('search') }}" class="nav-logo">
            <img src="{{ asset('images/logo.png') }}" alt="Mills IP NZ" class="nav-logo-img">
        </a>
        <div class="nav-links" id="nav-links">
            <a href="{{ route('search') }}" class="nav-link">Search Trademarks</a>
            <a href="{{ route('search') }}#how-it-works" class="nav-link">How It Works</a>
            @unless(request()->routeIs('apply.*'))
                <a href="{{ route('apply.step1') }}" class="nav-cta" id="nav-start-btn">
                    Start Application
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </a>
            @endunless
        </div>
        <button class="nav-mobile-btn" id="nav-toggle" aria-label="Open navigation menu">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
        </button>
    </div>
    <div class="nav-mobile-menu" id="nav-mobile">
        <a href="{{ route('search') }}">Search Trademarks</a>
        <a href="{{ route('search') }}#how-it-works">How It Works</a>
        <a href="{{ route('apply.step1') }}">Start Application</a>
    </div>
</nav>

<main role="main">
    @yield('content')
</main>

<footer class="site-footer" role="contentinfo">
    <div class="footer-main">
        <div class="container footer-grid">
            <div class="footer-brand">
                <a href="{{ route('search') }}" class="footer-logo">
                    <img src="{{ asset('images/logo.png') }}" alt="Mills IP NZ" class="footer-logo-img">
                </a>
                <p class="footer-tagline">New Zealand trademark attorneys. Search the official IPONZ register and apply for trademark registration with expert attorney support.</p>

                <div class="footer-badges">
                    <span>IPONZ Registered</span>
                    <span>NZ Attorneys</span>
                </div>
            </div>
            <div class="footer-col">
                <h4>Platform</h4>
                <ul>
                    <li><a href="{{ route('search') }}">Trademark Search</a></li>
                    <li><a href="{{ route('apply.step1') }}">Start an Application</a></li>
                    <li><a href="{{ route('search') }}#how-it-works">How It Works</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Services</h4>
                <ul>
                    <li><a href="{{ route('apply.step1') }}">Trademark Registration</a></li>
                    <li><a href="{{ route('apply.step1') }}">Fixed Fee Quotes</a></li>
                    <li><a href="{{ route('apply.step1') }}">Attorney Review</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Company</h4>
                <ul>
                    <li><a href="{{ route('admin.login') }}">Team Login</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms of Service</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer-bar">
        <div class="container footer-bar-inner">
            <p>&copy; {{ date('Y') }} Mills IP NZ. All rights reserved.</p>
            <p>Legal services provided by Mills IP NZ Ltd. New Zealand trademark attorneys. Liability limited by a scheme approved under Professional Standards Legislation.</p>
        </div>
    </div>
</footer>

<script>
(function() {
    // Mobile nav toggle
    var toggleBtn = document.getElementById('nav-toggle');
    var mobileMenu = document.getElementById('nav-mobile');
    if (toggleBtn && mobileMenu) {
        toggleBtn.addEventListener('click', function() {
            mobileMenu.classList.toggle('open');
        });
    }

    // Pulse the search bar
    function pulseSearchBar() {
        var row = document.querySelector('.hs-row') || document.querySelector('.hs-wrap');
        var input = document.querySelector('.hs-input');
        if (!row) return;
        row.classList.remove('search-pulse');
        void row.offsetWidth;
        row.classList.add('search-pulse');
        if (input) input.focus();
        setTimeout(function() { row.classList.remove('search-pulse'); }, 2500);
    }

    // "Start an application" hero link → scroll to search + pulse (search first)
    var heroApplyLink = document.getElementById('hero-apply-link');
    if (heroApplyLink) {
        heroApplyLink.addEventListener('click', function(e) {
            e.preventDefault();
            var form = document.getElementById('hero-search-form');
            if (form) {
                form.scrollIntoView({ behavior: 'smooth', block: 'center' });
                setTimeout(pulseSearchBar, 600);
            }
        });
    }

    // Nav "Start Application" → scroll to hero search + pulse
    var startBtn = document.getElementById('nav-start-btn');
    if (startBtn) {
        startBtn.addEventListener('click', function(e) {
            var form = document.getElementById('hero-search-form');
            if (form) {
                e.preventDefault();
                form.scrollIntoView({ behavior: 'smooth', block: 'center' });
                setTimeout(pulseSearchBar, 700);
            }
        });
    }

    // CTA "Search the Register" → scroll to hero search + pulse
    var ctaBtn = document.getElementById('cta-search-btn');
    if (ctaBtn) {
        ctaBtn.addEventListener('click', function(e) {
            var form = document.getElementById('hero-search-form');
            if (form) {
                e.preventDefault();
                form.scrollIntoView({ behavior: 'smooth', block: 'center' });
                setTimeout(pulseSearchBar, 700);
            }
        });
    }

    // If navigated from another page via ?apply=1
    if (window.location.search.indexOf('apply=1') !== -1) {
        window.addEventListener('load', function() {
            var form = document.getElementById('hero-search-form');
            if (form) {
                setTimeout(function() {
                    form.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    setTimeout(pulseSearchBar, 700);
                }, 200);
            }
        });
    }
})();
</script>
@stack('scripts')
</body>
</html>
