@extends('layouts.admin')

@section('title', 'Admin Login')

@section('content')

<main class="login-wrap">
    <section class="login-brand-panel" aria-label="Mills IP admin portal">
        <a href="{{ route('search') }}" class="login-logo">Mills IP</a>

        <div class="login-brand-copy">
            <span class="admin-eyebrow">Mills IP Team Portal</span>
            <h1>Manage every trademark application in one secure workspace.</h1>
            <p>Review incoming applications, update statuses, leave internal notes, and maintain a complete audit history — all from one private dashboard.</p>
        </div>

        <div class="login-security-list">
            <span>Session protected</span>
            <span>Private team access only</span>
            <span>No public registration</span>
        </div>
    </section>

    <section class="login-form-panel">
        <div class="login-form-box">
            <span class="admin-eyebrow">Admin Portal</span>
            <h2>Sign in</h2>
            <p class="login-sub">Access the private Mills IP dashboard.</p>

            @if(session('error'))
                <div class="login-alert" role="alert">{{ session('error') }}</div>
            @endif

            <form action="{{ route('admin.login.post') }}" method="POST" novalidate>
                @csrf

                <div class="form-group">
                    <label for="email" class="form-label">Email address</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-input @error('email') is-invalid @enderror"
                        value="{{ old('email') }}"
                        autocomplete="email"
                        autofocus
                        required
                    >
                    @error('email')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-input @error('password') is-invalid @enderror"
                        autocomplete="current-password"
                        required
                    >
                    @error('password')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="login-submit">Sign In</button>
            </form>
        </div>
    </section>
</main>

@endsection
