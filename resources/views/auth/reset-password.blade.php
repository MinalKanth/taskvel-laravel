<x-guest-layout>

<style>
/*══════════════════════════════════════════
  RESET PASSWORD FORM — Premium
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

.lf-input:read-only,
.lf-input:disabled {
    background: #f4f2fb;
    color: #9494a8;
    cursor: not-allowed;
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

/* Match state (confirm password) */
.lf-input.is-valid {
    border-color: #10b981;
    background: #f0fdf9;
}
.lf-input.is-valid:focus {
    box-shadow: 0 0 0 4px rgba(16,185,129,.1);
}

/* ── Password strength meter ── */
.lf-strength {
    display: flex;
    gap: 4px;
    margin-top: 10px;
}
.lf-strength-bar {
    flex: 1;
    height: 4px;
    border-radius: 3px;
    background: #ece9fa;
    transition: background .25s ease;
}
.lf-strength-label {
    font-size: .74rem;
    font-weight: 600;
    margin-top: 6px;
    color: #b0aac8;
    transition: color .25s ease;
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
    .lf-input:read-only,
    .lf-input:disabled {
        background: rgba(255,255,255,.04);
        color: rgba(255,255,255,.35);
    }
    .lf-input-icon { color: rgba(255,255,255,.3); }
    .lf-strength-bar { background: rgba(255,255,255,.1); }
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
        <i class="bi bi-key-fill"></i>
    </div>
    <h2 class="lf-title">Reset your password</h2>
    <p class="lf-subtitle">
        Choose a new password below. Make it strong — at least 8 characters with a mix of letters and numbers.
    </p>
</div>

{{-- ── Form ─────────────────────────────────────────────── --}}
<form method="POST" action="{{ route('password.store') }}" novalidate>
    @csrf

    <!-- Password Reset Token -->
    <input type="hidden" name="token" value="{{ $request->route('token') }}">

    {{-- Email --}}
    <div class="lf-field">
        <div class="lf-label">
            <span>Email address</span>
        </div>
        <div class="lf-input-wrap">
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email', $request->email) }}"
                required
                autofocus
                autocomplete="username"
                placeholder="you@company.com"
                class="lf-input {{ $errors->has('email') ? 'is-invalid' : '' }}">
            <i class="bi bi-envelope lf-input-icon"></i>
        </div>
        @error('email')
            <div class="lf-error"><i class="bi bi-exclamation-circle-fill"></i>{{ $message }}</div>
        @enderror
    </div>

    {{-- New Password --}}
    <div class="lf-field">
        <div class="lf-label">
            <span>New password</span>
        </div>
        <div class="lf-input-wrap">
            <input
                id="password"
                type="password"
                name="password"
                required
                autocomplete="new-password"
                placeholder="••••••••"
                class="lf-input {{ $errors->has('password') ? 'is-invalid' : '' }}">
            <i class="bi bi-lock lf-input-icon"></i>
            <button type="button" class="lf-pw-toggle" id="pwToggle" tabindex="-1" aria-label="Show password">
                <i class="bi bi-eye" id="pwIcon"></i>
            </button>
        </div>
        <div class="lf-strength" id="strengthMeter">
            <div class="lf-strength-bar" data-bar="1"></div>
            <div class="lf-strength-bar" data-bar="2"></div>
            <div class="lf-strength-bar" data-bar="3"></div>
            <div class="lf-strength-bar" data-bar="4"></div>
        </div>
        <div class="lf-strength-label" id="strengthLabel">Enter a password</div>
        @error('password')
            <div class="lf-error"><i class="bi bi-exclamation-circle-fill"></i>{{ $message }}</div>
        @enderror
    </div>

    {{-- Confirm Password --}}
    <div class="lf-field">
        <div class="lf-label">
            <span>Confirm new password</span>
        </div>
        <div class="lf-input-wrap">
            <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
                placeholder="••••••••"
                class="lf-input {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}">
            <i class="bi bi-lock lf-input-icon"></i>
            <button type="button" class="lf-pw-toggle" id="pwConfirmToggle" tabindex="-1" aria-label="Show password">
                <i class="bi bi-eye" id="pwConfirmIcon"></i>
            </button>
        </div>
        <div class="lf-error" id="matchError" style="display:none;">
            <i class="bi bi-exclamation-circle-fill"></i>Passwords do not match
        </div>
        @error('password_confirmation')
            <div class="lf-error"><i class="bi bi-exclamation-circle-fill"></i>{{ $message }}</div>
        @enderror
    </div>

    {{-- Submit --}}
    <button type="submit" class="lf-btn">
        <i class="bi bi-shield-check"></i>
        Reset password
    </button>

</form>

{{-- ── Back link ────────────────────────────────────────── --}}
<div class="lf-register">
    <a href="{{ route('login') }}">
        <i class="bi bi-arrow-left"></i>
        Back to sign in
    </a>
</div>

<script>
// Password show/hide toggles
function bindToggle(toggleId, fieldId, iconId) {
    const toggle = document.getElementById(toggleId);
    const field  = document.getElementById(fieldId);
    const icon   = document.getElementById(iconId);
    if (!toggle || !field) return;
    toggle.addEventListener('click', function () {
        const isText = field.type === 'text';
        field.type = isText ? 'password' : 'text';
        icon.className = isText ? 'bi bi-eye' : 'bi bi-eye-slash';
    });
}
bindToggle('pwToggle', 'password', 'pwIcon');
bindToggle('pwConfirmToggle', 'password_confirmation', 'pwConfirmIcon');

// Input focus states
document.querySelectorAll('.lf-input').forEach(function (input) {
    input.addEventListener('focus', function () {
        this.closest('.lf-field')?.classList.add('focused');
    });
    input.addEventListener('blur', function () {
        this.closest('.lf-field')?.classList.remove('focused');
    });
});

// Password strength meter
const pwField = document.getElementById('password');
const bars = document.querySelectorAll('#strengthMeter .lf-strength-bar');
const strengthLabel = document.getElementById('strengthLabel');

const strengthColors = ['#ef4444', '#f59e0b', '#3b82f6', '#10b981'];
const strengthText = ['Weak', 'Fair', 'Good', 'Strong'];

function scorePassword(pw) {
    let score = 0;
    if (!pw) return 0;
    if (pw.length >= 8) score++;
    if (pw.length >= 12) score++;
    if (/[A-Z]/.test(pw) && /[a-z]/.test(pw)) score++;
    if (/\d/.test(pw) && /[^A-Za-z0-9]/.test(pw)) score++;
    return Math.min(score, 4);
}

pwField?.addEventListener('input', function () {
    const score = scorePassword(this.value);

    bars.forEach(function (bar, i) {
        bar.style.background = (i < score && score > 0) ? strengthColors[score - 1] : '';
    });

    strengthLabel.textContent = this.value
        ? (score > 0 ? strengthText[score - 1] : 'Too short')
        : 'Enter a password';
    strengthLabel.style.color = score > 0 ? strengthColors[score - 1] : '#b0aac8';

    checkMatch();
});

// Live confirm-password match check
const confirmField = document.getElementById('password_confirmation');
const matchError = document.getElementById('matchError');

function checkMatch() {
    if (!confirmField.value) {
        confirmField.classList.remove('is-valid', 'is-invalid');
        matchError.style.display = 'none';
        return;
    }
    const matches = confirmField.value === pwField.value;
    confirmField.classList.toggle('is-valid', matches);
    confirmField.classList.toggle('is-invalid', !matches);
    matchError.style.display = matches ? 'none' : 'flex';
}

confirmField?.addEventListener('input', checkMatch);
</script>

</x-guest-layout>