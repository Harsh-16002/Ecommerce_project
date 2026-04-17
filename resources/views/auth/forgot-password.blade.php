<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
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
                <div class="auth-kicker">Recovery</div>
                <h1 class="auth-hero-title">Reset your password and get back into your account quickly.</h1>
                <p class="auth-hero-copy">
                    Enter your email and we will send a secure reset link so you can continue shopping without losing your account access.
                </p>
            </div>

            <div class="auth-hero-footer">
                <a href="{{ route('login') }}" class="auth-home-link">Back to login</a>
            </div>
        </section>

        <section class="auth-panel">
            <div class="auth-card">
                <div class="auth-card-header">
                    <div class="auth-card-kicker">Password Recovery</div>
                    <h2 class="auth-card-title">Forgot your password?</h2>
                    <p class="auth-card-copy">Use your account email and we will send you a reset link.</p>
                </div>

                <x-auth-session-status class="auth-status" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}" class="auth-form">
                    @csrf

                    <div class="auth-field">
                        <label for="email" class="auth-label">Email</label>
                        <input id="email" type="email" name="email" class="auth-input" value="{{ old('email') }}" required autofocus>
                        <x-input-error :messages="$errors->get('email')" class="auth-error" />
                    </div>

                    <button type="submit" class="auth-submit">Send Reset Link</button>

                    <div class="auth-divider"></div>

                    <div class="auth-footer">
                        Remember your password?
                        <a href="{{ route('login') }}" class="auth-link">Login</a>
                    </div>
                </form>
            </div>
        </section>
    </div>
</body>
</html>
