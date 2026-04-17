<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
                <div class="auth-kicker">Welcome Back</div>
                <h1 class="auth-hero-title">Sign in and pick up your shopping flow right where you left it.</h1>
                <p class="auth-hero-copy">
                    Access your cart, orders, saved details, and a faster checkout experience from one polished customer account.
                </p>

                <div class="auth-highlights">
                    <div class="auth-highlight">
                        <span class="auth-highlight-index">01</span>
                        <span>Track current and past orders without losing checkout history.</span>
                    </div>
                    <div class="auth-highlight">
                        <span class="auth-highlight-index">02</span>
                        <span>Return to your cart instantly and continue browsing from the same session.</span>
                    </div>
                    <div class="auth-highlight">
                        <span class="auth-highlight-index">03</span>
                        <span>Admin accounts are redirected straight into the control panel after login.</span>
                    </div>
                </div>
            </div>

            <div class="auth-hero-footer">
                <a href="{{ url('/') }}" class="auth-home-link">Back to storefront</a>
            </div>
        </section>

        <section class="auth-panel">
            <div class="auth-card">
                <div class="auth-card-header">
                    <div class="auth-card-kicker">Account Access</div>
                    <h2 class="auth-card-title">Login to your account</h2>
                    <p class="auth-card-copy">Use your registered email and password to continue.</p>
                </div>

                <x-auth-session-status class="auth-status" :status="session('status')" />

                <form method="POST" action="{{ route('login', absolute: false) }}" class="auth-form">
                    @csrf

                    <div class="auth-field">
                        <label for="email" class="auth-label">Email</label>
                        <input id="email" type="email" name="email" class="auth-input" value="{{ old('email') }}" required autofocus>
                        <x-input-error :messages="$errors->get('email')" class="auth-error" />
                    </div>

                    <div class="auth-field">
                        <label for="password" class="auth-label">Password</label>
                        <input id="password" type="password" name="password" class="auth-input" required>
                        <x-input-error :messages="$errors->get('password')" class="auth-error" />
                    </div>

                    <div class="auth-row">
                        <label for="remember" class="auth-check">
                            <input id="remember" type="checkbox" name="remember">
                            <span>Remember me</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="auth-link">Forgot password?</a>
                        @endif
                    </div>

                    <button type="submit" class="auth-submit">Login</button>

                    <div class="auth-divider"></div>

                    <div class="auth-footer">
                        Don't have an account?
                        <a href="{{ route('register') }}" class="auth-link">Register</a>
                    </div>
                </form>
            </div>
        </section>
    </div>
</body>
</html>
