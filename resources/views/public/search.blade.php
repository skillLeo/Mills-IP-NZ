@extends('layouts.public')

@section('title', 'New Zealand Trademark Search')
@section('meta_description', 'Search the official IPONZ trademark register in real time. Free, instant, and directly from the government database. Mills IP NZ — New Zealand Trademark Attorneys.')

@section('content')

<section class="hero" id="search">
    <div class="container">
        <div class="hero-split">

            {{-- LEFT: Heading + copy --}}
            <div class="hero-left">
                <div class="hero-eyebrow">
                    <span class="live-dot"></span>
                    Live IPONZ Register
                </div>

                <h1>Protect Your<br>Brand in <em>New Zealand</em></h1>

                <p class="hero-desc">Expert trademark attorneys. Official government data. Fixed fee quotes within one business day.</p>

                <div class="hero-trust">
                    <span class="hti">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                        Free to search
                    </span>
                    <span class="hti">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                        No account required
                    </span>
                    <span class="hti">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                        Official IPONZ data
                    </span>
                </div>

                <a href="#hero-search-form" class="hero-apply-link" id="hero-apply-link">
                    Start an application
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                </a>
            </div>

            {{-- RIGHT: Search card --}}
            <div class="hero-right">
                <div class="hero-search-card" id="hero-search-form">

                    <div class="hsc-header">
                        <div class="hsc-title">Search the trademark register</div>
                        <div class="hsc-sub">Check if your brand name is available in New Zealand</div>
                    </div>

                    <div class="hsc-search-wrap">
                    <form action="{{ route('search.results') }}" method="GET" role="search">
                        <div class="hs-row">
                            <span class="hs-icon" aria-hidden="true">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="11" cy="11" r="7"/><path d="M20 20l-3.5-3.5"/>
                                </svg>
                            </span>
                            <input
                                type="text" name="q" class="hs-input"
                                placeholder="Brand name, e.g. Kiwi Coffee..."
                                autocomplete="off" spellcheck="false"
                                aria-label="Trademark search query"
                                maxlength="100" value="{{ old('q') }}" required
                            >
                            <button type="submit" class="hs-submit">
                                Search
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                            </button>
                        </div>
                    </form>
                    </div>

                    <div class="hsc-stats">
                        <div class="hcs-item">
                            <strong>2M+</strong>
                            <span>IPONZ records</span>
                        </div>
                        <div class="hcs-divider"></div>
                        <div class="hcs-item">
                            <strong>1 Day</strong>
                            <span>Quote turnaround</span>
                        </div>
                        <div class="hcs-divider"></div>
                        <div class="hcs-item">
                            <strong>100%</strong>
                            <span>Official data</span>
                        </div>
                    </div>

                    <div class="hsc-footer">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        Free search. No account or payment required to check availability.
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

