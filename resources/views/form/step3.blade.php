@extends('layouts.public')

@section('title', 'Trademark Application — Step 3 of 5')
@section('meta_description', 'Provide legal owner details for your trademark application with Mills IP.')

@section('content')

<div class="stepper-wrap">
    <div class="container">
        @include('form._progress', ['currentStep' => 3])
    </div>
</div>

<div class="form-page">
    <div class="container">
        <div class="form-layout">

            <div class="fcard">
                <div class="fcard-head">
                    <div class="step-pill">Step 3 of 5</div>
                    <h2>Legal Owner Details</h2>
                    <p>Who will legally own the trademark? This name will appear on the official registration.</p>
                </div>

                <form method="POST" action="{{ route('apply.step3.post') }}" novalidate>
                    @csrf
                    <div class="fcard-body">

                        <div class="field">
                            <div class="field-row">
                                <label class="field-label">Owner Type <span class="field-req">*</span></label>
                            </div>
                            <div class="owner-grid">
                                <label class="owner-opt">
                                    <input type="radio" name="legal_owner_type" value="individual"
                                        {{ old('legal_owner_type', session('application.step3.legal_owner_type')) === 'individual' ? 'checked' : '' }} required>
                                    <div class="owner-opt-check">
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                    </div>
                                    <div class="owner-opt-icon">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                    </div>
                                    <h4>Individual</h4>
                                    <p>A person registering in their own name</p>
                                </label>
                                <label class="owner-opt">
                                    <input type="radio" name="legal_owner_type" value="company"
                                        {{ old('legal_owner_type', session('application.step3.legal_owner_type')) === 'company' ? 'checked' : '' }}>
                                    <div class="owner-opt-check">
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                    </div>
                                    <div class="owner-opt-icon">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
                                    </div>
                                    <h4>Company</h4>
                                    <p>A registered business or corporation</p>
                                </label>
                            </div>
                            @error('legal_owner_type')
                                <p class="field-error" style="margin-top:10px">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="field">
                            <div class="field-row">
                                <label for="legal_owner_name" class="field-label">Full Legal Name <span class="field-req">*</span></label>
                            </div>
                            <input
                                type="text"
                                id="legal_owner_name"
                                name="legal_owner_name"
                                class="field-input @error('legal_owner_name') err @enderror"
                                value="{{ old('legal_owner_name', session('application.step3.legal_owner_name')) }}"
                                placeholder="Full legal name of the individual or company"
                                required
                            >
                            @error('legal_owner_name')
                                <p class="field-error">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="field-hint">Enter the name exactly as it should appear on the trademark registration certificate.</p>
                        </div>

                        <div class="field">
                            <div class="field-row">
                                <label for="abn" class="field-label">ABN</label>
                                <span class="field-opt">Required for companies</span>
                            </div>
                            <input
                                type="text"
                                id="abn"
                                name="abn"
                                class="field-input @error('abn') err @enderror"
                                value="{{ old('abn', session('application.step3.abn')) }}"
                                placeholder="e.g. 51 824 753 556"
                                maxlength="20"
                            >
                            @error('abn')
                                <p class="field-error">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="field-hint">Australian Business Number. Leave blank if registering as an individual.</p>
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
                            <a href="{{ route('apply.step2') }}" class="fnav-back">
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
                        </div>
                    </div>
                </div>
                @endif

                <div class="scard">
                    <div class="scard-head"><h3>Why we ask this</h3></div>
                    <div class="scard-body">
                        <p style="font-size:13px;color:var(--muted);line-height:1.6;margin:0">The legal owner is the entity whose name will appear on the trademark registration. It must be the person or company that actually uses the trademark in trade — this cannot be changed without a formal assignment later.</p>
                    </div>
                </div>
            </aside>

        </div>
    </div>
</div>

@endsection
