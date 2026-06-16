@extends('layouts.public')

@section('title', 'Australian Trademark Search — Free & Instant')
@section('meta_description', 'Search the official IP Australia trademark database in real time. Free trademark availability check by Mills IP — Australian trademark attorneys.')

@section('content')

{{-- ─── Hero ─────────────────────────────────────────────────────────────────── --}}
<section class="hero" id="search">
    <div class="hero-bg-glow" aria-hidden="true"></div>
    <div class="container hero-inner">

        <div class="hero-live-badge">
            <span class="live-dot"></span>
            Live IP Australia Database
        </div>

        <h1>Protect Your Brand<br>the Easy Way</h1>

        <p class="hero-sub-tagline">Create &nbsp;&middot;&nbsp; Secure &nbsp;&middot;&nbsp; Maintain</p>

        <p class="hero-lead">
            Before you apply, check whether your brand name is already registered — free, instant, and pulled directly from the official Australian government database.
        </p>

        <div class="hero-flow-hint">
            <span class="hfh-step active">
                <span class="hfh-num">1</span> Search the register
            </span>
            <span class="hfh-arrow">→</span>
            <span class="hfh-step">
                <span class="hfh-num">2</span> Review conflicts
            </span>
            <span class="hfh-arrow">→</span>
            <span class="hfh-step">
                <span class="hfh-num">3</span> Apply with confidence
            </span>
        </div>

        <form action="{{ route('search.results') }}" method="GET" class="hero-search" role="search" id="hero-search-form">
            <div class="hs-wrap">
                <span class="hs-icon" aria-hidden="true">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="7"></circle>
                        <path d="M20 20l-3.5-3.5"></path>
                    </svg>
                </span>
                <input
                    type="text"
                    name="q"
                    class="hs-input"
                    placeholder="Enter a brand name, word, or phrase..."
                    autocomplete="off"
                    spellcheck="false"
                    aria-label="Trademark search query"
                    maxlength="100"
                    value="{{ old('q') }}"
                    required
                >
                <button type="submit" class="hs-btn">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="margin-right:6px"><circle cx="11" cy="11" r="7"/><path d="M20 20l-3.5-3.5"/></svg>
                    Search Trademarks
                </button>
            </div>
            <div class="hs-trust">
                <span>Free to search</span>
                <span>Official registry data</span>
                <span>No account required</span>
            </div>
        </form>

    </div>
</section>

{{-- ─── Stats band ─────────────────────────────────────────────────────────────── --}}
<section class="stats-band">
    <div class="container stats-grid">
        <div class="stat-item">
            <strong>2M+</strong>
            <span>Trademark records</span>
        </div>
        <div class="stat-divider" aria-hidden="true"></div>
        <div class="stat-item">
            <strong>Free</strong>
            <span>Always free to search</span>
        </div>
        <div class="stat-divider" aria-hidden="true"></div>
        <div class="stat-item">
            <strong>1 day</strong>
            <span>Quote turnaround</span>
        </div>
        <div class="stat-divider" aria-hidden="true"></div>
        <div class="stat-item">
            <strong>100%</strong>
            <span>Official government data</span>
        </div>
    </div>
</section>

{{-- ─── How it works ────────────────────────────────────────────────────────────── --}}
<section class="hiw-section" id="how-it-works">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">How It Works</span>
            <h2>From search to registration<br>in three straightforward steps</h2>
            <p>No jargon, no confusion. Mills IP makes the trademark process clear and accessible for every Australian business.</p>
        </div>

        <div class="hiw-grid">
            <article class="hiw-card">
                <div class="hiw-num-wrap">
                    <span class="hiw-num">01</span>
                    <div class="hiw-track" aria-hidden="true"></div>
                </div>
                <div class="hiw-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="7"></circle>
                        <path d="M20 20l-3.5-3.5"></path>
                    </svg>
                </div>
                <h3>Search the register</h3>
                <p>Enter your proposed brand name and instantly see matching and similar records pulled directly from IP Australia's official database.</p>
            </article>

            <article class="hiw-card">
                <div class="hiw-num-wrap">
                    <span class="hiw-num">02</span>
                    <div class="hiw-track" aria-hidden="true"></div>
                </div>
                <div class="hiw-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                    </svg>
                </div>
                <h3>Review the results</h3>
                <p>Results show owner, trademark class, status, and key dates. Assess whether conflicts exist before committing to registration.</p>
            </article>

            <article class="hiw-card">
                <div class="hiw-num-wrap">
                    <span class="hiw-num">03</span>
                </div>
                <div class="hiw-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                </div>
                <h3>Submit your application</h3>
                <p>Complete the five-step form. A Mills IP attorney reviews your application and sends a clear fixed fee quote within one business day.</p>
            </article>
        </div>

        <div class="hiw-cta">
            <a href="{{ route('search') }}?apply=1#search" class="btn-solid" id="hiw-start-btn">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="7"/><path d="M20 20l-3.5-3.5"/></svg>
                Search to Get Started
            </a>
            <span class="hiw-note">Always search before you apply</span>
        </div>
    </div>
</section>

{{-- ─── Why Mills IP ─────────────────────────────────────────────────────────── --}}
<section class="why-section">
    <div class="container">
        <div class="section-header section-header--center">
            <span class="section-tag">Why Mills IP</span>
            <h2>Everything you need to protect<br>your Australian trademark</h2>
        </div>

        <div class="why-grid">
            <div class="why-card">
                <div class="why-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <h4>Official government data</h4>
                <p>Search results come directly from IP Australia via OAuth 2.0 — the same database used by attorneys nationwide.</p>
            </div>
            <div class="why-card">
                <div class="why-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                </div>
                <h4>Fixed fee, no surprises</h4>
                <p>You receive a clear, all-inclusive fixed fee quote before any commitment. No hidden costs, no hourly billing.</p>
            </div>
            <div class="why-card">
                <div class="why-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <h4>Response in 1 business day</h4>
                <p>Our attorneys review every application personally and respond with a quote within one business day — no automated systems.</p>
            </div>
            <div class="why-card">
                <div class="why-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </div>
                <h4>Australian specialists</h4>
                <p>Mills IP attorneys are specialists in Australian intellectual property law — not generalists. Your trademark gets expert attention.</p>
            </div>
            <div class="why-card">
                <div class="why-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                </div>
                <h4>Secure and private</h4>
                <p>All submitted information is encrypted and stored securely. Your application data is private and only accessible to the Mills IP team.</p>
            </div>
            <div class="why-card">
                <div class="why-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                </div>
                <h4>Full-service filing</h4>
                <p>From application to lodgement with IP Australia — Mills IP handles the complete trademark registration process on your behalf.</p>
            </div>
        </div>
    </div>
</section>

{{-- ─── CTA Band ───────────────────────────────────────────────────────────────── --}}
<section class="cta-band">
    <div class="container cta-inner">
        <div class="cta-copy">
            <h2>Ready to protect your brand?</h2>
            <p>Search the trademark register for free, then start your application in minutes. A Mills IP attorney will take it from there.</p>
        </div>
        <div class="cta-actions">
            <a href="#search" class="btn-ghost" id="cta-search-btn">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="7"/><path d="M20 20l-3.5-3.5"/></svg>
                Search the Register
            </a>
            <a href="{{ route('search') }}?apply=1#search" class="btn-solid-white" id="cta-apply-btn">
                Start Application
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </a>
        </div>
    </div>
</section>

@endsection
