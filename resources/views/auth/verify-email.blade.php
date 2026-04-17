<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
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
                <div class="auth-kicker">Verification</div>
                <h1 class="auth-hero-title">Verify your email to unlock the full MarketVerse account experience.</h1>
                <p class="auth-hero-copy">
                    Once your email is verified, your account will be ready for secure sign-in, order tracking, and a smoother checkout flow.
                </p>
            </div>

            <div class="auth-hero-footer">
                <a href="{{ url('/') }}" class="auth-home-link">Back to storefront</a>
            </div>
        </section>

        <section class="auth-panel">
            <div class="auth-card">
                <div class="auth-card-header">
                    <div class="auth-card-kicker">Email Verification</div>
                    <h2 class="auth-card-title">Check your inbox</h2>
                    <p class="auth-card-copy">
                        We sent a verification link to your email address. Open it and confirm your account to continue.
                    </p>
                </div>

                @if (session('status') === 'verification-link-sent')
                    <div class="auth-status">A fresh verification link has been sent to your email address.</div>
                @endif

                <div class="auth-form">
                    <form method="POST" action="{{ route('verification.send') }}" class="auth-form">
                        @csrf
                        <button type="submit" class="auth-submit">Resend Verification Email</button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}" class="auth-form">
                        @csrf
                        <button type="submit" class="auth-secondary">Log Out</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</body>
</html>
