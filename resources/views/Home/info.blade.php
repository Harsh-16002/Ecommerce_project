<section class="section section-tight">
    <div class="page-container">
        <div class="panel panel-dark newsletter-box reveal">
            <div class="eyebrow" style="justify-content: center;">Stay in the Loop</div>
            <h2 class="section-title" style="margin-top: 18px;">Join the MarketVerse Circle</h2>
            <p class="section-copy" style="margin-left: auto; margin-right: auto;">
                New arrivals, curated picks, and marketplace offers sent straight to your inbox.
            </p>
            <form class="newsletter-form">
                <input type="email" placeholder="your@email.com">
                <button type="button">Subscribe</button>
            </form>
        </div>
    </div>
</section>

<footer class="site-footer">
    <div class="page-container">
        <div class="footer-grid">
            <div>
                <a href="{{ url('/') }}" class="brand-mark" style="color: var(--cream); text-decoration: none;">
                    <img src="{{ asset('images/marketverse-mark.svg') }}" alt="MarketVerse logo" class="brand-logo-icon">
                    <span class="brand-wordmark">Market<span>Verse</span></span>
                </a>
                <p class="section-copy" style="color: rgba(248,245,239,0.62); margin-top: 18px; max-width: 340px;">
                    A modern multi-category marketplace built for discovery, convenience, and a smooth Laravel commerce flow.
                </p>
            </div>
            <div>
                <div class="footer-title">Shop</div>
                <ul class="footer-links">
                    <li><a href="{{ route('shop.index') }}">All Products</a></li>
                    <li><a href="{{ route('shop.index', ['sort' => 'latest']) }}">New Arrivals</a></li>
                    <li><a href="{{ route('shop.index', ['sort' => 'price_high']) }}">Premium Picks</a></li>
                    <li><a href="{{ url('mycart') }}">Your Cart</a></li>
                </ul>
            </div>
            <div>
                <div class="footer-title">Support</div>
                <ul class="footer-links">
                    <li><a href="{{ route('contact-us.index') }}">Contact</a></li>
                    <li><a href="{{ route('testimonial.index') }}">Reviews</a></li>
                    <li><a href="{{ route('why.index') }}">Why Us</a></li>
                    <li><a href="{{ url('myorders') }}">Track Orders</a></li>
                </ul>
            </div>
            <div>
                <div class="footer-title">Studio</div>
                <ul class="footer-links">
                    <li><a href="{{ route('login') }}">Customer Login</a></li>
                    <li><a href="{{ route('register') }}">Create Account</a></li>
                    @if(($storefrontAdminShortcuts ?? collect())->isNotEmpty())
                        @foreach($storefrontAdminShortcuts as $shortcut)
                            <li><a href="{{ $shortcut['url'] }}">{{ $shortcut['label'] }}</a></li>
                        @endforeach
                    @endif
                    <li><a href="{{ url('/') }}">Home</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <div>&copy; <span id="yearNow"></span> MarketVerse. Crafted for a full ecommerce flow.</div>
            <div>Raipur, India | support@marketverse.local | +91 9131550312</div>
        </div>
    </div>
</footer>
