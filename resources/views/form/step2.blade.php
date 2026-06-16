@extends('layouts.public')

@section('title', 'Trademark Application — Step 2 of 5')
@section('meta_description', 'Describe your business as part of your trademark application with Mills IP.')

@section('content')

<div class="stepper-wrap">
    <div class="container">
        @include('form._progress', ['currentStep' => 2])
    </div>
</div>

<div class="form-page">
    <div class="container">
        <div class="form-layout">

            <div class="fcard">
                <div class="fcard-head">
                    <div class="step-pill">Step 2 of 5</div>
                    <h2>Business Description</h2>
                    <p>Tell us about your business and the goods or services you offer under this trademark.</p>
                </div>

                <form method="POST" action="{{ route('apply.step2.post') }}" novalidate>
                    @csrf
                    <div class="fcard-body">

                        <div class="field">
                            <div class="field-row">
                                <label for="business_description" class="field-label">Business Description <span class="field-req">*</span></label>
                            </div>
                            <textarea
                                id="business_description"
                                name="business_description"
                                class="field-textarea @error('business_description') err @enderror"
                                rows="6"
                                placeholder="Describe your business — what industry are you in, what products or services do you sell, and who are your customers?"
                                required
                            >{{ old('business_description', session('application.step2.business_description')) }}</textarea>
                            @error('business_description')
                                <p class="field-error">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="field-hint">Include the specific goods or services your trademark will cover — this determines which trademark class your application is filed under.</p>
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
                            <a href="{{ route('apply.step1') }}" class="fnav-back">
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
                            <div class="summ-row">
                                <div class="summ-key">Logo</div>
                                @if(session('application.step1.logo_file_path'))
                                    <span class="summ-tag">
                                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                        Uploaded
                                    </span>
                                @else
                                    <div class="summ-val" style="color:var(--faint)">Not uploaded</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="scard">
                    <div class="scard-head"><h3>Why we ask this</h3></div>
                    <div class="scard-body">
                        <p style="font-size:13px;color:var(--muted);line-height:1.6;margin:0">The goods and services description determines which trademark class your application is filed under. Accurate descriptions help Mills IP prepare the strongest possible application on your behalf.</p>
                    </div>
                </div>

                <div class="trust-stack">
                    <div class="tbadge">
                        <div class="tbadge-icon">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        </div>
                        <div class="tbadge-text">
                            <h4>No payment at this stage</h4>
                            <p>You'll receive a fixed fee quote before any payment is required.</p>
                        </div>
                    </div>
                </div>
            </aside>

        </div>
    </div>
</div>

@endsection
