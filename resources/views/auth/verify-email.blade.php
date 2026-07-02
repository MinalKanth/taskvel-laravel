<x-guest-layout>

<style>
/*══════════════════════════════════════════
  VERIFY EMAIL — Premium
══════════════════════════════════════════*/

.vf-header { text-align: center; margin-bottom: 32px; }

.vf-icon-wrap {
    width: 64px; height: 64px;
    border-radius: 18px;
    background: linear-gradient(135deg, #6d5efc, #a06dfc);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.7rem; color: #fff;
    margin: 0 auto 22px;
    box-shadow: 0 10px 28px rgba(109,94,252,.38), 0 2px 8px rgba(109,94,252,.2);
}

.vf-title {
    font-family: 'Sora', sans-serif;
    font-weight: 800;
    font-size: 1.6rem;
    letter-spacing: -.03em;
    color: #1a1528;
    margin-bottom: 12px;
    line-height: 1.15;
}

.vf-subtitle {
    font-size: .88rem;
    color: #8a8a9a;
    line-height: 1.6;
    max-width: 380px;
    margin: 0 auto;
}

/* ── Status alert ── */
.vf-status {
    padding: 12px 16px;
    border-radius: 12px;
    background: rgba(16,185,129,.1);
    border: 1px solid rgba(16,185,129,.2);
    color: #059669;
    font-size: .84rem;
    font-weight: 500;
    margin: 24px 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

/* ── Divider ── */
.vf-divider {
    display: flex;
    align-items: center;
    gap: 14px;
    margin: 28px 0;
    font-size: .76rem;
    color: #c8c4e4;
    font-weight: 600;
    letter-spacing: .04em;
}
.vf-divider::before,
.vf-divider::after {
    content: '';
    flex: 1;
    height: 1px;
    background: linear-gradient(90deg, transparent, #e8e4f8, transparent);
}

/* ── Actions row ── */
.vf-actions {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
}

/* ── Resend button (primary) ── */
.vf-btn {
    padding: 13px 22px;
    border: none;
    border-radius: 13px;
    background: linear-gradient(135deg, #6d5efc 0%, #9d5efc 50%, #a06dfc 100%);
    color: #fff;
    font-size: .88rem;
    font-weight: 700;
    font-family: 'Inter', sans-serif;
    letter-spacing: .01em;
    cursor: pointer;
    box-shadow: 0 10px 28px rgba(109,94,252,.38), 0 2px 8px rgba(109,94,252,.2);
    transition: all .22s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    position: relative;
    overflow: hidden;
}

.vf-btn::after {
    content: '';
    position: absolute;
    top: 0; left: -100%;
    width: 60%; height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,.18), transparent);
    transform: skewX(-15deg);
    transition: left .5s ease;
}
.vf-btn:hover::after { left: 150%; }
.vf-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 16px 38px rgba(109,94,252,.48), 0 4px 12px rgba(109,94,252,.25);
}
.vf-btn:active { transform: translateY(0); }

/* ── Logout link ── */
.vf-logout {
    background: none;
    border: none;
    font-size: .82rem;
    font-weight: 600;
    color: #9090a8;
    text-decoration: underline;
    cursor: pointer;
    padding: 4px;
    font-family: 'Inter', sans-serif;
    transition: color .18s ease;
    border-radius: 8px;
}
.vf-logout:hover { color: #6d5efc; }
.vf-logout:focus {
    outline: none;
    box-shadow: 0 0 0 4px rgba(109,94,252,.12);
}

/* ── Dark mode (right panel goes dark on mobile) ── */
@media (max-width: 900px) {
    .vf-title    { color: #fff; }
    .vf-subtitle { color: rgba(255,255,255,.5); }
    .vf-divider  { color: rgba(255,255,255,.2); }
    .vf-divider::before, .vf-divider::after { background: rgba(255,255,255,.1); }
    .vf-logout   { color: rgba(255,255,255,.45); }
    .vf-logout:hover { color: #fff; }
}

@media (max-width: 480px) {
    .vf-actions { flex-direction: column-reverse; align-items: stretch; }
    .vf-btn { width: 100%; }
    .vf-logout { text-align: center; }
}
</style>

{{-- ── Header ───────────────────────────────────────────── --}}
<div class="vf-header">
    <div class="vf-icon-wrap">
        <i class="bi bi-envelope-check-fill"></i>
    </div>
    <h2 class="vf-title">Verify your email</h2>
    <p class="vf-subtitle">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </p>
</div>

{{-- ── Status ───────────────────────────────────────────── --}}
@if (session('status') == 'verification-link-sent')
    <div class="vf-status">
        <i class="bi bi-check-circle-fill"></i>
        {{ __('A new verification link has been sent to the email address you provided during registration.') }}
    </div>
@endif

<div class="vf-divider">what would you like to do?</div>

{{-- ── Actions ──────────────────────────────────────────── --}}
<div class="vf-actions">
    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="vf-btn">
            <i class="bi bi-arrow-repeat"></i>
            {{ __('Resend Verification Email') }}
        </button>
    </form>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="vf-logout">
            {{ __('Log Out') }}
        </button>
    </form>
</div>

</x-guest-layout>