{{-- PROCESS --}}
<section class="process-section" id="how-it-works">
    <div class="container">

        <div class="section-header">
            <span class="section-tag">How It Works</span>
            <h2>Three steps to trademark registration</h2>
            <p>No jargon, no confusion. Mills IP NZ guides you clearly from your first search through to final registration.</p>
        </div>

        <div class="process-grid">

            <div class="process-card">
                <div class="pc-step-row">
                    <span class="pc-step-num">01</span>
                    <div class="pc-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="7"/><path d="M20 20l-3.5-3.5"/>
                        </svg>
                    </div>
                </div>
                <h3>Search the Register</h3>
                <p>Enter your proposed brand name and instantly see matching records from the IPONZ live register. No login, no delays, no cost.</p>
                <a href="#search" class="pc-link">
                    Start searching
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                </a>
            </div>

            <div class="process-arrow">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polyline points="9 18 15 12 9 6"/></svg>
            </div>

            <div class="process-card">
                <div class="pc-step-row">
                    <span class="pc-step-num">02</span>
                    <div class="pc-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                            <line x1="16" y1="13" x2="8" y2="13"/>
                            <line x1="16" y1="17" x2="8" y2="17"/>
                        </svg>
                    </div>
                </div>
                <h3>Review the Results</h3>
                <p>Results show the trademark owner, class, status, and key dates. Assess conflicts and determine your brand's availability before filing.</p>
                <span class="pc-note">Includes registered, pending, and lapsed marks</span>
            </div>

            <div class="process-arrow">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polyline points="9 18 15 12 9 6"/></svg>
            </div>

            <div class="process-card process-card--accent">
                <div class="pc-step-row">
                    <span class="pc-step-num pc-step-num--light">03</span>
                    <div class="pc-icon pc-icon--gold">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="9 11 12 14 22 4"/>
                            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
                        </svg>
                    </div>
                </div>
                <h3>Submit Your Application</h3>
                <p>Complete the five-step form in minutes. A Mills IP NZ attorney reviews your application and provides a fixed fee quote within one business day.</p>
                <a href="{{ route('apply.step1') }}" class="pc-link pc-link--gold">
                    Start application
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                </a>
            </div>

        </div>

    </div>
</section>

{{-- FEATURES --}}
<section class="features-section">
    <div class="container">

        <div class="features-header">
            <div>
                <span class="section-tag">Why Mills IP NZ</span>
                <h2>Expert trademark protection<br>for New Zealand businesses</h2>
            </div>
            <div class="features-header-right">
                <p>Real-time IPONZ access combined with dedicated IP attorney oversight. Your trademark is handled accurately from first search to final registration.</p>
                <a href="{{ route('apply.step1') }}" class="btn-outline-gold">
                    Start an Application
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                </a>
            </div>
        </div>

        <div class="features-grid">
            <div class="feature-card">
                <div class="fc-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
                <h4>Official government data</h4>
                <p>Search results come directly from IPONZ, the same register used by IP practitioners across New Zealand.</p>
            </div>
            <div class="feature-card">
                <div class="fc-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg></div>
                <h4>Fixed fee, no surprises</h4>
                <p>A clear, all-inclusive fixed fee quote before any commitment. No hidden costs, no hourly billing.</p>
            </div>
            <div class="feature-card">
                <div class="fc-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
                <h4>Response in 1 business day</h4>
                <p>Our attorneys review every application personally and respond with a fixed fee quote within one business day.</p>
            </div>
            <div class="feature-card">
                <div class="fc-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div>
                <h4>NZ IP specialists</h4>
                <p>Dedicated New Zealand intellectual property experts. Your trademark receives focused, specialist attention.</p>
            </div>
            <div class="feature-card">
                <div class="fc-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg></div>
                <h4>Full-service filing</h4>
                <p>From application to IPONZ lodgement, Mills IP NZ handles the complete registration process on your behalf.</p>
            </div>
            <div class="feature-card">
                <div class="fc-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg></div>
                <h4>Plain-English advice</h4>
                <p>We explain your options clearly so you can make informed decisions about protecting your brand.</p>
            </div>
        </div>

    </div>
</section>

{{-- CTA --}}
<section class="cta-section">
    <div class="container">
        <div class="cta-box">
            <div class="cta-box-left">
                <div class="cta-box-label">Get Started Today</div>
                <h2>Ready to protect<br>your brand?</h2>
                <p>Search the IPONZ register for free, then start your application in minutes. A Mills IP NZ attorney takes care of everything from there.</p>
            </div>
            <div class="cta-box-right">
                <a href="#search" class="cta-primary-btn" id="cta-search-btn">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="7"/><path d="M20 20l-3.5-3.5"/></svg>
                    Search the Register
                </a>
                <a href="{{ route('apply.step1') }}" class="cta-secondary-btn" id="cta-apply-btn">
                    Start Application
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                </a>
                <p class="cta-note">No payment required at this stage</p>
            </div>
        </div>
    </div>
</section>

@endsection
