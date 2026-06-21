@extends('layouts.admin')

@section('title', 'Admin Login')

@section('content')

<div class="login-page">

    {{-- Left panel: brand + decorative --}}
    <div class="login-panel-left">
        <div class="lpl-inner">

            <a href="{{ route('search') }}" class="lpl-logo" aria-label="Mills IP NZ">
                <img src="{{ asset('images/logo.png') }}" alt="Mills IP NZ" class="lpl-logo-img">
            </a>

            <div class="lpl-content">
                <div class="lpl-eyebrow">Team Portal</div>
                <h1 class="lpl-heading">Manage trademark applications with confidence.</h1>
                <p class="lpl-sub">The private dashboard for the Mills IP NZ legal team. Review incoming applications, update statuses, and maintain a complete audit trail.</p>

                <ul class="lpl-features">
                    <li>
                        <div class="lpl-feat-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        </div>
                        Application tracking and status management
                    </li>
                    <li>
                        <div class="lpl-feat-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        </div>
                        Internal notes and team collaboration
                    </li>
                    <li>
                        <div class="lpl-feat-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                        </div>
                        Full audit history, append-only
                    </li>
                </ul>
            </div>

            <div class="lpl-trust">
                <span>Session protected</span>
                <span>Private access only</span>
                <span>No public registration</span>
            </div>

        </div>
    </div>

    {{-- Right panel: login form --}}
    <div class="login-panel-right">
        <div class="login-form-container">

            <div class="login-form-top">
                <div class="login-form-avatar">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <div>
                    <h2 class="login-form-title">Welcome back</h2>
                    <p class="login-form-sub">Sign in to the Mills IP NZ dashboard</p>
                </div>
            </div>

            @if(session('error'))
                <div class="login-alert" role="alert">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('admin.login.post') }}" method="POST" novalidate class="login-form">
                @csrf

                <div class="login-field">
                    <label for="email" class="login-label">Email address</label>
                    <div class="login-input-wrap">
                        <span class="login-input-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        </span>
                        <input
                            type="email" id="email" name="email"
                            class="login-input @error('email') login-input--err @enderror"
                            value="{{ old('email') }}"
                            autocomplete="email" autofocus required
                            placeholder="you@millsip.co.nz"
                        >
                    </div>
                    @error('email')
                        <p class="login-field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="login-field">
                    <label for="password" class="login-label">Password</label>
                    <div class="login-input-wrap">
                        <span class="login-input-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        </span>
                        <input
                            type="password" id="password" name="password"
                            class="login-input @error('password') login-input--err @enderror"
                            autocomplete="current-password" required
                            placeholder="Enter your password"
                        >
                    </div>
                    @error('password')
                        <p class="login-field-error">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="login-submit">
                    Sign In to Dashboard
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </button>

            </form>

            <p class="login-help">Access is restricted to authorised Mills IP NZ team members only. If you need access, contact your system administrator.</p>

        </div>
    </div>

</div>

@endsection
