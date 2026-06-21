@extends('layouts.public')

@section('title', 'Application Received — Mills IP NZ')
@section('meta_description', 'Your trademark application has been received by Mills IP NZ.')

@section('content')

<div class="confirm-wrap">
    <div class="container">
        <div class="confirm-grid">

            <div class="confirm-main">
                <div class="confirm-head">
                    <div class="confirm-check">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </div>
                    <h1>Application Submitted</h1>
                    <p>Thank you{{ $contactName ? ', ' . $contactName : '' }}. Your trademark application has been received by the Mills IP NZ team.</p>
                </div>

                @if($trademark)
                <div class="confirm-trademark-banner">
                    <div class="ctb-label">Applying to register</div>
                    <div class="ctb-name">"{{ $trademark }}"</div>
                    @if($applicationId)
                        <div class="ctb-ref">Reference #{{ $applicationId }}</div>
                    @endif
                </div>
                @endif

                <div class="confirm-body">
                    <h3>What happens next</h3>
                    <div class="timeline">
                        <div class="tl-item">
                            <div class="tl-dot now">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            </div>
                            <div class="tl-content">
                                <h4>Application received</h4>
                                <p>Your application has been saved and assigned to the Mills IP NZ legal team for review.</p>
                            </div>
                        </div>
                        <div class="tl-item">
                            <div class="tl-dot next">2</div>
                            <div class="tl-content">
                                <h4>Attorney review — within 1 business day</h4>
                                <p>A Mills IP NZ trademark attorney will review your application, check the register for conflicts, and prepare your fixed fee quote.</p>
                            </div>
                        </div>
                        <div class="tl-item">
                            <div class="tl-dot next">3</div>
                            <div class="tl-content">
                                <h4>Fixed fee quote sent to you</h4>
                                <p>You'll receive a clear quote by email. No obligation — review it and decide at your own pace before any payment is required.</p>
                            </div>
                        </div>
                        <div class="tl-item">
                            <div class="tl-dot next">4</div>
                            <div class="tl-content">
                                <h4>Application filed with IPONZ</h4>
                                <p>Once you approve, Mills IP NZ handles the complete filing with the official New Zealand trademark register on your behalf.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="confirm-foot">
                    <a href="{{ route('search') }}" class="btn-solid">Search Another Trademark</a>
                </div>
            </div>

            <aside class="confirm-sidebar">
                <div class="scard">
                    <div class="scard-head"><h3>Your submission</h3></div>
                    <div class="scard-body">
                        <div class="summ-list">
                            @if($trademark)
                            <div class="summ-row">
                                <div class="summ-key">Trademark</div>
                                <div class="summ-val">{{ $trademark }}</div>
                            </div>
                            @endif
                            @if($applicationId)
                            <div class="summ-row">
                                <div class="summ-key">Reference</div>
                                <div class="summ-val" style="font-family:var(--mono)">#{{ $applicationId }}</div>
                            </div>
                            @endif
                            <div class="summ-row">
                                <div class="summ-key">Status</div>
                                <span class="summ-tag">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                    Received
                                </span>
                            </div>
                            <div class="summ-row">
                                <div class="summ-key">Submitted</div>
                                <div class="summ-val">{{ now()->format('j F Y') }}</div>
                            </div>
                            <div class="summ-row">
                                <div class="summ-key">Confirmation</div>
                                <div class="summ-val">Sent to your email</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="trust-stack">
                    <div class="tbadge">
                        <div class="tbadge-icon">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        </div>
                        <div class="tbadge-text">
                            <h4>Response within 1 business day</h4>
                            <p>Expect your fixed fee quote from the Mills IP NZ legal team.</p>
                        </div>
                    </div>
                    <div class="tbadge">
                        <div class="tbadge-icon">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        </div>
                        <div class="tbadge-text">
                            <h4>No obligation to proceed</h4>
                            <p>Review the quote and decide in your own time. No pressure, no payment yet.</p>
                        </div>
                    </div>
                </div>
            </aside>

        </div>
    </div>
</div>

@endsection
