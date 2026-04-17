<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
                <div class="auth-kicker">Create Account</div>
                <h1 class="auth-hero-title">Join the storefront and make every future checkout faster.</h1>
                <p class="auth-hero-copy">
                    Create your customer profile once to manage orders, save delivery details, and move through the shopping flow with less friction.
                </p>

                <div class="auth-highlights">
                    <div class="auth-highlight">
                        <span class="auth-highlight-index">01</span>
                        <span>Store your account details for smoother repeat orders.</span>
                    </div>
                    <div class="auth-highlight">
                        <span class="auth-highlight-index">02</span>
                        <span>Track order history and delivery progress from your dashboard.</span>
                    </div>
                    <div class="auth-highlight">
                        <span class="auth-highlight-index">03</span>
                        <span>Get immediate access to the full storefront experience after signup.</span>
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
                    <div class="auth-card-kicker">New Customer</div>
                    <h2 class="auth-card-title">Create your account</h2>
                    <p class="auth-card-copy">Fill in your details to start shopping and tracking orders.</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="auth-form">
                    @csrf

                    <div class="auth-grid two">
                        <div class="auth-field">
                            <label for="name" class="auth-label">Name</label>
                            <input id="name" type="text" name="name" class="auth-input" value="{{ old('name') }}" required>
                            <x-input-error :messages="$errors->get('name')" class="auth-error" />
                        </div>

                        <div class="auth-field">
                            <label for="phone" class="auth-label">Phone</label>
                            <input id="phone" type="text" name="phone" class="auth-input" value="{{ old('phone') }}" required>
                            <x-input-error :messages="$errors->get('phone')" class="auth-error" />
                        </div>
                    </div>

                    <div class="auth-field">
                        <label for="email" class="auth-label">Email</label>
                        <input id="email" type="email" name="email" class="auth-input" value="{{ old('email') }}" required>
                        <x-input-error :messages="$errors->get('email')" class="auth-error" />
                    </div>

                    <div class="auth-field">
                        <label for="address" class="auth-label">Address</label>
                        <input id="address" type="text" name="address" class="auth-input" value="{{ old('address') }}" required>
                        <x-input-error :messages="$errors->get('address')" class="auth-error" />
                    </div>

                    <div class="auth-grid two">
                        <div class="auth-field">
                            <label for="password" class="auth-label">Password</label>
                            <input id="password" type="password" name="password" class="auth-input" required>
                            <x-input-error :messages="$errors->get('password')" class="auth-error" />
                        </div>

                        <div class="auth-field">
                            <label for="password_confirmation" class="auth-label">Confirm Password</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" class="auth-input" required>
                            <x-input-error :messages="$errors->get('password_confirmation')" class="auth-error" />
                        </div>
                    </div>

                    <button type="submit" class="auth-submit">Register</button>

                    <div class="auth-divider"></div>

                    <div class="auth-footer">
                        Already have an account?
                        <a href="{{ route('login') }}" class="auth-link">Login</a>
                    </div>
                </form>
            </div>
        </section>
    </div>
</body>
</html>
