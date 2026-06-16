@extends('layouts.public')

@section('title', 'Trademark Application — Step 4 of 5')
@section('meta_description', 'Provide your contact details for your trademark application with Mills IP.')

@section('content')

<div class="stepper-wrap">
    <div class="container">
        @include('form._progress', ['currentStep' => 4])
    </div>
</div>

<div class="form-page">
    <div class="container">
        <div class="form-layout">

            <div class="fcard">
                <div class="fcard-head">
                    <div class="step-pill">Step 4 of 5</div>
                    <h2>Contact Details</h2>
                    <p>How should Mills IP reach you? Your fixed fee quote will be sent to the email address below.</p>
                </div>

                <form method="POST" action="{{ route('apply.step4.post') }}" novalidate>
                    @csrf
                    <div class="fcard-body">

                        <div class="field">
                            <div class="field-row">
                                <label for="contact_name" class="field-label">Full Name <span class="field-req">*</span></label>
                            </div>
                            <input
                                type="text"
                                id="contact_name"
                                name="contact_name"
                                class="field-input @error('contact_name') err @enderror"
                                value="{{ old('contact_name', session('application.step4.contact_name')) }}"
                                placeholder="Your full name"
                                autocomplete="name"
                                required
                            >
                            @error('contact_name')
                                <p class="field-error">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="field-cols">
                            <div class="field">
                                <div class="field-row">
                                    <label for="contact_email" class="field-label">Email Address <span class="field-req">*</span></label>
                                </div>
                                <input
                                    type="email"
                                    id="contact_email"
                                    name="contact_email"
                                    class="field-input @error('contact_email') err @enderror"
                                    value="{{ old('contact_email', session('application.step4.contact_email')) }}"
                                    placeholder="you@example.com"
                                    autocomplete="email"
                                    required
                                >
                                @error('contact_email')
                                    <p class="field-error">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                                <p class="field-hint">Your quote will be sent here.</p>
                            </div>
                            <div class="field">
                                <div class="field-row">
                                    <label for="contact_phone" class="field-label">Phone Number <span class="field-req">*</span></label>
                                </div>
                                <input
                                    type="tel"
                                    id="contact_phone"
                                    name="contact_phone"
                                    class="field-input @error('contact_phone') err @enderror"
                                    value="{{ old('contact_phone', session('application.step4.contact_phone')) }}"
                                    placeholder="0400 000 000"
                                    autocomplete="tel"
                                    required
                                >
                                @error('contact_phone')
                                    <p class="field-error">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                    </div>

                    <div class="fcard-foot">
                        <div class="form-trust">
                            <span class="ftrust-item">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                Secure &amp; encrypted
                            </span>
                            <span class="ftrust-item">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                                No payment required
                            </span>
                            <span class="ftrust-item">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                Quote within 1 business day
                            </span>
                        </div>
                        <div class="form-nav">
                            <a href="{{ route('apply.step3') }}" class="fnav-back">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"></polyline></svg>
                                Back
                            </a>
                            <button type="submit" class="fnav-next">
                                Save &amp; Continue
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <aside class="form-sidebar">
                @if(session('application.step1'))
                <div class="scard">
                    <div class="scard-head"><h3>Application so far</h3></div>
                    <div class="scard-body">
                        <div class="summ-list">
                            <div class="summ-row">
                                <div class="summ-key">Trademark</div>
                                <div class="summ-val">{{ session('application.step1.trademark_description') }}</div>
                            </div>
                            @if(session('application.step2'))
                            <div class="summ-row">
                                <div class="summ-key">Business</div>
                                <div class="summ-val">{{ session('application.step2.business_description') }}</div>
                            </div>
                            @endif
                            @if(session('application.step3'))
                            <div class="summ-row">
                                <div class="summ-key">Legal Owner</div>
                                <div class="summ-val">{{ session('application.step3.legal_owner_name') }} &middot; {{ ucfirst(session('application.step3.legal_owner_type')) }}</div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                <div class="trust-stack">
                    <div class="tbadge">
                        <div class="tbadge-icon">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        </div>
                        <div class="tbadge-text">
                            <h4>Your quote goes to your email</h4>
                            <p>Mills IP will send a fixed fee quote to the address you provide here.</p>
                        </div>
                    </div>
                </div>
            </aside>

        </div>
    </div>
</div>

@endsection
