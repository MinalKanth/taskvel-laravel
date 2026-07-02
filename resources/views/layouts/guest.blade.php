<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Taskvel') }} — @yield('auth_title', 'Welcome')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Sora:wght@700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
    /*══════════════════════════════════════════════════════
      TASKVEL AUTH LAYOUT
      Split-screen: deep-space left panel + clean right form
    ══════════════════════════════════════════════════════*/

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
        --ink:     #6d5efc;
        --ink-2:   #a06dfc;
        --ink-3:   #c084fc;
        --surface: #0d0b14;
        --panel:   #110f1a;
        --border:  rgba(255,255,255,.07);
        --text-hi: #ffffff;
        --text-lo: rgba(255,255,255,.48);
        --radius:  18px;
    }

    html, body { height: 100%; }

    body {
        font-family: 'Inter', sans-serif;
        background: #f4f3ff;
        display: flex;
        min-height: 100vh;
    }

    /*── Layout ──────────────────────────────────────────*/

    .auth-wrap {
        display: grid;
        grid-template-columns: 1fr 1fr;
        min-height: 100vh;
        width: 100%;
    }

    /*── LEFT PANEL ──────────────────────────────────────*/

    .auth-left {
        position: relative;
        background: var(--surface);
        display: flex;
        flex-direction: column;
        padding: 48px 52px;
        overflow: hidden;
    }

    /* Noise texture overlay */
    .auth-left::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
        pointer-events: none;
        z-index: 0;
    }

    /* Gradient orbs */
    .orb {
        position: absolute;
        border-radius: 50%;
        filter: blur(80px);
        pointer-events: none;
        z-index: 0;
    }
    .orb-1 {
        width: 420px; height: 420px;
        background: radial-gradient(circle, rgba(109,94,252,.32), transparent 70%);
        top: -100px; left: -80px;
    }
    .orb-2 {
        width: 300px; height: 300px;
        background: radial-gradient(circle, rgba(160,109,252,.18), transparent 70%);
        bottom: 40px; right: -60px;
    }
    .orb-3 {
        width: 200px; height: 200px;
        background: radial-gradient(circle, rgba(192,132,252,.14), transparent 70%);
        top: 50%; left: 55%;
        transform: translate(-50%,-50%);
    }

    .auth-left > * { position: relative; z-index: 1; }

    /*── Brand mark ──────────────────────────────────────*/

    .brand {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: auto;
        text-decoration: none;
    }

    .brand-icon {
        width: 44px; height: 44px;
        border-radius: 13px;
        background: linear-gradient(135deg, #6d5efc, #a06dfc);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.25rem; color: #fff;
        box-shadow: 0 8px 24px rgba(109,94,252,.45);
        flex-shrink: 0;
    }

    .brand-name {
        font-family: 'Sora', sans-serif;
        font-weight: 800;
        font-size: 1.35rem;
        color: #fff;
        letter-spacing: -.03em;
    }

    .brand-tagline {
        font-size: .68rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .1em;
        color: var(--text-lo);
        display: block;
        margin-top: 1px;
    }

    /*── Hero area ───────────────────────────────────────*/

    .auth-hero {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 40px 0;
    }

    .hero-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 5px 14px;
        border-radius: 999px;
        background: rgba(109,94,252,.14);
        border: 1px solid rgba(109,94,252,.28);
        color: #b6a9ff;
        font-size: .74rem;
        font-weight: 700;
        letter-spacing: .05em;
        text-transform: uppercase;
        margin-bottom: 24px;
        width: fit-content;
    }

    .hero-eyebrow::before {
        content: '';
        width: 6px; height: 6px;
        border-radius: 50%;
        background: #6d5efc;
        box-shadow: 0 0 6px #6d5efc;
        animation: blip 2s ease-in-out infinite;
    }

    @keyframes blip {
        0%,100% { opacity: 1; }
        50%      { opacity: .3; }
    }

    .hero-title {
        font-family: 'Sora', sans-serif;
        font-weight: 800;
        font-size: 2.6rem;
        line-height: 1.12;
        letter-spacing: -.04em;
        color: #fff;
        margin-bottom: 18px;
    }

    .hero-title .accent {
        background: linear-gradient(135deg, #a78bfa, #c084fc, #e879f9);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .hero-sub {
        font-size: .97rem;
        line-height: 1.7;
        color: var(--text-lo);
        max-width: 400px;
        margin-bottom: 44px;
    }

    /*── Focus ring — SIGNATURE ELEMENT ──────────────────*/

    .focus-ring-wrap {
        display: flex;
        align-items: center;
        gap: 28px;
        margin-bottom: 48px;
    }

    .focus-ring {
        position: relative;
        width: 90px;
        height: 90px;
        flex-shrink: 0;
    }

    .focus-ring svg {
        width: 100%;
        height: 100%;
        transform: rotate(-90deg);
    }

    .ring-track {
        fill: none;
        stroke: rgba(109,94,252,.15);
        stroke-width: 6;
    }

    .ring-fill {
        fill: none;
        stroke: url(#ringGrad);
        stroke-width: 6;
        stroke-linecap: round;
        stroke-dasharray: 226;
        stroke-dashoffset: 56;   /* ~75% filled */
        animation: ringPulse 4s ease-in-out infinite;
    }

    @keyframes ringPulse {
        0%,100% { stroke-dashoffset: 56; }
        50%      { stroke-dashoffset: 90; }
    }

    .ring-inner {
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .ring-time {
        font-family: 'Sora', sans-serif;
        font-size: 1rem;
        font-weight: 800;
        color: #fff;
        line-height: 1;
    }

    .ring-label {
        font-size: .55rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .08em;
        color: var(--text-lo);
        margin-top: 3px;
    }

    .focus-ring-info h6 {
        font-weight: 700;
        color: #fff;
        font-size: .92rem;
        margin-bottom: 4px;
    }

    .focus-ring-info p {
        font-size: .8rem;
        color: var(--text-lo);
        line-height: 1.5;
        margin: 0;
    }

    /*── Feature chips ────────────────────────────────────*/

    .feature-chips {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .feature-chip {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px 16px;
        border-radius: 14px;
        background: rgba(255,255,255,.04);
        border: 1px solid var(--border);
        transition: border-color .2s, background .2s;
    }

    .feature-chip:hover {
        background: rgba(109,94,252,.08);
        border-color: rgba(109,94,252,.25);
    }

    .chip-icon {
        width: 36px; height: 36px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: .95rem;
        flex-shrink: 0;
    }

    .chip-title {
        font-size: .85rem;
        font-weight: 600;
        color: #fff;
        margin-bottom: 2px;
    }

    .chip-desc {
        font-size: .74rem;
        color: var(--text-lo);
        line-height: 1.4;
    }

    /*── Social proof ─────────────────────────────────────*/

    .auth-proof {
        margin-top: 40px;
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .proof-avatars {
        display: flex;
    }

    .proof-avatar {
        width: 32px; height: 32px;
        border-radius: 50%;
        border: 2px solid var(--surface);
        margin-left: -8px;
        font-size: .7rem;
        font-weight: 700;
        color: #fff;
        display: flex; align-items: center; justify-content: center;
    }

    .proof-avatar:first-child { margin-left: 0; }

    .proof-text {
        font-size: .78rem;
        color: var(--text-lo);
        line-height: 1.4;
    }

    .proof-text strong { color: rgba(255,255,255,.75); }

    .proof-stars {
        display: flex;
        gap: 2px;
        margin-bottom: 3px;
    }

    .proof-stars i { color: #fbbf24; font-size: .7rem; }

    /*── RIGHT PANEL ─────────────────────────────────────*/

    .auth-right {
        background: #fff;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 52px 60px;
        position: relative;
        overflow: hidden;
    }

    /* Subtle top-right accent */
    .auth-right::before {
        content: '';
        position: absolute;
        top: -80px; right: -80px;
        width: 280px; height: 280px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(109,94,252,.07), transparent 70%);
        pointer-events: none;
    }

    .auth-right::after {
        content: '';
        position: absolute;
        bottom: -60px; left: -60px;
        width: 200px; height: 200px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(160,109,252,.05), transparent 70%);
        pointer-events: none;
    }

    .auth-form-wrap {
        width: 100%;
        max-width: 400px;
        position: relative;
        z-index: 1;
    }

    /* Form heading shown via slot — override in login/register views */
    .auth-form-header {
        margin-bottom: 32px;
        text-align: center;
    }

    .auth-form-header h2 {
        font-family: 'Sora', sans-serif;
        font-weight: 800;
        font-size: 1.75rem;
        letter-spacing: -.03em;
        color: #1a1528;
        margin-bottom: 8px;
    }

    .auth-form-header p {
        font-size: .88rem;
        color: #8a8a9a;
        line-height: 1.5;
    }

    /* Divider */
    .auth-divider {
        display: flex;
        align-items: center;
        gap: 14px;
        margin: 24px 0;
        font-size: .78rem;
        color: #b0b0c0;
        font-weight: 500;
    }

    .auth-divider::before,
    .auth-divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #eceaf6;
    }

    /* Bottom link */
    .auth-switch {
        text-align: center;
        margin-top: 28px;
        font-size: .84rem;
        color: #8a8a9a;
    }

    .auth-switch a {
        color: #6d5efc;
        font-weight: 600;
        text-decoration: none;
    }

    .auth-switch a:hover { text-decoration: underline; }

    /* Trust badges */
    .auth-trust {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 20px;
        margin-top: 40px;
        padding-top: 28px;
        border-top: 1px solid #f0eeff;
    }

    .trust-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: .72rem;
        color: #a0a0b8;
        font-weight: 500;
    }

    .trust-item i { color: #6d5efc; font-size: .8rem; }

    /*── Form element overrides (works with Breeze defaults) ──*/

    /* Inputs */
    .auth-form-wrap input[type="text"],
    .auth-form-wrap input[type="email"],
    .auth-form-wrap input[type="password"] {
        width: 100%;
        padding: 12px 16px;
        border: 1.5px solid #e8e4f8;
        border-radius: 12px;
        font-size: .9rem;
        font-family: 'Inter', sans-serif;
        color: #1a1528;
        background: #fdfcff;
        transition: border-color .2s, box-shadow .2s;
        outline: none;
    }

    .auth-form-wrap input[type="text"]:focus,
    .auth-form-wrap input[type="email"]:focus,
    .auth-form-wrap input[type="password"]:focus {
        border-color: #6d5efc;
        box-shadow: 0 0 0 4px rgba(109,94,252,.1);
        background: #fff;
    }

    /* Labels */
    .auth-form-wrap label {
        display: block;
        font-size: .82rem;
        font-weight: 600;
        color: #3a3a4a;
        margin-bottom: 7px;
    }

    /* Primary button */
    .auth-form-wrap button[type="submit"],
    .auth-form-wrap .auth-submit {
        width: 100%;
        padding: 13px;
        border: none;
        border-radius: 13px;
        background: linear-gradient(135deg, #6d5efc, #a06dfc);
        color: #fff;
        font-size: .95rem;
        font-weight: 700;
        font-family: 'Inter', sans-serif;
        cursor: pointer;
        box-shadow: 0 10px 28px rgba(109,94,252,.35);
        transition: all .22s ease;
    }

    .auth-form-wrap button[type="submit"]:hover,
    .auth-form-wrap .auth-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 16px 36px rgba(109,94,252,.45);
    }

    /* Error text */
    .auth-form-wrap .text-red-600,
    .auth-form-wrap .text-sm.text-red-600 {
        font-size: .78rem;
        color: #ef4444;
        margin-top: 5px;
        display: block;
    }

    /* Remember me checkbox */
    .auth-form-wrap input[type="checkbox"] {
        accent-color: #6d5efc;
        width: 16px;
        height: 16px;
    }

    /* Forgot password link */
    .auth-form-wrap a {
        color: #6d5efc;
        font-size: .84rem;
        text-decoration: none;
    }

    .auth-form-wrap a:hover { text-decoration: underline; }

    /* Validation status */
    .auth-form-wrap .border-red-500 {
        border-color: #ef4444 !important;
    }

    /*── Responsive ───────────────────────────────────────*/

    @media (max-width: 900px) {
        .auth-wrap { grid-template-columns: 1fr; }
        .auth-left  { display: none; }
        .auth-right {
            padding: 40px 28px;
            min-height: 100vh;
            background: linear-gradient(160deg, #0d0b14 0%, #1a1526 100%);
        }
        .auth-right::before,
        .auth-right::after { display: none; }
        .auth-form-wrap input[type="text"],
        .auth-form-wrap input[type="email"],
        .auth-form-wrap input[type="password"] {
            background: rgba(255,255,255,.07);
            border-color: rgba(255,255,255,.12);
            color: #fff;
        }
        .auth-form-wrap input[type="text"]:focus,
        .auth-form-wrap input[type="email"]:focus,
        .auth-form-wrap input[type="password"]:focus {
            background: rgba(255,255,255,.1);
            border-color: #6d5efc;
        }
        .auth-form-wrap label { color: rgba(255,255,255,.75); }
        .auth-form-header h2 { color: #fff; }
        .auth-form-header p  { color: rgba(255,255,255,.5); }
        .auth-switch  { color: rgba(255,255,255,.5); }
        .auth-trust   { border-top-color: rgba(255,255,255,.08); }
        .trust-item   { color: rgba(255,255,255,.35); }
    }

    @media (max-width: 480px) {
        .auth-right { padding: 32px 20px; }
    }
    </style>
</head>

<body>
<div class="auth-wrap">

    {{-- ══════════════════════════════════════════════
         LEFT — Brand panel
    ════════════════════════════════════════════════ --}}
    <div class="auth-left">

        {{-- Ambient orbs --}}
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>

        {{-- SVG gradient def --}}
        <svg width="0" height="0" style="position:absolute;">
            <defs>
                <linearGradient id="ringGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%"   stop-color="#6d5efc"/>
                    <stop offset="100%" stop-color="#c084fc"/>
                </linearGradient>
            </defs>
        </svg>

        {{-- Brand --}}
        <a href="/" class="brand">
            <div class="brand-icon">
                <i class="bi bi-lightning-charge-fill"></i>
            </div>
            <div>
                <div class="brand-name">Taskvel</div>
                <span class="brand-tagline">कार्य, Done Well</span>
            </div>
        </a>

        {{-- Hero --}}
        <div class="auth-hero">

            <div class="hero-eyebrow">
                Premium Workspace
            </div>

            <h1 class="hero-title">
                Your work,<br>
                <span class="accent">beautifully</span><br>
                organised.
            </h1>

            <p class="hero-sub">
                Plan tasks, run deep-focus sessions, track every remark —
                all in one workspace built for people who ship.
            </p>

            {{-- Focus ring — signature element --}}
            <div class="focus-ring-wrap">
                <div class="focus-ring">
                    <svg viewBox="0 0 90 90" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle class="ring-track" cx="45" cy="45" r="36"/>
                        <circle class="ring-fill"  cx="45" cy="45" r="36"/>
                    </svg>
                    <div class="ring-inner">
                        <div class="ring-time" id="liveTime">--:--</div>
                        <div class="ring-label">Focus</div>
                    </div>
                </div>
                <div class="focus-ring-info">
                    <h6>Built-in Pomodoro timer</h6>
                    <p>Stay in flow with customisable focus<br>sessions and automatic break reminders.</p>
                </div>
            </div>

            {{-- Feature chips --}}
            <div class="feature-chips">
                @php
                    $features = [
                        ['icon'=>'bi-check2-square', 'grad'=>'#6d5efc,#a06dfc', 'bg'=>'rgba(109,94,252,.14)',
                         'title'=>'Smart Task Management',
                         'desc' =>'Urgency × impact matrix, color labels, progress tracking.'],
                        ['icon'=>'bi-stopwatch-fill','grad'=>'#10b981,#34d399', 'bg'=>'rgba(16,185,129,.12)',
                         'title'=>'Deep Work Sessions',
                         'desc' =>'Pomodoro, stopwatch, ambient sounds, idle detection.'],
                        ['icon'=>'bi-bar-chart-fill','grad'=>'#f59e0b,#fbbf24', 'bg'=>'rgba(245,158,11,.12)',
                         'title'=>'Productivity Insights',
                         'desc' =>'Heatmaps, weekly charts, focus streaks and export.'],
                    ];
                @endphp
                @foreach($features as $f)
                <div class="feature-chip">
                    <div class="chip-icon" style="background:{{ $f['bg'] }};color:{{ explode(',',$f['grad'])[0] }};">
                        <i class="bi {{ $f['icon'] }}"></i>
                    </div>
                    <div>
                        <div class="chip-title">{{ $f['title'] }}</div>
                        <div class="chip-desc">{{ $f['desc'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Social proof --}}
            <div class="auth-proof">
                <div class="proof-avatars">
                    @foreach(['#6d5efc','#10b981','#f59e0b','#ef4444','#0ea5e9'] as $c)
                    <div class="proof-avatar" style="background:{{ $c }};">
                        {{ chr(65 + $loop->index) }}
                    </div>
                    @endforeach
                </div>
                <div>
                    <div class="proof-stars">
                        @for($i=0;$i<5;$i++)<i class="bi bi-star-fill"></i>@endfor
                    </div>
                    <div class="proof-text">
                        <strong>2,400+ teams</strong> ship faster with Taskvel
                    </div>
                </div>
            </div>

        </div>

    </div>

    {{-- ══════════════════════════════════════════════
         RIGHT — Form panel
    ════════════════════════════════════════════════ --}}
    <div class="auth-right">

        <div class="auth-form-wrap">

            {{-- Mobile brand (hidden on desktop, left panel shows it) --}}
            <a href="/" class="brand d-block d-md-none mb-8"
               style="display:none;margin-bottom:32px;text-decoration:none;">
                <div style="display:flex;align-items:center;gap:10px;">
                    <div class="brand-icon"><i class="bi bi-lightning-charge-fill"></i></div>
                    <span class="brand-name" style="color:#fff;">Taskvel</span>
                </div>
            </a>

            {{-- Slot: login/register form content --}}
            {{ $slot }}

            {{-- Trust strip --}}
            <div class="auth-trust">
                <div class="trust-item">
                    <i class="bi bi-shield-lock-fill"></i>
                    SSL encrypted
                </div>
                <div class="trust-item">
                    <i class="bi bi-eye-slash-fill"></i>
                    No data sharing
                </div>
                <div class="trust-item">
                    <i class="bi bi-arrow-repeat"></i>
                    Cancel anytime
                </div>
            </div>

        </div>

    </div>

</div>

<script>
    // Live clock in the focus ring
    function updateClock() {
        const now  = new Date();
        const h    = String(now.getHours()).padStart(2,'0');
        const m    = String(now.getMinutes()).padStart(2,'0');
        const el   = document.getElementById('liveTime');
        if (el) el.textContent = h + ':' + m;
    }
    updateClock();
    setInterval(updateClock, 1000);
</script>

</body>
</html>