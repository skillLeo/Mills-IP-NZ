@extends('layouts.public')

@section('title', 'Trademark Application — Step 1 of 5')
@section('meta_description', 'Begin your trademark application. Describe your trademark and upload your logo.')

@section('content')

<div class="stepper-wrap">
    <div class="container">
        @include('form._progress', ['currentStep' => 1])
    </div>
</div>

<div class="form-page">
    <div class="container">
        <div class="form-layout">

            <div class="fcard">
                @if($brand)
                <div class="fcard-trademark-context">
                    <div class="ftc-label">Applying to register</div>
                    <div class="ftc-name">"{{ $brand }}"</div>
                    <div class="ftc-note">Confirm or expand this description below, then continue through the steps.</div>
                </div>
                @else
                <div class="fcard-search-prompt">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <span>We recommend <a href="{{ route('search') }}">searching the trademark register first</a> to check for conflicts before applying.</span>
                </div>
                @endif
                <div class="fcard-head">
                    <div class="step-pill">Step 1 of 5</div>
                    <h2>Trademark Details</h2>
                    <p>Describe what you want to protect and upload your logo or brand mark if you have one.</p>
                </div>

                <form method="POST" action="{{ route('apply.step1.post') }}" enctype="multipart/form-data" novalidate>
                    @csrf
                    <div class="fcard-body">

                        <div class="field">
                            <div class="field-row">
                                <label for="trademark_description" class="field-label">Trademark Description <span class="field-req">*</span></label>
                            </div>
                            <textarea
                                id="trademark_description"
                                name="trademark_description"
                                class="field-textarea @error('trademark_description') err @enderror"
                                rows="5"
                                placeholder="Describe your trademark — the brand name, tagline, logo concept, or combination you want to register."
                                required
                            >{{ old('trademark_description', $brand ?: '') }}</textarea>
                            @error('trademark_description')
                                <p class="field-error">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="field-hint">Be specific. Include the exact words, phrases, and visual elements you want to protect.</p>
                        </div>

                        <div class="field">
                            <div class="field-row">
                                <label class="field-label">Logo or Brand Mark</label>
                                <span class="field-opt">Optional</span>
                            </div>

                            @if(session('application.step1.logo_file_path'))
                                <div class="upload-existing">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                    Logo uploaded — select a new file to replace it
                                </div>
                            @endif

                            <div class="upload-area">
                                <input type="file" name="logo" id="logo" accept="image/jpeg,image/png,image/gif,image/svg+xml,image/webp">
                                <div class="upload-icon-box">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75">
                                        <polyline points="16 16 12 12 8 16"></polyline>
                                        <line x1="12" y1="12" x2="12" y2="21"></line>
                                        <path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"></path>
                                    </svg>
                                </div>
                                <p class="upload-title">Click to upload <span>or drag and drop</span></p>
                                <p class="upload-sub">JPEG, PNG, GIF, SVG or WEBP &middot; Max 5 MB</p>
                                <div class="upload-selected" id="upload-selected">
                                    <svg class="upload-selected-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                    <span class="upload-selected-name" id="upload-filename"></span>
                                </div>
                            </div>
                            @error('logo')
                                <p class="field-error">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                    {{ $message }}
                                </p>
                            @enderror
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
                            <a href="{{ route('search') }}" class="fnav-back">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"></polyline></svg>
                                Cancel
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
                <div class="scard">
                    <div class="scard-head"><h3>What you'll need</h3></div>
                    <div class="scard-body">
                        <div class="help-list">
                            <div class="help-item">
                                <div class="help-num">1</div>
                                <div class="help-text">
                                    <h4>Trademark description</h4>
                                    <p>The brand name, phrase, or logo concept you want to protect.</p>
                                </div>
                            </div>
                            <div class="help-item">
                                <div class="help-num">2</div>
                                <div class="help-text">
                                    <h4>Business description</h4>
                                    <p>What your business does and the goods or services you offer.</p>
                                </div>
                            </div>
                            <div class="help-item">
                                <div class="help-num">3</div>
                                <div class="help-text">
                                    <h4>Legal owner details</h4>
                                    <p>The individual or company name that will own the trademark.</p>
                                </div>
                            </div>
                            <div class="help-item">
                                <div class="help-num">4</div>
                                <div class="help-text">
                                    <h4>Contact information</h4>
                                    <p>Your name, email, and phone for the Mills IP NZ team to reach you.</p>
                                </div>
                            </div>
                        </div>
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
                    <div class="tbadge">
                        <div class="tbadge-icon">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        </div>
                        <div class="tbadge-text">
                            <h4>Response in 1 business day</h4>
                            <p>A Mills IP NZ attorney will review and respond with a quote promptly.</p>
                        </div>
                    </div>
                </div>
            </aside>

        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('logo').addEventListener('change', function () {
    const sel = document.getElementById('upload-selected');
    const name = document.getElementById('upload-filename');
    if (this.files && this.files[0]) {
        name.textContent = this.files[0].name;
        sel.classList.add('show');
    }
});
</script>
@endpush

@endsection
