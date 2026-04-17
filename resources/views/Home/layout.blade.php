<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MarketVerse | Multi-Category Marketplace')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=DM+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --black: #0e0d0c;
            --cream: #f8f5ef;
            --warm-gray: #e8e3da;
            --mid-gray: #8d877f;
            --accent: #c4914a;
            --accent-dark: #9b723d;
            --white: #ffffff;
            --danger: #b74635;
            --success: #1d7a52;
            --border: rgba(14, 13, 12, 0.1);
            --shadow: 0 20px 50px rgba(14, 13, 12, 0.08);
            --serif: 'Playfair Display', Georgia, serif;
            --sans: 'DM Sans', sans-serif;
        }
        html { scroll-behavior: smooth; }
        body {
            font-family: var(--sans);
            background:
                radial-gradient(circle at top left, rgba(196, 145, 74, 0.08), transparent 35%),
                linear-gradient(180deg, #fcfaf5 0%, var(--cream) 24%, #f4efe6 100%);
            color: var(--black);
            overflow-x: hidden;
        }
        a { color: inherit; }
        img { max-width: 100%; display: block; }
        button, input, textarea, select { font: inherit; }
        .page-shell { min-height: 100vh; }
        .page-container { width: min(1400px, calc(100% - 40px)); margin: 0 auto; }
        .section { padding: 84px 0; }
        .section-tight { padding: 60px 0; }
        .section-header {
            display: flex;
            align-items: end;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 36px;
        }
        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 11px;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--accent);
            font-weight: 700;
        }
        .eyebrow::before {
            content: "";
            width: 34px;
            height: 1px;
            background: currentColor;
        }
        .section-title {
            font-family: var(--serif);
            font-size: clamp(30px, 4vw, 48px);
            line-height: 1.1;
            margin-top: 14px;
        }
        .section-copy {
            color: var(--mid-gray);
            max-width: 620px;
            line-height: 1.8;
            margin-top: 12px;
        }
        .announcement {
            background: var(--black);
            color: var(--cream);
            text-align: center;
            padding: 10px 16px;
            font-size: 12px;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }
        .announcement a {
            color: var(--accent);
            text-decoration: none;
            margin-left: 8px;
        }
        .site-header {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: rgba(248, 245, 239, 0.92);
            backdrop-filter: blur(14px);
            border-bottom: 1px solid var(--border);
            transition: box-shadow 0.25s ease;
        }
        .site-header.scrolled { box-shadow: 0 10px 30px rgba(14, 13, 12, 0.08); }
        .nav-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            min-height: 76px;
        }
        .brand-mark {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            white-space: nowrap;
        }
        .brand-logo-icon {
            width: 42px;
            height: 42px;
            flex-shrink: 0;
            border-radius: 14px;
            box-shadow: 0 12px 28px rgba(14, 13, 12, 0.12);
        }
        .brand-wordmark {
            display: inline-flex;
            align-items: baseline;
            gap: 2px;
            font-family: var(--serif);
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 0.04em;
        }
        .brand-wordmark span { color: var(--accent); }
        .nav-links {
            display: flex;
            align-items: center;
            gap: 28px;
            list-style: none;
        }
        .nav-links a {
            text-decoration: none;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            position: relative;
            padding-bottom: 4px;
            color: rgba(14, 13, 12, 0.82);
        }
        .nav-links a::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: 0;
            width: 0;
            height: 1px;
            background: var(--accent);
            transition: width 0.25s ease;
        }
        .nav-links a:hover,
        .nav-links a.is-active { color: var(--black); }
        .nav-links a:hover::after,
        .nav-links a.is-active::after { width: 100%; }
        .nav-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .icon-btn, .text-btn, .solid-btn, .outline-btn {
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .icon-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: rgba(255,255,255,0.7);
            border: 1px solid var(--border);
            color: var(--black);
            position: relative;
        }
        .icon-btn:hover { color: var(--accent); border-color: rgba(196,145,74,0.35); }
        .count-badge {
            position: absolute;
            top: -3px;
            right: -2px;
            min-width: 18px;
            height: 18px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 5px;
            background: var(--accent);
            color: var(--white);
            font-size: 10px;
            font-weight: 700;
        }
        .text-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 42px;
            padding: 0 18px;
            border-radius: 999px;
            border: 1px solid var(--border);
            background: rgba(255,255,255,0.65);
            font-size: 12px;
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }
        .solid-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 48px;
            padding: 0 26px;
            background: var(--black);
            color: var(--cream);
            font-size: 12px;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            border-radius: 2px;
        }
        .solid-btn:hover { background: var(--accent); color: var(--white); }
        .outline-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 48px;
            padding: 0 24px;
            border: 1px solid var(--black);
            color: var(--black);
            background: transparent;
            font-size: 12px;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            border-radius: 2px;
        }
        .outline-btn:hover { color: var(--accent); border-color: var(--accent); }
        .search-panel {
            display: none;
            padding: 0 0 24px;
        }
        .search-panel.active { display: block; }
        .search-form {
            display: flex;
            gap: 12px;
        }
        .search-field, .input-field, .select-field, .textarea-field {
            width: 100%;
            border: 1px solid rgba(14, 13, 12, 0.14);
            background: rgba(255,255,255,0.75);
            padding: 14px 16px;
            color: var(--black);
            border-radius: 2px;
            outline: none;
        }
        .search-field:focus, .input-field:focus, .select-field:focus, .textarea-field:focus {
            border-color: rgba(196,145,74,0.6);
            box-shadow: 0 0 0 3px rgba(196,145,74,0.12);
        }
        .menu-toggle { display: none; }
        .mobile-drawer {
            position: fixed;
            top: 0;
            right: -100%;
            width: min(360px, 100%);
            height: 100vh;
            background: var(--cream);
            z-index: 1200;
            padding: 32px 28px;
            transition: right 0.3s ease;
            border-left: 1px solid var(--border);
            overflow-y: auto;
        }
        .mobile-drawer.open { right: 0; }
        .mobile-overlay {
            position: fixed;
            inset: 0;
            background: rgba(14,13,12,0.48);
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.25s ease;
            z-index: 1100;
        }
        .mobile-overlay.active {
            opacity: 1;
            pointer-events: auto;
        }
        .mobile-close {
            background: none;
            border: none;
            font-size: 30px;
            cursor: pointer;
            margin-left: auto;
            display: block;
        }
        .mobile-links {
            list-style: none;
            margin-top: 24px;
            display: grid;
            gap: 6px;
        }
        .mobile-links a {
            display: block;
            padding: 12px 0;
            text-decoration: none;
            border-bottom: 1px solid var(--border);
            font-family: var(--serif);
            font-size: 24px;
        }
        .mobile-cta {
            display: grid;
            gap: 12px;
            margin-top: 28px;
        }
        .hero-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.05fr) minmax(0, 0.95fr);
            gap: 34px;
            align-items: stretch;
            min-height: calc(100vh - 146px);
        }
        .hero-copy {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 86px 0;
        }
        .hero-title {
            font-family: var(--serif);
            font-size: clamp(44px, 6vw, 84px);
            line-height: 1.02;
            margin: 20px 0 18px;
        }
        .hero-title em { color: var(--accent); font-style: italic; }
        .hero-copy p {
            max-width: 520px;
            line-height: 1.9;
            color: var(--mid-gray);
            font-size: 15px;
        }
        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            margin-top: 34px;
        }
        .stats-row {
            display: flex;
            flex-wrap: wrap;
            gap: 34px;
            margin-top: 56px;
            padding-top: 34px;
            border-top: 1px solid var(--border);
        }
        .stat-item strong {
            display: block;
            font-family: var(--serif);
            font-size: 34px;
        }
        .stat-item span {
            display: block;
            margin-top: 6px;
            color: var(--mid-gray);
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.12em;
        }
        .hero-visual {
            position: relative;
            min-height: 620px;
            border-radius: 2px;
            overflow: hidden;
            background: linear-gradient(180deg, #dac9b0, #b89a76);
            box-shadow: var(--shadow);
        }
        .hero-visual img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .floating-card, .panel, .metric-card, .product-card, .testimonial-card, .order-card, .cart-item, .mini-card {
            background: rgba(255,255,255,0.66);
            border: 1px solid rgba(14,13,12,0.08);
            box-shadow: var(--shadow);
            backdrop-filter: blur(10px);
        }
        .floating-card {
            position: absolute;
            right: 34px;
            bottom: 34px;
            padding: 22px 24px;
            border-left: 3px solid var(--accent);
            max-width: 260px;
        }
        .floating-card span {
            color: var(--mid-gray);
            font-size: 11px;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }
        .floating-card strong {
            display: block;
            margin-top: 8px;
            font-size: 24px;
            font-family: var(--serif);
        }
        .grid-2, .grid-3, .grid-4 { display: grid; gap: 20px; }
        .grid-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .grid-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .grid-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }
        .panel { padding: 30px; border-radius: 2px; }
        .panel-dark {
            background: var(--black);
            color: var(--cream);
            box-shadow: none;
            border: none;
        }
        .panel-dark .section-copy,
        .panel-dark p,
        .panel-dark .muted { color: rgba(248,245,239,0.68); }
        .muted { color: var(--mid-gray); }
        .value-lg {
            font-family: var(--serif);
            font-size: clamp(34px, 4vw, 58px);
            line-height: 1;
        }
        .category-card {
            position: relative;
            min-height: 340px;
            overflow: hidden;
            border-radius: 2px;
            box-shadow: var(--shadow);
        }
        .category-card img { width: 100%; height: 100%; object-fit: cover; }
        .card-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(14,13,12,0.05) 30%, rgba(14,13,12,0.84) 100%);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 26px;
            color: var(--white);
        }
        .card-overlay h3 {
            font-family: var(--serif);
            font-size: 28px;
            margin-bottom: 6px;
        }
        .card-overlay p { color: rgba(255,255,255,0.75); }
        .link-inline {
            display: inline-block;
            text-decoration: none;
            margin-top: 14px;
            font-size: 12px;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--accent);
            border-bottom: 1px solid currentColor;
            padding-bottom: 2px;
        }
        .product-card {
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 18px 38px rgba(0, 0, 0, 0.14);
        }
        .product-media {
            position: relative;
            aspect-ratio: 3 / 2;
            overflow: hidden;
            background: var(--warm-gray);
        }
        .product-media img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.45s ease;
        }
        .product-card:hover .product-media img { transform: scale(1.04); }
        .product-badge,
        .product-stock {
            position: absolute;
            left: 12px;
            z-index: 2;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 28px;
            padding: 0 10px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
        }
        .product-badge {
            top: 12px;
            background: #22c55e;
            color: #fff;
        }
        .product-stock {
            bottom: 12px;
            background: rgba(0, 0, 0, 0.72);
            color: #fff;
        }
        .product-quick-actions {
            position: absolute;
            right: 12px;
            top: 12px;
            z-index: 2;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .product-quick-btn {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.95);
            color: var(--black);
            text-decoration: none;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
            transition: transform 0.2s ease, color 0.2s ease;
        }
        .product-quick-btn:hover {
            transform: translateY(-1px);
            color: var(--accent-dark);
        }
        .product-body { padding: 15px; }
        .product-topline {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 6px;
        }
        .pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 24px;
            padding: 0 10px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            background: rgba(196,145,74,0.12);
            color: var(--accent-dark);
        }
        .category {
            font-size: 12px;
            color: #6366f1;
            font-weight: 600;
        }
        .product-title {
            font-size: 17px;
            font-weight: 700;
            line-height: 1.45;
            margin-top: 6px;
        }
        .product-description {
            font-size: 13px;
            color: #666;
            margin-top: 8px;
            line-height: 1.6;
        }
        .price-row, .meta-row, .summary-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }
        .price-main {
            font-size: 18px;
            font-weight: 600;
        }
        .price-old {
            color: var(--mid-gray);
            text-decoration: line-through;
            font-size: 13px;
        }
        .product-buttons,
        .product-actions {
            display: flex;
            gap: 10px;
            margin-top: 14px;
        }
        .product-btn {
            flex: 1;
            min-height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            text-decoration: none;
            font-size: 13px;
            border: none;
            cursor: pointer;
            transition: background 0.2s ease, color 0.2s ease;
        }
        .product-btn.view {
            background: #e5e7eb;
            color: var(--black);
        }
        .product-btn.cart {
            background: #6366f1;
            color: #fff;
        }
        .product-btn.cart:hover {
            background: #4f46e5;
        }
        .feature-list {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 0;
            border: 1px solid var(--border);
            background: rgba(255,255,255,0.55);
        }
        .feature-item {
            padding: 28px 22px;
            border-right: 1px solid var(--border);
        }
        .feature-item:last-child { border-right: none; }
        .feature-item strong {
            display: block;
            margin-top: 12px;
            margin-bottom: 8px;
            font-size: 14px;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }
        .feature-item p { color: var(--mid-gray); line-height: 1.7; font-size: 13px; }
        .marquee {
            overflow: hidden;
            background: rgba(232,227,218,0.75);
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }
        .marquee-track {
            display: inline-flex;
            min-width: 200%;
            animation: marquee 24s linear infinite;
        }
        .marquee-item {
            padding: 22px 48px;
            font-family: var(--serif);
            font-size: 20px;
            letter-spacing: 0.1em;
            color: var(--mid-gray);
            text-transform: uppercase;
        }
        @keyframes marquee { from { transform: translateX(0); } to { transform: translateX(-50%); } }
        .testimonial-card, .metric-card, .mini-card, .order-card, .cart-item {
            padding: 24px;
            border-radius: 2px;
        }
        .testimonial-card blockquote {
            font-size: 15px;
            line-height: 1.9;
            color: rgba(14,13,12,0.8);
            margin-bottom: 20px;
        }
        .metric-card strong, .mini-card strong {
            display: block;
            font-family: var(--serif);
            font-size: 28px;
            margin-bottom: 10px;
        }
        .newsletter-box {
            text-align: center;
            padding: 64px 28px;
        }
        .newsletter-form {
            display: flex;
            max-width: 560px;
            margin: 26px auto 0;
            gap: 0;
        }
        .newsletter-form input {
            flex: 1;
            border: 1px solid rgba(255,255,255,0.16);
            background: rgba(255,255,255,0.08);
            color: var(--cream);
            padding: 16px 18px;
            outline: none;
        }
        .newsletter-form button {
            min-width: 170px;
            background: var(--accent);
            color: var(--white);
            border: none;
            cursor: pointer;
            font-size: 12px;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }
        .site-footer {
            background: var(--black);
            color: rgba(248,245,239,0.75);
            margin-top: 40px;
        }
        .footer-grid {
            display: grid;
            grid-template-columns: 1.4fr 1fr 1fr 1fr;
            gap: 36px;
            padding: 72px 0 42px;
        }
        .footer-title {
            color: var(--cream);
            font-size: 11px;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            margin-bottom: 16px;
        }
        .footer-links {
            list-style: none;
            display: grid;
            gap: 10px;
        }
        .footer-links a {
            color: rgba(248,245,239,0.62);
            text-decoration: none;
        }
        .footer-links a:hover { color: var(--accent); }
        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.08);
            padding: 20px 0 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            font-size: 12px;
            color: rgba(248,245,239,0.42);
        }
        .stack-md > * + * { margin-top: 18px; }
        .stack-lg > * + * { margin-top: 28px; }
        .detail-layout, .checkout-layout, .cart-layout, .contact-layout {
            display: grid;
            gap: 24px;
        }
        .detail-layout { grid-template-columns: minmax(0, 0.95fr) minmax(0, 1.05fr); }
        .checkout-layout, .cart-layout, .contact-layout { grid-template-columns: minmax(0, 1.05fr) minmax(320px, 0.95fr); }
        .detail-image {
            border-radius: 2px;
            overflow: hidden;
            box-shadow: var(--shadow);
            min-height: 560px;
            background: var(--warm-gray);
        }
        .detail-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .summary-box {
            padding: 24px;
            background: rgba(255,255,255,0.72);
            border: 1px solid rgba(14,13,12,0.08);
        }
        .cart-item {
            display: grid;
            grid-template-columns: 120px minmax(0, 1fr) auto;
            gap: 18px;
            align-items: center;
        }
        .cart-item img {
            width: 120px;
            height: 140px;
            object-fit: cover;
            border-radius: 2px;
        }
        .qty-form {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 14px;
        }
        .qty-form input {
            width: 92px;
            padding: 12px;
            border: 1px solid rgba(14,13,12,0.14);
            background: rgba(255,255,255,0.86);
        }
        .contact-list { display: grid; gap: 14px; margin-top: 24px; }
        .contact-list .mini-card { display: flex; align-items: center; justify-content: space-between; gap: 14px; }
        .status-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 28px;
            padding: 0 12px;
            border-radius: 999px;
            font-size: 11px;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            font-weight: 700;
        }
        .status-pending { background: rgba(196,145,74,0.14); color: var(--accent-dark); }
        .status-onway { background: rgba(47, 116, 177, 0.12); color: #2f74b1; }
        .status-delivered { background: rgba(29,122,82,0.14); color: var(--success); }
        .status-cancelled { background: rgba(183,70,53,0.12); color: var(--danger); }
        .order-card { display: grid; gap: 18px; }
        .order-head, .order-foot {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
        }
        .order-body {
            display: grid;
            grid-template-columns: 110px minmax(0, 1fr) auto;
            gap: 18px;
            align-items: center;
        }
        .order-body img {
            width: 110px;
            height: 132px;
            object-fit: cover;
            border-radius: 2px;
        }
        .pagination-wrap nav { display: flex; justify-content: center; }
        .pagination-wrap svg { width: 18px; height: 18px; }
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }
        .delay-1 { transition-delay: 0.08s; }
        .delay-2 { transition-delay: 0.16s; }
        .delay-3 { transition-delay: 0.24s; }
        @media (max-width: 1100px) {
            .grid-4 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .grid-3 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .feature-list { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .feature-item:nth-child(2) { border-right: none; }
            .feature-item:nth-child(-n+2) { border-bottom: 1px solid var(--border); }
            .footer-grid { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 920px) {
            .nav-links, .desktop-only { display: none; }
            .menu-toggle { display: inline-flex; }
            .hero-grid,
            .detail-layout,
            .checkout-layout,
            .cart-layout,
            .contact-layout,
            .grid-2,
            .grid-3 { grid-template-columns: 1fr; }
            .hero-visual { min-height: 440px; }
            .section-header,
            .footer-bottom { flex-direction: column; align-items: flex-start; }
        }
        @media (max-width: 680px) {
            .page-container { width: min(100% - 28px, 1400px); }
            .nav-row { min-height: 70px; }
            .brand-logo-icon { width: 38px; height: 38px; }
            .brand-wordmark { font-size: 24px; }
            .search-form,
            .newsletter-form,
            .product-actions,
            .order-head,
            .order-foot { flex-direction: column; }
            .cart-item,
            .order-body,
            .grid-4 { grid-template-columns: 1fr; }
            .stats-row { gap: 20px; }
            .feature-list { grid-template-columns: 1fr; }
            .feature-item { border-right: none; border-bottom: 1px solid var(--border); }
            .feature-item:last-child { border-bottom: none; }
            .footer-grid { grid-template-columns: 1fr; }
            .newsletter-form button { min-height: 52px; width: 100%; }
            .search-panel { padding-bottom: 18px; }
        }
    </style>
    @stack('head')
</head>
<body>
    <div class="page-shell">
        @include('Home.topbar')
        @include('Home.header')
        <main>@yield('content')</main>
        @include('Home.info')
    </div>

    <script>
        const menuToggle = document.getElementById('menuToggle');
        const mobileDrawer = document.getElementById('mobileDrawer');
        const mobileOverlay = document.getElementById('mobileOverlay');
        const closeMenu = () => {
            mobileDrawer?.classList.remove('open');
            mobileOverlay?.classList.remove('active');
        };
        menuToggle?.addEventListener('click', () => {
            mobileDrawer?.classList.add('open');
            mobileOverlay?.classList.add('active');
        });
        document.getElementById('mobileClose')?.addEventListener('click', closeMenu);
        mobileOverlay?.addEventListener('click', closeMenu);
        document.getElementById('searchToggle')?.addEventListener('click', () => {
            const panel = document.getElementById('searchPanel');
            panel?.classList.toggle('active');
            if (panel?.classList.contains('active')) {
                document.getElementById('globalSearchField')?.focus();
            }
        });
        window.addEventListener('scroll', () => {
            document.getElementById('siteHeader')?.classList.toggle('scrolled', window.scrollY > 30);
        });
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12 });
        document.querySelectorAll('.reveal').forEach((item) => revealObserver.observe(item));
        document.getElementById('yearNow')?.append(new Date().getFullYear());
    </script>
    @stack('scripts')
</body>
</html>
