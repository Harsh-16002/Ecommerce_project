<link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
@include('Home.css')

<style>
    :root {
        --auth-ink: #171717;
        --auth-muted: #6b6b6b;
        --auth-line: rgba(23, 23, 23, 0.12);
        --auth-panel: rgba(255, 255, 255, 0.82);
        --auth-accent: #c4914a;
        --auth-accent-dark: #9b723d;
        --auth-deep: #161514;
        --auth-hero-start: #111111;
        --auth-hero-end: #2c241b;
        --auth-success: #166534;
        --auth-danger: #b42318;
        --auth-shadow: 0 24px 70px rgba(19, 16, 12, 0.14);
        --auth-serif: 'Space Grotesk', sans-serif;
        --auth-sans: 'Manrope', sans-serif;
    }

    * { box-sizing: border-box; }

    body.auth-page {
        margin: 0;
        min-height: 100vh;
        font-family: var(--auth-sans);
        color: var(--auth-ink);
        background:
            radial-gradient(circle at top left, rgba(196, 145, 74, 0.18), transparent 28%),
            linear-gradient(180deg, #fcfaf5 0%, #f6efe4 100%);
    }

    .auth-shell {
        min-height: 100vh;
        display: grid;
        grid-template-columns: minmax(320px, 1.05fr) minmax(320px, 0.95fr);
    }

    .auth-hero {
        position: relative;
        overflow: hidden;
        padding: 64px clamp(28px, 6vw, 72px);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        color: #f8f5ef;
        background:
            radial-gradient(circle at top right, rgba(196, 145, 74, 0.18), transparent 24%),
            linear-gradient(145deg, var(--auth-hero-start), var(--auth-hero-end));
    }

    .auth-hero::before,
    .auth-hero::after {
        content: "";
        position: absolute;
        border-radius: 999px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        pointer-events: none;
    }

    .auth-hero::before {
        width: 320px;
        height: 320px;
        top: -110px;
        right: -90px;
    }

    .auth-hero::after {
        width: 220px;
        height: 220px;
        bottom: -70px;
        left: -40px;
    }

    .auth-brand,
    .auth-home-link {
        position: relative;
        z-index: 1;
        text-decoration: none;
        color: inherit;
    }

    .auth-brand {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        font-size: 13px;
    }

    .auth-brand-mark {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        display: block;
        object-fit: cover;
        box-shadow: 0 14px 28px rgba(0, 0, 0, 0.22);
    }

    .auth-hero-body,
    .auth-hero-footer {
        position: relative;
        z-index: 1;
    }

    .auth-kicker {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        font-size: 12px;
        letter-spacing: 0.16em;
        text-transform: uppercase;
        color: rgba(248, 245, 239, 0.72);
    }

    .auth-kicker::before {
        content: "";
        width: 34px;
        height: 1px;
        background: rgba(248, 245, 239, 0.48);
    }

    .auth-hero-title {
        font-family: var(--auth-serif);
        font-size: clamp(40px, 5vw, 72px);
        line-height: 0.98;
        letter-spacing: -0.03em;
        margin: 22px 0 20px;
        max-width: 560px;
    }

    .auth-hero-copy {
        max-width: 520px;
        font-size: 16px;
        line-height: 1.8;
        color: rgba(248, 245, 239, 0.72);
    }

    .auth-highlights {
        display: grid;
        gap: 14px;
        margin-top: 38px;
        max-width: 520px;
    }

    .auth-highlight {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 16px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        background: rgba(255, 255, 255, 0.06);
        backdrop-filter: blur(10px);
    }

    .auth-highlight-index {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(196, 145, 74, 0.18);
        color: #f3d7a9;
        font-size: 12px;
        font-weight: 800;
    }

    .auth-home-link {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        color: rgba(248, 245, 239, 0.72);
        font-size: 14px;
    }

    .auth-panel {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 36px 22px;
    }

    .auth-card {
        width: min(100%, 520px);
        background: var(--auth-panel);
        backdrop-filter: blur(14px);
        border: 1px solid rgba(255, 255, 255, 0.65);
        box-shadow: var(--auth-shadow);
        border-radius: 28px;
        padding: clamp(26px, 4vw, 40px);
    }

    .auth-card-header { margin-bottom: 28px; }

    .auth-card-kicker {
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: var(--auth-accent-dark);
    }

    .auth-card-title {
        font-family: var(--auth-serif);
        font-size: clamp(28px, 3vw, 42px);
        line-height: 1.06;
        letter-spacing: -0.03em;
        margin: 12px 0 10px;
    }

    .auth-card-copy {
        color: var(--auth-muted);
        line-height: 1.7;
        margin: 0;
    }

    .auth-status {
        margin-bottom: 18px;
        padding: 12px 14px;
        border-radius: 14px;
        background: rgba(22, 101, 52, 0.08);
        color: var(--auth-success);
        font-size: 14px;
        line-height: 1.6;
    }

    .auth-form {
        display: grid;
        gap: 18px;
    }

    .auth-grid {
        display: grid;
        gap: 18px;
    }

    .auth-grid.two {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .auth-field {
        display: grid;
        gap: 8px;
    }

    .auth-label {
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #4e4a45;
    }

    .auth-input {
        width: 100%;
        min-height: 54px;
        border-radius: 16px;
        border: 1px solid var(--auth-line);
        background: rgba(255, 255, 255, 0.84);
        padding: 0 16px;
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
    }

    .auth-input:focus {
        border-color: rgba(196, 145, 74, 0.9);
        box-shadow: 0 0 0 4px rgba(196, 145, 74, 0.14);
        transform: translateY(-1px);
    }

    .auth-error {
        margin: 0;
        padding-left: 18px;
        color: var(--auth-danger);
        font-size: 13px;
        line-height: 1.5;
    }

    .auth-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        flex-wrap: wrap;
    }

    .auth-check {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        color: #4e4a45;
        font-size: 14px;
    }

    .auth-check input {
        width: 16px;
        height: 16px;
        accent-color: var(--auth-accent);
    }

    .auth-link {
        color: var(--auth-accent-dark);
        text-decoration: none;
        font-weight: 700;
    }

    .auth-link:hover {
        color: var(--auth-accent);
    }

    .auth-submit {
        min-height: 56px;
        border: none;
        border-radius: 16px;
        background: linear-gradient(135deg, var(--auth-deep), #2e261e);
        color: #f8f5ef;
        font-weight: 800;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
    }

    .auth-submit:hover {
        transform: translateY(-1px);
        box-shadow: 0 18px 28px rgba(23, 18, 13, 0.18);
        background: linear-gradient(135deg, #2e261e, #c4914a);
    }

    .auth-secondary {
        min-height: 54px;
        border-radius: 16px;
        border: 1px solid var(--auth-line);
        background: rgba(255, 255, 255, 0.76);
        color: var(--auth-ink);
        font-weight: 700;
        transition: border-color 0.2s ease, transform 0.2s ease, color 0.2s ease;
    }

    .auth-secondary:hover {
        transform: translateY(-1px);
        border-color: rgba(196, 145, 74, 0.7);
        color: var(--auth-accent-dark);
    }

    .auth-copy {
        color: var(--auth-muted);
        line-height: 1.75;
        margin: 0;
    }

    .auth-footer {
        margin-top: 6px;
        text-align: center;
        color: var(--auth-muted);
        line-height: 1.7;
    }

    .auth-divider {
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(23, 23, 23, 0.1), transparent);
        margin: 6px 0 2px;
    }

    @media (max-width: 980px) {
        .auth-shell { grid-template-columns: 1fr; }
        .auth-hero { min-height: auto; gap: 36px; }
        .auth-panel { padding-top: 0; }
    }

    @media (max-width: 640px) {
        .auth-panel { padding: 18px; }
        .auth-card { border-radius: 22px; }
        .auth-grid.two { grid-template-columns: 1fr; }
        .auth-row { align-items: flex-start; flex-direction: column; }
    }
</style>
