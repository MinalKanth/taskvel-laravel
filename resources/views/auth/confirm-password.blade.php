<x-guest-layout>

<style>
/*══════════════════════════════════════════
  CONFIRM PASSWORD FORM — Premium
══════════════════════════════════════════*/

.lf-header { text-align: center; margin-bottom: 36px; }

.lf-logo-mobile {
    display: none;
    width: 46px; height: 46px;
    border-radius: 13px;
    background: linear-gradient(135deg, #6d5efc, #a06dfc);
    align-items: center; justify-content: center;
    font-size: 1.3rem; color: #fff;
    margin: 0 auto 20px;
    box-shadow: 0 8px 24px rgba(109,94,252,.4);
}

.lf-icon-badge {
    width: 56px; height: 56px;
    margin: 0 auto 20px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: #fff;
    background: linear-gradient(135deg, #6d5efc, #a06dfc);
    box-shadow: 0 10px 28px rgba(109,94,252,.38);
}

.lf-title {
    font-family: 'Sora', sans-serif;
    font-weight: 800;
    font-size: 1.9rem;
    letter-spacing: -.04em;
    color: #1a1528;
    margin-bottom: 8px;
    line-height: 1.1;
}

.lf-subtitle {
    font-size: .88rem;
    color: #8a8a9a;
    line-height: 1.5;
    max-width: 340px;
    margin: 0 auto;
}

.lf-subtitle a {
    color: #6d5efc;
    font-weight: 600;
    text-decoration: none;
}
.lf-subtitle a:hover { text-decoration: underline; }

/* ── Status alert ── */
.lf-status {
    padding: 12px 16px;
    border-radius: 12px;
    background: rgba(16,185,129,.1);
    border: 1px solid rgba(16,185,129,.2);
    color: #059669;
    font-size: .84rem;
    font-weight: 500;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 8px;
}

/* ── Field group ── */
.lf-field { margin-bottom: 20px; }

.lf-label {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: .8rem;
    font-weight: 700;
    color: #3a3a4a;
    margin-bottom: 8px;
    letter-spacing: .01em;
}

.lf-label a {
    font-weight: 600;
    font-size: .78rem;
    color: #6d5efc;
    text-decoration: none;
}
.lf-label a:hover { text-decoration: underline; }

.lf-input-wrap {
    position: relative;
    display: flex;
    align-items: center;
}

.lf-input-icon {
    position: absolute;
    left: 15px;
    color: #b0aac8;
    font-size: .95rem;
    pointer-events: none;
    transition: color .2s;
}

.lf-input {
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

.lf-input:focus {
    border-color: #6d5efc;
    box-shadow: 0 0 0 4px rgba(109,94,252,.1);
    background: #fff;
}

.lf-input:focus + .lf-input-icon,
.lf-input-wrap:focus-within .lf-input-icon {
    color: #6d5efc;
}

/* Password toggle */
.lf-pw-toggle {
    position: absolute;
    right: 14px;
    background: none;
    border: none;
    color: #b0aac8;
    font-size: .95rem;
    cursor: pointer;
    padding: 4px;
    line-height: 1;
    transition: color .2s;
}
.lf-pw-toggle:hover { color: #6d5efc; }

/* Error */
.lf-error {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-top: 6px;
    font-size: .76rem;
    color: #ef4444;
    font-weight: 500;
}
.lf-error i { font-size: .75rem; }

/* Invalid state */
.lf-input.is-invalid {
    border-color: #ef4444;
    background: #fff5f5;
}
.lf-input.is-invalid:focus {
    box-shadow: 0 0 0 4px rgba(239,68,68,.1);
}

/* ── Submit button ── */
.lf-btn {
    width: 100%;
    padding: 14px;
    border: none;
    border-radius: 13px;
    background: linear-gradient(135deg, #6d5efc 0%, #9d5efc 50%, #a06dfc 100%);
    color: #fff;
    font-size: .95rem;
    font-weight: 700;
    font-family: 'Inter', sans-serif;
    letter-spacing: .01em;
    cursor: pointer;
    box-shadow: 0 10px 28px rgba(109,94,252,.38), 0 2px 8px rgba(109,94,252,.2);
    transition: all .22s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    position: relative;
    overflow: hidden;
    margin-top: 4px;
}

/* Shimmer sweep */
.lf-btn::after {
    content: '';
    position: absolute;
    top: 0; left: -100%;
    width: 60%; height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,.18), transparent);
    transform: skewX(-15deg);
    transition: left .5s ease;
}
.lf-btn:hover::after { left: 150%; }
.lf-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 16px 38px rgba(109,94,252,.48), 0 4px 12px rgba(109,94,252,.25);
}
.lf-btn:active { transform: translateY(0); }

/* ── Security note ── */
.lf-secure-note {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding: 14px 16px;
    border-radius: 12px;
    background: rgba(109,94,252,.05);
    border: 1px solid rgba(109,94,252,.12);
    margin-bottom: 24px;
}
.lf-secure-note i {
    color: #6d5efc;
    font-size: 1rem;
    margin-top: 1px;
    flex-shrink: 0;
}
.lf-secure-note p {
    font-size: .8rem;
    color: #6b6b7a;
    line-height: 1.5;
    margin: 0;
}

/* ── Back link ── */
.lf-register {
    text-align: center;
    margin-top: 24px;
    font-size: .84rem;
    color: #9090a8;
}
.lf-register a {
    color: #6d5efc;
    font-weight: 700;
    text-decoration: none;
    margin-left: 4px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}
.lf-register a:hover { text-decoration: underline; }

/* ── Dark mode (right panel goes dark on mobile) ── */
@media (max-width: 900px) {
    .lf-logo-mobile { display: flex; }
    .lf-title  { color: #fff; }
    .lf-subtitle { color: rgba(255,255,255,.5); }
    .lf-label  { color: rgba(255,255,255,.75); }
    .lf-input  {
        background: rgba(255,255,255,.07);
        border-color: rgba(255,255,255,.12);
        color: #fff;
    }
    .lf-input::placeholder { color: rgba(255,255,255,.3); }
    .lf-input:focus {
        background: rgba(255,255,255,.1);
        border-color: #6d5efc;
    }
    .lf-input-icon { color: rgba(255,255,255,.3); }
    .lf-secure-note {
        background: rgba(255,255,255,.06);
        border-color: rgba(255,255,255,.1);
    }
    .lf-secure-note p { color: rgba(255,255,255,.55); }
    .lf-register { color: rgba(255,255,255,.4); }
}
</style>

{{-- ── Session status ──────────────────────────────────── --}}
@if(session('status'))
    <div class="lf-status">
        <i class="bi bi-check-circle-fill"></i>
        {{ session('status') }}
    </div>
@endif

{{-- ── Header ───────────────────────────────────────────── --}}
<div class="lf-header">
    <div class="lf-icon-badge">
        <i class="bi bi-shield-lock-fill"></i>
    </div>
    <h2 class="lf-title">Confirm your password</h2>
    <p class="lf-subtitle">
        This is a secure area of the application. Please confirm your password before continuing.
    </p>
</div>

{{-- ── Security note ────────────────────────────────────── --}}
<div class="lf-secure-note">
    <i class="bi bi-info-circle-fill"></i>
    <p>For your security, we occasionally ask you to re-enter your password before accessing sensitive settings.</p>
</div>

{{-- ── Form ─────────────────────────────────────────────── --}}
<form method="POST" action="{{ route('password.confirm') }}" novalidate>
    @csrf

    {{-- Password --}}
    <div class="lf-field">
        <div class="lf-label">
            <span>Password</span>
        </div>
        <div class="lf-input-wrap">
            <input
                id="password"
                type="password"
                name="password"
                required
                autofocus
                autocomplete="current-password"
                placeholder="••••••••"
                class="lf-input {{ $errors->has('password') ? 'is-invalid' : '' }}">
            <i class="bi bi-lock lf-input-icon"></i>
            <button type="button" class="lf-pw-toggle" id="pwToggle" tabindex="-1" aria-label="Show password">
                <i class="bi bi-eye" id="pwIcon"></i>
            </button>
        </div>
        @error('password')
            <div class="lf-error"><i class="bi bi-exclamation-circle-fill"></i>{{ $message }}</div>
        @enderror
    </div>

    {{-- Submit --}}
    <button type="submit" class="lf-btn">
        <i class="bi bi-shield-check"></i>
        Confirm password
    </button>

</form>

{{-- ── Back link ────────────────────────────────────────── --}}
<div class="lf-register">
    <a href="{{ route('dashboard') }}">
        <i class="bi bi-arrow-left"></i>
        Back to dashboard
    </a>
</div>

<script>
// Password show/hide toggle
const pwToggle = document.getElementById('pwToggle');
const pwField  = document.getElementById('password');
const pwIcon   = document.getElementById('pwIcon');

if (pwToggle && pwField) {
    pwToggle.addEventListener('click', function () {
        const isText = pwField.type === 'text';
        pwField.type = isText ? 'password' : 'text';
        pwIcon.className = isText ? 'bi bi-eye' : 'bi bi-eye-slash';
    });
}

// Input focus — icon colour via CSS :focus-within, but
// also add/remove a class so label can react
document.querySelectorAll('.lf-input').forEach(function (input) {
    input.addEventListener('focus', function () {
        this.closest('.lf-field')?.classList.add('focused');
    });
    input.addEventListener('blur', function () {
        this.closest('.lf-field')?.classList.remove('focused');
    });
});
</script>

</x-guest-layout>