<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>MarketVerse Admin</title>
<link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('/admincss/vendor/font-awesome/css/font-awesome.min.css') }}">

<style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
        --admin-bg: #eef2ff;
        --admin-surface: #ffffff;
        --admin-surface-soft: #f8faff;
        --admin-border: #e3e9f8;
        --admin-text: #1f2340;
        --admin-muted: #7a84a0;
        --admin-primary: #6366f1;
        --admin-primary-dark: #4648af;
        --admin-secondary: #2b2f77;
        --admin-sidebar: linear-gradient(180deg, #2b2f77, #1c1f4a);
        --admin-success-bg: #d1fae5;
        --admin-success-text: #065f46;
        --admin-warn-bg: #fef3c7;
        --admin-warn-text: #92400e;
        --admin-info-bg: #dbeafe;
        --admin-info-text: #1e40af;
        --admin-purple-bg: #e0e7ff;
        --admin-purple-text: #3730a3;
        --admin-shadow: 0 18px 45px rgba(99, 102, 241, 0.08);
    }
    body.admin-ui {
        font-family: 'Poppins', sans-serif;
        background: var(--admin-bg);
        color: var(--admin-text);
    }
    a { color: inherit; }
    .admin-shell {
        min-height: 100vh;
        display: grid;
        grid-template-columns: 280px minmax(0, 1fr);
        position: relative;
    }
    .admin-sidebar {
        background: var(--admin-sidebar);
        color: #fff;
        padding: 24px 18px;
        position: sticky;
        top: 0;
        height: 100vh;
        overflow-y: auto;
        z-index: 30;
    }
    .admin-sidebar-overlay {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.45);
        border: 0;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.2s ease;
        z-index: 25;
    }
    .admin-sidebar-mobile-bar {
        display: none;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 14px;
        padding-bottom: 14px;
        border-bottom: 1px solid rgba(255,255,255,0.12);
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
    }
    .admin-sidebar-close,
    .admin-menu-toggle {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        border: 1px solid var(--admin-border);
        background: #fff;
        color: var(--admin-text);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        flex-shrink: 0;
    }
    .admin-brand {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 8px 10px 22px;
        color: #fff;
        text-decoration: none;
        border-bottom: 1px solid rgba(255,255,255,0.12);
        margin-bottom: 18px;
    }
    .admin-brand-icon {
        width: 46px;
        height: 46px;
        border-radius: 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(255,255,255,0.12);
        font-size: 18px;
    }
    .admin-brand strong { font-size: 20px; display: block; }
    .admin-brand span { color: rgba(255,255,255,0.72); font-size: 12px; }
    .admin-nav-section + .admin-nav-section { margin-top: 20px; }
    .admin-nav-label {
        padding: 0 10px 10px;
        font-size: 11px;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        color: rgba(255,255,255,0.5);
    }
    .admin-nav {
        list-style: none;
        display: grid;
        gap: 6px;
    }
    .admin-nav-link,
    .admin-nav-disabled {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 12px 14px;
        border-radius: 12px;
        text-decoration: none;
        transition: 0.25s ease;
    }
    .admin-nav-link:hover,
    .admin-nav-link.active {
        background: rgba(255,255,255,0.14);
        transform: translateX(4px);
    }
    .admin-nav-disabled {
        color: rgba(255,255,255,0.5);
        cursor: not-allowed;
        background: rgba(255,255,255,0.03);
    }
    .admin-nav-main {
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }
    .admin-nav-badge {
        min-width: 30px;
        height: 24px;
        padding: 0 8px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(255,255,255,0.16);
        font-size: 11px;
        font-weight: 600;
    }
    .admin-stage {
        min-width: 0;
        padding: 24px;
    }
    .admin-topbar {
        background: rgba(255,255,255,0.75);
        border: 1px solid var(--admin-border);
        border-radius: 18px;
        padding: 20px 24px;
        margin-bottom: 22px;
        box-shadow: var(--admin-shadow);
        backdrop-filter: blur(10px);
    }
    .admin-topbar-inner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
    }
    .admin-topbar-heading {
        display: grid;
        gap: 0;
        min-width: 0;
    }
    .admin-menu-toggle {
        display: none;
        margin-bottom: 14px;
    }
    .admin-kicker {
        color: var(--admin-primary);
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        margin-bottom: 8px;
    }
    .admin-topbar-title {
        font-size: 28px;
        font-weight: 600;
        line-height: 1.1;
    }
    .admin-topbar-subtitle {
        color: var(--admin-muted);
        margin-top: 6px;
        font-size: 14px;
    }
    .admin-search {
        flex: 1;
        max-width: 420px;
    }
    .admin-search input,
    .admin-field input,
    .admin-field textarea,
    .admin-field select {
        width: 100%;
        border: 1px solid var(--admin-border);
        background: #fff;
        color: var(--admin-text);
        padding: 14px 16px;
        border-radius: 12px;
        outline: none;
    }
    .admin-field textarea { min-height: 140px; resize: vertical; }
    .admin-search input:focus,
    .admin-field input:focus,
    .admin-field textarea:focus,
    .admin-field select:focus {
        border-color: rgba(99, 102, 241, 0.55);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }
    .admin-topbar-actions {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        justify-content: flex-end;
    }
    .admin-btn,
    .admin-btn-outline,
    .admin-status-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 44px;
        padding: 0 18px;
        border-radius: 12px;
        text-decoration: none;
        border: none;
        cursor: pointer;
        font-weight: 600;
        transition: 0.2s ease;
    }
    .admin-btn {
        background: var(--admin-primary);
        color: #fff;
        box-shadow: 0 10px 25px rgba(99, 102, 241, 0.22);
    }
    .admin-btn:hover { background: var(--admin-primary-dark); }
    .admin-btn-outline {
        background: #fff;
        color: var(--admin-text);
        border: 1px solid var(--admin-border);
    }
    .admin-btn-outline:hover {
        border-color: rgba(99,102,241,0.35);
        color: var(--admin-primary);
    }
    .admin-content {
        display: grid;
        gap: 20px;
    }
    .admin-page-head {
        display: flex;
        align-items: end;
        justify-content: space-between;
        gap: 20px;
    }
    .admin-eyebrow {
        color: var(--admin-primary);
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        margin-bottom: 10px;
    }
    .admin-page-title {
        font-size: clamp(28px, 3vw, 38px);
        font-weight: 600;
        line-height: 1.1;
    }
    .admin-muted {
        color: var(--admin-muted);
        font-size: 14px;
        line-height: 1.7;
    }
    .admin-stats-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
    }
    .admin-card {
        background: var(--admin-surface);
        border: 1px solid var(--admin-border);
        border-radius: 18px;
        padding: 20px;
        box-shadow: var(--admin-shadow);
    }
    .admin-stat-card { padding: 22px; }
    .admin-stat-card .admin-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(99, 102, 241, 0.12);
        color: var(--admin-primary);
        margin-bottom: 16px;
        font-size: 18px;
    }
    .admin-stat-value {
        font-size: clamp(24px, 3vw, 34px);
        font-weight: 700;
        line-height: 1.1;
        margin-top: 10px;
    }
    .admin-stat-foot {
        color: var(--admin-muted);
        margin-top: 8px;
        font-size: 13px;
    }
    .admin-dashboard-grid {
        display: grid;
        grid-template-columns: minmax(0, 2fr) minmax(320px, 1fr);
        gap: 20px;
    }
    .admin-grid,
    .admin-mini-grid,
    .admin-form-grid {
        display: grid;
        gap: 16px;
    }
    .admin-mini-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    .admin-form-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    .admin-field.full { grid-column: 1 / -1; }
    .admin-field label {
        display: block;
        margin-bottom: 8px;
        font-size: 13px;
        font-weight: 600;
        color: var(--admin-muted);
    }
    .admin-card-head {
        display: flex;
        align-items: start;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 18px;
    }
    .admin-card-title {
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 4px;
    }
    .admin-chart {
        position: relative;
        min-height: 320px;
    }
    .admin-list {
        display: grid;
        gap: 12px;
    }
    .admin-list.compact {
        gap: 8px;
    }
    .admin-list-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 12px 0;
        border-bottom: 1px solid #eef2fa;
    }
    .admin-list-item:last-child { border-bottom: none; }
    .admin-list-item.top {
        align-items: flex-start;
    }
    .admin-list-thumb {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        overflow: hidden;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: var(--admin-surface-soft);
        color: var(--admin-primary);
        flex-shrink: 0;
    }
    .admin-list-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .admin-min-zero {
        min-width: 0;
    }
    .admin-align-end {
        text-align: right;
    }
    .admin-media-row {
        display: flex;
        align-items: center;
        gap: 14px;
        min-width: 0;
    }
    .admin-actions-stack {
        display: grid;
        gap: 8px;
    }
    .admin-status-form {
        display: grid;
        gap: 8px;
        min-width: 180px;
    }
    .admin-fill-btn {
        width: 100%;
    }
    .admin-preview-image {
        width: min(180px, 100%);
        aspect-ratio: 1 / 1;
        object-fit: cover;
        border-radius: 16px;
    }
    .admin-chart.short {
        min-height: 240px;
    }
    .admin-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 28px;
        padding: 0 10px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
    }
    .admin-badge.delivered { background: var(--admin-success-bg); color: var(--admin-success-text); }
    .admin-badge.pending { background: var(--admin-warn-bg); color: var(--admin-warn-text); }
    .admin-badge.onway,
    .admin-badge.processing { background: var(--admin-info-bg); color: var(--admin-info-text); }
    .admin-badge.payment { background: var(--admin-purple-bg); color: var(--admin-purple-text); }
    .admin-badge.cancelled { background: #fee2e2; color: #991b1b; }
    .admin-badge.returned { background: #ede9fe; color: #5b21b6; }
    .admin-table-wrap {
        overflow: auto;
        border-radius: 14px;
        border: 1px solid #eef2fa;
    }
    .admin-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 820px;
        background: #fff;
    }
    .admin-table th,
    .admin-table td {
        padding: 16px 14px;
        text-align: left;
        vertical-align: top;
        border-bottom: 1px solid #eef2fa;
    }
    .admin-table th {
        color: var(--admin-muted);
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }
    .admin-table img {
        width: 54px;
        height: 54px;
        border-radius: 12px;
        object-fit: cover;
    }
    .admin-kpi span {
        display: block;
        color: var(--admin-muted);
        font-size: 13px;
        margin-bottom: 8px;
    }
    .admin-kpi strong {
        font-size: 30px;
        font-weight: 700;
    }
    .admin-status-btn.warning {
        background: var(--admin-info-bg);
        color: var(--admin-info-text);
    }
    .admin-status-btn.success {
        background: var(--admin-success-bg);
        color: var(--admin-success-text);
    }
    @media (max-width: 1180px) {
        .admin-shell { grid-template-columns: 1fr; }
        .admin-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: min(320px, calc(100vw - 24px));
            max-width: 100%;
            height: 100vh;
            border-radius: 0 24px 24px 0;
            transform: translateX(-110%);
            transition: transform 0.24s ease;
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.3);
        }
        body.admin-sidebar-open .admin-sidebar { transform: translateX(0); }
        body.admin-sidebar-open { overflow: hidden; }
        body.admin-sidebar-open .admin-sidebar-overlay {
            opacity: 1;
            pointer-events: auto;
        }
        .admin-sidebar-mobile-bar,
        .admin-menu-toggle { display: inline-flex; }
        .admin-sidebar-mobile-bar { display: flex; }
        .admin-stage { padding-top: 18px; }
        .admin-stats-grid,
        .admin-mini-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .admin-dashboard-grid { grid-template-columns: 1fr; }
        .admin-topbar-inner { align-items: flex-start; }
        .admin-search { max-width: none; }
    }
    @media (max-width: 760px) {
        .admin-stage { padding: 16px; }
        .admin-topbar-inner,
        .admin-page-head { flex-direction: column; align-items: flex-start; }
        .admin-topbar { padding: 18px; }
        .admin-topbar-title { font-size: 24px; }
        .admin-topbar-subtitle { font-size: 13px; }
        .admin-search,
        .admin-topbar-actions { max-width: none; width: 100%; }
        .admin-topbar-actions > * { width: 100%; }
        .admin-topbar-actions form,
        .admin-topbar-actions form button { width: 100%; }
        .admin-card,
        .admin-stat-card { padding: 16px; }
        .admin-card-head,
        .admin-list-item { flex-direction: column; align-items: flex-start; }
        .admin-media-row {
            width: 100%;
            align-items: flex-start;
        }
        .admin-status-form,
        .admin-actions-stack,
        .admin-align-end {
            width: 100%;
        }
        .admin-align-end {
            text-align: left;
        }
        .admin-stats-grid,
        .admin-mini-grid,
        .admin-form-grid { grid-template-columns: 1fr; width: 100%; }
        .admin-table th,
        .admin-table td { padding: 12px 10px; }
        .admin-table img { width: 44px; height: 44px; }
        .admin-btn,
        .admin-btn-outline,
        .admin-status-btn { width: 100%; }
    }
    @media (max-width: 520px) {
        .admin-stage { padding: 12px; }
        .admin-topbar { padding: 16px; border-radius: 16px; }
        .admin-sidebar { width: calc(100vw - 18px); }
        .admin-brand { padding-left: 0; padding-right: 0; }
        .admin-nav-link,
        .admin-nav-disabled { padding: 11px 12px; }
        .admin-table { min-width: 680px; }
        .admin-status-form { min-width: 150px; }
    }
</style>
