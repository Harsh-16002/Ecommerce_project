<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Password</title>
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
                <div class="auth-kicker">Security Check</div>
                <h1 class="auth-hero-title">Confirm your password before entering this protected area.</h1>
                <p class="auth-hero-copy">
                    This extra step helps keep sensitive account actions secure for you and your customers.
                </p>
            </div>

            <div class="auth-hero-footer">
                <a href="{{ url('/') }}" class="auth-home-link">Back to storefront</a>
            </div>
        </section>

        <section class="auth-panel">
            <div class="auth-card">
                <div class="auth-card-header">
                    <div class="auth-card-kicker">Protected Action</div>
                    <h2 class="auth-card-title">Confirm your password</h2>
                    <p class="auth-card-copy">Enter your current password to continue.</p>
                </div>

                <form method="POST" action="{{ route('password.confirm', absolute: false) }}" class="auth-form">
                    @csrf

                    <div class="auth-field">
                        <label for="password" class="auth-label">Password</label>
                        <input id="password" type="password" name="password" class="auth-input" required>
                        <x-input-error :messages="$errors->get('password')" class="auth-error" />
                    </div>

                    <button type="submit" class="auth-submit">Confirm Password</button>
                </form>
            </div>
        </section>
    </div>
</body>
</html>
