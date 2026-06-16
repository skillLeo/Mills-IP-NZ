@extends('layouts.public')

@section('title', 'Trademark Application — Step 5 of 5')
@section('meta_description', 'Final step — add any notes and submit your trademark application to Mills IP.')

@section('content')

<div class="stepper-wrap">
    <div class="container">
        @include('form._progress', ['currentStep' => 5])
    </div>
</div>

<div class="form-page">
    <div class="container">
        <div class="form-layout">

            <div class="fcard">
                <div class="fcard-head">
                    <div class="step-pill">Step 5 of 5 — Final Step</div>
                    <h2>Additional Notes</h2>
                    <p>Anything else the Mills IP team should know? This is optional — you can submit without adding notes.</p>
                </div>

                <form method="POST" action="{{ route('apply.submit') }}" novalidate>
                    @csrf
                    <div class="fcard-body">

                        <div class="field">
                            <div class="field-row">
                                <label for="additional_notes" class="field-label">Notes for Mills IP</label>
                                <span class="field-opt">Optional</span>
                            </div>
                            <textarea
                                id="additional_notes"
                                name="additional_notes"
                                class="field-textarea @error('additional_notes') err @enderror"
                                rows="5"
                                placeholder="Any extra context you'd like to share — prior trademark objections, international registrations, timing requirements, or questions for the team."
                            >{{ old('additional_notes') }}</textarea>
                            @error('additional_notes')
                                <p class="field-error">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="submit-note">
                            By submitting this application you agree to be contacted by Mills IP regarding your trademark enquiry. <strong>No payment is required at this stage.</strong> You will receive a fixed fee quote within one business day.
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
                        </div>
                        <div class="form-nav">
                            <a href="{{ route('apply.step4') }}" class="fnav-back">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"></polyline></svg>
                                Back
                            </a>
                            <button type="submit" class="fnav-submit">
                                Submit Application
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <aside class="form-sidebar">
                @if(session('application.step1'))
                <div class="scard">
                    <div class="scard-head"><h3>Your application summary</h3></div>
                    <div class="scard-body">
                        <div class="summ-list">
                            <div class="summ-row">
                                <div class="summ-key">Trademark</div>
                                <div class="summ-val">{{ session('application.step1.trademark_description') }}</div>
                            </div>
                            @if(session('application.step1.logo_file_path'))
                            <div class="summ-row">
                                <div class="summ-key">Logo</div>
                                <span class="summ-tag">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                    Uploaded
                                </span>
                            </div>
                            @endif
                            @if(session('application.step2'))
                            <div class="summ-row">
                                <div class="summ-key">Business</div>
                                <div class="summ-val">{{ session('application.step2.business_description') }}</div>
                            </div>
                            @endif
                            @if(session('application.step3'))
                            <div class="summ-row">
                                <div class="summ-key">Legal Owner</div>
                                <div class="summ-val">{{ session('application.step3.legal_owner_name') }}</div>
                            </div>
                            <div class="summ-row">
                                <div class="summ-key">Owner Type</div>
                                <div class="summ-val">{{ ucfirst(session('application.step3.legal_owner_type')) }}</div>
                            </div>
                            @endif
                            @if(session('application.step4'))
                            <div class="summ-row">
                                <div class="summ-key">Contact</div>
                                <div class="summ-val">{{ session('application.step4.contact_name') }}</div>
                            </div>
                            <div class="summ-row">
                                <div class="summ-key">Email</div>
                                <div class="summ-val">{{ session('application.step4.contact_email') }}</div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                <div class="trust-stack">
                    <div class="tbadge">
                        <div class="tbadge-icon">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        </div>
                        <div class="tbadge-text">
                            <h4>You're almost done</h4>
                            <p>Once submitted, a Mills IP attorney will review your application and send a fixed fee quote within one business day.</p>
                        </div>
                    </div>
                </div>
            </aside>

        </div>
    </div>
</div>

@endsection
