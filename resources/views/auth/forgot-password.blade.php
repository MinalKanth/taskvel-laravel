<x-guest-layout>

<style>
/*══════════════════════════════════════════
  FORGOT PASSWORD — Premium
══════════════════════════════════════════*/

.fp-wrap { }

/* ── Animated icon ── */
.fp-icon-wrap {
    display: flex;
    justify-content: center;
    margin-bottom: 28px;
}

.fp-icon {
    width: 72px; height: 72px;
    border-radius: 22px;
    background: linear-gradient(135deg, #6d5efc, #a06dfc);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.8rem; color: #fff;
    box-shadow: 0 12px 32px rgba(109,94,252,.4);
    position: relative;
    animation: iconFloat 3s ease-in-out infinite;
}

@keyframes iconFloat {
    0%,100% { transform: translateY(0);  box-shadow: 0 12px 32px rgba(109,94,252,.4); }
    50%      { transform: translateY(-6px); box-shadow: 0 20px 40px rgba(109,94,252,.32); }
}

/* Pulse rings */
.fp-icon::before,
.fp-icon::after {
    content: '';
    position: absolute;
    inset: -8px;
    border-radius: 30px;
    border: 2px solid rgba(109,94,252,.18);
    animation: ringExpand 2.4s ease-out infinite;
}
.fp-icon::after {
    inset: -16px;
    border-radius: 38px;
    animation-delay: .6s;
    border-color: rgba(109,94,252,.1);
}

@keyframes ringExpand {
    0%   { opacity: 1; transform: scale(1); }
    100% { opacity: 0; transform: scale(1.15); }
}

/* ── Header ── */
.fp-header { text-align: center; margin-bottom: 28px; }

.fp-logo-mobile {
    display: none;
    width: 46px; height: 46px;
    border-radius: 13px;
    background: linear-gradient(135deg, #6d5efc, #a06dfc);
    align-items: center; justify-content: center;
    font-size: 1.3rem; color: #fff;
    margin: 0 auto 20px;
    box-shadow: 0 8px 24px rgba(109,94,252,.4);
}

.fp-title {
    font-family: 'Sora', sans-serif;
    font-weight: 800;
    font-size: 1.85rem;
    letter-spacing: -.04em;
    color: #1a1528;
    margin-bottom: 10px;
    line-height: 1.1;
}

.fp-desc {
    font-size: .88rem;
    color: #8a8a9a;
    line-height: 1.65;
    max-width: 340px;
    margin: 0 auto;
}

/* ── How it works strip ── */
.fp-steps {
    display: flex;
    gap: 0;
    margin: 28px 0;
    background: rgba(109,94,252,.04);
    border: 1px solid rgba(109,94,252,.1);
    border-radius: 14px;
    overflow: hidden;
}

.fp-step-item {
    flex: 1;
    padding: 14px 10px;
    text-align: center;
    position: relative;
}

.fp-step-item + .fp-step-item::before {
    content: '';
    position: absolute;
    left: 0; top: 20%; bottom: 20%;
    width: 1px;
    background: rgba(109,94,252,.15);
}

.fp-step-num {
    width: 24px; height: 24px;
    border-radius: 50%;
    background: linear-gradient(135deg, #6d5efc, #a06dfc);
    color: #fff;
    font-size: .68rem;
    font-weight: 800;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 6px;
}

.fp-step-text {
    font-size: .72rem;
    color: #6b6b7a;
    font-weight: 500;
    line-height: 1.3;
}

/* ── Status alert ── */
.fp-status {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 16px;
    border-radius: 14px;
    background: linear-gradient(135deg, rgba(16,185,129,.08), rgba(16,185,129,.04));
    border: 1px solid rgba(16,185,129,.2);
    margin-bottom: 24px;
    animation: slideDown .3s ease;
}

@keyframes slideDown {
    from { opacity: 0; transform: translateY(-8px); }
    to   { opacity: 1; transform: translateY(0); }
}

.fp-status-icon {
    width: 36px; height: 36px;
    border-radius: 10px;
    background: rgba(16,185,129,.15);
    display: flex; align-items: center; justify-content: center;
    color: #059669;
    font-size: 1rem;
    flex-shrink: 0;
}

.fp-status-body { flex: 1; }

.fp-status-title {
    font-size: .85rem;
    font-weight: 700;
    color: #059669;
    margin-bottom: 2px;
}

.fp-status-msg {
    font-size: .78rem;
    color: #065f46;
    line-height: 1.5;
}

/* ── Field ── */
.fp-field { margin-bottom: 20px; }

.fp-label {
    display: block;
    font-size: .8rem;
    font-weight: 700;
    color: #3a3a4a;
    margin-bottom: 7px;
    letter-spacing: .01em;
}

.fp-input-wrap {
    position: relative;
    display: flex;
    align-items: center;
}

.fp-input-icon {
    position: absolute;
    left: 15px;
    color: #b0aac8;
    font-size: .95rem;
    pointer-events: none;
    transition: color .2s;
}

.fp-input-wrap:focus-within .fp-input-icon { color: #6d5efc; }

.fp-input {
    width: 100%;
    padding: 13px 16px 13px 42px;
    border: 1.5px solid #e8e4f8;
    border-radius: 13px;
    font-size: .9rem;
    font-family: 'Inter', sans-serif;
    color: #1a1528;
    background: #fdfcff;
    transition: border-color .2s, box-shadow .2s, background .2s;
    outline: none;
    appearance: none;
}

.fp-input:focus {
    border-color: #6d5efc;
    box-shadow: 0 0 0 4px rgba(109,94,252,.1);
    background: #fff;
}

.fp-input.is-invalid {
    border-color: #ef4444;
    background: #fff5f5;
}
.fp-input.is-invalid:focus {
    box-shadow: 0 0 0 4px rgba(239,68,68,.1);
}

.fp-error {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-top: 6px;
    font-size: .76rem;
    color: #ef4444;
    font-weight: 500;
}

/* ── Button ── */
.fp-btn {
    width: 100%;
    padding: 14px;
    border: none;
    border-radius: 13px;
    background: linear-gradient(135deg, #6d5efc 0%, #9d5efc 50%, #a06dfc 100%);
    color: #fff;
    font-size: .95rem;
    font-weight: 700;
    font-family: 'Inter', sans-serif;
    cursor: pointer;
    box-shadow: 0 10px 28px rgba(109,94,252,.38), 0 2px 8px rgba(109,94,252,.2);
    transition: all .22s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    position: relative;
    overflow: hidden;
}

.fp-btn::after {
    content: '';
    position: absolute;
    top: 0; left: -100%;
    width: 60%; height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,.18), transparent);
    transform: skewX(-15deg);
    transition: left .5s ease;
}
.fp-btn:hover::after { left: 150%; }
.fp-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 16px 38px rgba(109,94,252,.48);
}
.fp-btn:active { transform: translateY(0); }

/* Loading state */
.fp-btn.loading {
    pointer-events: none;
    opacity: .85;
}

.fp-spinner {
    display: none;
    width: 16px; height: 16px;
    border: 2px solid rgba(255,255,255,.3);
    border-top-color: #fff;
    border-radius: 50%;
    animation: spin .7s linear infinite;
}

.fp-btn.loading .fp-spinner    { display: block; }
.fp-btn.loading .fp-btn-icon   { display: none; }

@keyframes spin { to { transform: rotate(360deg); } }

/* ── Back link ── */
.fp-back {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    margin-top: 24px;
    font-size: .84rem;
    color: #9090a8;
    text-decoration: none;
    transition: color .2s;
}

.fp-back:hover { color: #6d5efc; }
.fp-back i { font-size: .8rem; transition: transform .2s; }
.fp-back:hover i { transform: translateX(-3px); }

/* ── Security note ── */
.fp-security {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid #f0eeff;
    font-size: .72rem;
    color: #b0b0c8;
    font-weight: 500;
}

.fp-security i { color: #10b981; font-size: .8rem; }

/* ── Dark mobile ── */
@media (max-width: 900px) {
    .fp-logo-mobile { display: flex; }
    .fp-title   { color: #fff; }
    .fp-desc    { color: rgba(255,255,255,.5); }
    .fp-label   { color: rgba(255,255,255,.75); }
    .fp-steps   { background: rgba(255,255,255,.05); border-color: rgba(255,255,255,.1); }
    .fp-step-text { color: rgba(255,255,255,.45); }
    .fp-step-item + .fp-step-item::before { background: rgba(255,255,255,.1); }
    .fp-input   {
        background: rgba(255,255,255,.07);
        border-color: rgba(255,255,255,.12);
        color: #fff;
    }
    .fp-input::placeholder { color: rgba(255,255,255,.3); }
    .fp-input:focus {
        background: rgba(255,255,255,.1);
        border-color: #6d5efc;
    }
    .fp-input-icon { color: rgba(255,255,255,.3); }
    .fp-back    { color: rgba(255,255,255,.4); }
    .fp-back:hover { color: #a78bfa; }
    .fp-security { border-top-color: rgba(255,255,255,.08); color: rgba(255,255,255,.25); }
}
</style>

<div class="fp-wrap">

    {{-- ── Floating icon ──────────────────────────────────── --}}
    <div class="fp-icon-wrap">
        <div class="fp-icon">
            <i class="bi bi-shield-lock-fill"></i>
        </div>
    </div>

    {{-- ── Header ───────────────────────────────────────────── --}}
    <div class="fp-header">
        <div class="fp-logo-mobile">
            <i class="bi bi-lightning-charge-fill"></i>
        </div>
        <h2 class="fp-title">Reset your password</h2>
        <p class="fp-desc">
            Enter the email you signed up with and we'll send
            a secure reset link straight to your inbox.
        </p>
    </div>

    {{-- ── How it works ─────────────────────────────────────── --}}
    <div class="fp-steps">
        <div class="fp-step-item">
            <div class="fp-step-num">1</div>
            <div class="fp-step-text">Enter your email</div>
        </div>
        <div class="fp-step-item">
            <div class="fp-step-num">2</div>
            <div class="fp-step-text">Check your inbox</div>
        </div>
        <div class="fp-step-item">
            <div class="fp-step-num">3</div>
            <div class="fp-step-text">Set new password</div>
        </div>
    </div>

    {{-- ── Status ────────────────────────────────────────────── --}}
    @if(session('status'))
        <div class="fp-status">
            <div class="fp-status-icon">
                <i class="bi bi-envelope-check-fill"></i>
            </div>
            <div class="fp-status-body">
                <div class="fp-status-title">Reset link sent!</div>
                <div class="fp-status-msg">{{ session('status') }}</div>
            </div>
        </div>
    @endif

    {{-- ── Form ─────────────────────────────────────────────── --}}
    <form method="POST" action="{{ route('password.email') }}" id="fpForm" novalidate>
        @csrf

        <div class="fp-field">
            <label class="fp-label" for="email">Email address</label>
            <div class="fp-input-wrap">
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    placeholder="you@company.com"
                    class="fp-input {{ $errors->has('email') ? 'is-invalid' : '' }}">
                <i class="bi bi-envelope fp-input-icon"></i>
            </div>
            @error('email')
                <div class="fp-error">
                    <i class="bi bi-exclamation-circle-fill"></i>{{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="fp-btn" id="fpBtn">
            <div class="fp-spinner"></div>
            <i class="bi bi-send-fill fp-btn-icon"></i>
            Send reset link
        </button>

    </form>

    {{-- ── Back to login ────────────────────────────────────── --}}
    <a href="{{ route('login') }}" class="fp-back">
        <i class="bi bi-arrow-left"></i>
        Back to sign in
    </a>

    {{-- ── Security note ────────────────────────────────────── --}}
    <div class="fp-security">
        <i class="bi bi-shield-check-fill"></i>
        Reset links expire in 60 minutes and can only be used once.
    </div>

</div>

<script>
// Button loading state on submit
document.getElementById('fpForm')?.addEventListener('submit', function () {
    const btn = document.getElementById('fpBtn');
    if (btn) btn.classList.add('loading');
});

// Focus colour on icon
document.querySelectorAll('.fp-input').forEach(function (inp) {
    inp.addEventListener('focus', function () {
        this.closest('.fp-field')?.classList.add('focused');
    });
    inp.addEventListener('blur', function () {
        this.closest('.fp-field')?.classList.remove('focused');
    });
});
</script>

</x-guest-layout>