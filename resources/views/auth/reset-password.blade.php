<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    @include('auth.partials.theme')
</head>
<body class="auth-page">
    <div class="auth-shell">
        <section class="auth-hero">
            <a href="{{ url('/') }}" class="auth-brand">
                <img src="{{ asset('images/marketverse-mark.svg') }}" alt="MarketVerse logo" class="auth-brand-mark">
                <span>MarketVerse</span>
            </a>

            <div class="auth-hero-body">
                <div class="auth-kicker">New Password</div>
                <h1 class="auth-hero-title">Choose a secure new password and protect your account.</h1>
                <p class="auth-hero-copy">
                    Create a strong password that is easy for you to remember and hard for anyone else to guess.
                </p>
            </div>

            <div class="auth-hero-footer">
                <a href="{{ route('login') }}" class="auth-home-link">Back to login</a>
            </div>
        </section>

        <section class="auth-panel">
            <div class="auth-card">
                <div class="auth-card-header">
                    <div class="auth-card-kicker">Reset Password</div>
                    <h2 class="auth-card-title">Set your new password</h2>
                    <p class="auth-card-copy">Confirm your email and choose a new password to finish recovery.</p>
                </div>

                <form method="POST" action="{{ route('password.store') }}" class="auth-form">
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div class="auth-field">
                        <label for="email" class="auth-label">Email</label>
                        <input id="email" type="email" name="email" class="auth-input" value="{{ old('email', $request->email) }}" required>
                        <x-input-error :messages="$errors->get('email')" class="auth-error" />
                    </div>

                    <div class="auth-grid two">
                        <div class="auth-field">
                            <label for="password" class="auth-label">New Password</label>
                            <input id="password" type="password" name="password" class="auth-input" required>
                            <x-input-error :messages="$errors->get('password')" class="auth-error" />
                        </div>

                        <div class="auth-field">
                            <label for="password_confirmation" class="auth-label">Confirm Password</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" class="auth-input" required>
                            <x-input-error :messages="$errors->get('password_confirmation')" class="auth-error" />
                        </div>
                    </div>

                    <button type="submit" class="auth-submit">Reset Password</button>
                </form>
            </div>
        </section>
    </div>
</body>
</html>
