@extends('Home.layout')

@section('title', 'Contact | MarketVerse')

@section('content')
    <section class="section">
        <div class="page-container contact-layout">
            <div class="panel reveal">
                <div class="eyebrow">Contact Studio</div>
                <h1 class="section-title">Need help with products, orders, or delivery?</h1>
                <p class="section-copy">Send a direct message to the admin team for help with products, orders, delivery, or account questions.</p>

                <form class="stack-md" style="margin-top: 28px;" method="POST" action="{{ route('contact-us.store') }}">
                    @csrf
                    <input class="input-field" type="text" name="name" placeholder="Your Name" value="{{ old('name', $contactDefaults['name'] ?? '') }}" required>
                    <x-input-error :messages="$errors->get('name')" class="auth-error" />
                    <div class="grid-2">
                        <div>
                            <input class="input-field" type="email" name="email" placeholder="Email Address" value="{{ old('email', $contactDefaults['email'] ?? '') }}" required>
                            <x-input-error :messages="$errors->get('email')" class="auth-error" />
                        </div>
                        <div>
                            <input class="input-field" type="text" name="phone" placeholder="Phone Number" value="{{ old('phone', $contactDefaults['phone'] ?? '') }}">
                            <x-input-error :messages="$errors->get('phone')" class="auth-error" />
                        </div>
                    </div>
                    <input class="input-field" type="text" name="subject" placeholder="Subject" value="{{ old('subject', $contactDefaults['subject'] ?? '') }}" required>
                    <x-input-error :messages="$errors->get('subject')" class="auth-error" />
                    <textarea class="textarea-field" rows="6" name="message" placeholder="How can we help?" required>{{ old('message', $contactDefaults['message'] ?? '') }}</textarea>
                    <x-input-error :messages="$errors->get('message')" class="auth-error" />
                    <button type="submit" class="solid-btn">Send Message</button>
                </form>
            </div>

            <aside class="panel reveal delay-1">
                <div class="eyebrow">Reach Us</div>
                <h2 class="section-title" style="font-size: 34px;">Store support details</h2>

                <div class="contact-list">
                    <div class="mini-card">
                        <div>
                            <strong style="font-size: 20px;">Location</strong>
                            <p class="muted">Raipur, Chhattisgarh, India</p>
                        </div>
                    </div>
                    <div class="mini-card">
                        <div>
                            <strong style="font-size: 20px;">Call</strong>
                            <p class="muted">+91 9131550312</p>
                        </div>
                    </div>
                    <div class="mini-card">
                        <div>
                            <strong style="font-size: 20px;">Email</strong>
                            <p class="muted">support@marketverse.local</p>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </section>
@endsection
