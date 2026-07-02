<x-guest-layout>

<style>
/*══════════════════════════════════════════
  REGISTER FORM — Premium (matches login)
══════════════════════════════════════════*/

.rf-header { text-align: center; margin-bottom: 32px; }

.rf-logo-mobile {
    display: none;
    width: 46px; height: 46px;
    border-radius: 13px;
    background: linear-gradient(135deg, #6d5efc, #a06dfc);
    align-items: center; justify-content: center;
    font-size: 1.3rem; color: #fff;
    margin: 0 auto 20px;
    box-shadow: 0 8px 24px rgba(109,94,252,.4);
}

.rf-title {
    font-family: 'Sora', sans-serif;
    font-weight: 800;
    font-size: 1.9rem;
    letter-spacing: -.04em;
    color: #1a1528;
    margin-bottom: 8px;
    line-height: 1.1;
}

.rf-subtitle {
    font-size: .88rem;
    color: #8a8a9a;
    line-height: 1.5;
}

.rf-subtitle a {
    color: #6d5efc;
    font-weight: 600;
    text-decoration: none;
}
.rf-subtitle a:hover { text-decoration: underline; }

/* ── Steps indicator ── */
.rf-steps {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0;
    margin-bottom: 32px;
}

.rf-step {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
    position: relative;
}

.rf-step-dot {
    width: 32px; height: 32px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: .75rem; font-weight: 800;
    border: 2px solid #e8e4f8;
    background: #fff;
    color: #c4bce8;
    transition: all .3s ease;
    position: relative; z-index: 1;
}

.rf-step.active .rf-step-dot {
    background: linear-gradient(135deg, #6d5efc, #a06dfc);
    border-color: transparent;
    color: #fff;
    box-shadow: 0 4px 14px rgba(109,94,252,.4);
}

.rf-step.done .rf-step-dot {
    background: #10b981;
    border-color: transparent;
    color: #fff;
}

.rf-step-line {
    width: 64px; height: 2px;
    background: #e8e4f8;
    margin: 0 -1px;
    margin-bottom: 20px;
}

.rf-step.done + .rf-step .rf-step-line,
.rf-step-line.done {
    background: linear-gradient(90deg, #10b981, #6d5efc);
}

.rf-step-label {
    font-size: .65rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .06em;
    color: #c4bce8;
    position: absolute;
    top: 38px;
    white-space: nowrap;
}

.rf-step.active .rf-step-label { color: #6d5efc; }
.rf-step.done .rf-step-label   { color: #10b981; }

/* ── Field group ── */
.rf-field { margin-bottom: 18px; }

.rf-label {
    display: block;
    font-size: .8rem;
    font-weight: 700;
    color: #3a3a4a;
    margin-bottom: 7px;
    letter-spacing: .01em;
}

.rf-input-wrap {
    position: relative;
    display: flex;
    align-items: center;
}

.rf-input-icon {
    position: absolute;
    left: 15px;
    color: #b0aac8;
    font-size: .95rem;
    pointer-events: none;
    transition: color .2s;
    z-index: 1;
}

.rf-input-wrap:focus-within .rf-input-icon { color: #6d5efc; }

.rf-input {
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

.rf-input:focus {
    border-color: #6d5efc;
    box-shadow: 0 0 0 4px rgba(109,94,252,.1);
    background: #fff;
}

/* Strength bar (password) */
.rf-pw-wrap { position: relative; }

.rf-pw-toggle {
    position: absolute;
    right: 14px;
    top: 50%; transform: translateY(-50%);
    background: none; border: none;
    color: #b0aac8; font-size: .95rem;
    cursor: pointer; padding: 4px; line-height: 1;
    transition: color .2s; z-index: 1;
}
.rf-pw-toggle:hover { color: #6d5efc; }

.rf-strength-bar {
    display: flex;
    gap: 4px;
    margin-top: 8px;
    height: 4px;
}

.rf-strength-seg {
    flex: 1;
    border-radius: 20px;
    background: #e8e4f8;
    transition: background .3s;
}

.rf-strength-seg.s1 { background: #ef4444; }
.rf-strength-seg.s2 { background: #f59e0b; }
.rf-strength-seg.s3 { background: #10b981; }

.rf-strength-label {
    font-size: .72rem;
    font-weight: 600;
    margin-top: 5px;
    color: #b0aac8;
    text-align: right;
    transition: color .3s;
}

/* Password match indicator */
.rf-match {
    position: absolute;
    right: 14px;
    top: 50%; transform: translateY(-50%);
    font-size: .9rem;
    pointer-events: none;
    opacity: 0;
    transition: opacity .2s;
}
.rf-match.ok   { color: #10b981; opacity: 1; }
.rf-match.fail { color: #ef4444; opacity: 1; }

/* Error */
.rf-error {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-top: 6px;
    font-size: .76rem;
    color: #ef4444;
    font-weight: 500;
}
.rf-error i { font-size: .75rem; }

.rf-input.is-invalid {
    border-color: #ef4444;
    background: #fff5f5;
}

/* ── Two-col row ── */
.rf-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
}

/* ── Terms ── */
.rf-terms {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    margin: 20px 0 24px;
    padding: 14px;
    border-radius: 12px;
    background: rgba(109,94,252,.04);
    border: 1px solid rgba(109,94,252,.1);
}

.rf-terms input[type="checkbox"] {
    width: 17px; height: 17px;
    flex-shrink: 0;
    margin-top: 1px;
    accent-color: #6d5efc;
    cursor: pointer;
}

.rf-terms-text {
    font-size: .8rem;
    color: #6b6b7a;
    line-height: 1.5;
}

.rf-terms-text a {
    color: #6d5efc;
    font-weight: 600;
    text-decoration: none;
}
.rf-terms-text a:hover { text-decoration: underline; }

/* ── Submit ── */
.rf-btn {
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
}

.rf-btn::after {
    content: '';
    position: absolute;
    top: 0; left: -100%;
    width: 60%; height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,.18), transparent);
    transform: skewX(-15deg);
    transition: left .5s ease;
}
.rf-btn:hover::after { left: 150%; }
.rf-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 16px 38px rgba(109,94,252,.48);
}
.rf-btn:active { transform: translateY(0); }

/* ── Benefits strip ── */
.rf-benefits {
    display: flex;
    justify-content: center;
    gap: 20px;
    flex-wrap: wrap;
    margin-top: 22px;
    padding-top: 20px;
    border-top: 1px solid #f0eeff;
}

.rf-benefit {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: .72rem;
    color: #a0a0b8;
    font-weight: 500;
}

.rf-benefit i { color: #10b981; font-size: .75rem; }

/* ── Login link ── */
.rf-login {
    text-align: center;
    margin-top: 22px;
    font-size: .84rem;
    color: #9090a8;
}
.rf-login a {
    color: #6d5efc;
    font-weight: 700;
    text-decoration: none;
    margin-left: 4px;
}
.rf-login a:hover { text-decoration: underline; }

/* ── Dark mobile ── */
@media (max-width: 900px) {
    .rf-logo-mobile { display: flex; }
    .rf-title  { color: #fff; }
    .rf-subtitle { color: rgba(255,255,255,.5); }
    .rf-label  { color: rgba(255,255,255,.75); }
    .rf-terms  { background: rgba(255,255,255,.05); border-color: rgba(255,255,255,.1); }
    .rf-terms-text { color: rgba(255,255,255,.5); }
    .rf-step-dot  { background: rgba(255,255,255,.06); border-color: rgba(255,255,255,.1); }
    .rf-step-label { color: rgba(255,255,255,.3); }
    .rf-step-line  { background: rgba(255,255,255,.1); }
    .rf-input {
        background: rgba(255,255,255,.07);
        border-color: rgba(255,255,255,.12);
        color: #fff;
    }
    .rf-input::placeholder { color: rgba(255,255,255,.3); }
    .rf-input:focus {
        background: rgba(255,255,255,.1);
        border-color: #6d5efc;
    }
    .rf-input-icon { color: rgba(255,255,255,.3); }
    .rf-strength-seg { background: rgba(255,255,255,.1); }
    .rf-benefits { border-top-color: rgba(255,255,255,.08); }
    .rf-benefit  { color: rgba(255,255,255,.3); }
    .rf-login    { color: rgba(255,255,255,.4); }
}

@media (max-width: 520px) {
    .rf-row { grid-template-columns: 1fr; }
}
</style>

{{-- ── Header ───────────────────────────────────────────── --}}
<div class="rf-header">
    <div class="rf-logo-mobile">
        <i class="bi bi-lightning-charge-fill"></i>
    </div>
    <h2 class="rf-title">Create your account</h2>
    <p class="rf-subtitle">
        Already have one?
        <a href="{{ route('login') }}">Sign in instead</a>
    </p>
</div>

{{-- ── Progress steps ───────────────────────────────────── --}}
<div class="rf-steps">
    <div class="rf-step active">
        <div class="rf-step-dot">1</div>
        <span class="rf-step-label">Details</span>
    </div>
    <div class="rf-step-line"></div>
    <div class="rf-step">
        <div class="rf-step-dot">2</div>
        <span class="rf-step-label">Password</span>
    </div>
    <div class="rf-step-line"></div>
    <div class="rf-step">
        <div class="rf-step-dot"><i class="bi bi-check2" style="font-size:.85rem;"></i></div>
        <span class="rf-step-label">Done</span>
    </div>
</div>

{{-- ── Form ─────────────────────────────────────────────── --}}
<form method="POST" action="{{ route('register') }}" id="registerForm" novalidate>
    @csrf

    {{-- Name --}}
    <div class="rf-field">
        <label class="rf-label" for="name">Full name</label>
        <div class="rf-input-wrap">
            <input
                id="name"
                type="text"
                name="name"
                value="{{ old('name') }}"
                required
                autofocus
                autocomplete="name"
                placeholder="Alex Johnson"
                class="rf-input {{ $errors->has('name') ? 'is-invalid' : '' }}">
            <i class="bi bi-person rf-input-icon"></i>
        </div>
        @error('name')
            <div class="rf-error"><i class="bi bi-exclamation-circle-fill"></i>{{ $message }}</div>
        @enderror
    </div>

    {{-- Email --}}
    <div class="rf-field">
        <label class="rf-label" for="email">Work email</label>
        <div class="rf-input-wrap">
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autocomplete="username"
                placeholder="alex@company.com"
                class="rf-input {{ $errors->has('email') ? 'is-invalid' : '' }}">
            <i class="bi bi-envelope rf-input-icon"></i>
        </div>
        @error('email')
            <div class="rf-error"><i class="bi bi-exclamation-circle-fill"></i>{{ $message }}</div>
        @enderror
    </div>

    {{-- Passwords (two-col on desktop) --}}
    <div class="rf-row">

        {{-- Password --}}
        <div class="rf-field">
            <label class="rf-label" for="password">Password</label>
            <div class="rf-input-wrap rf-pw-wrap">
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                    placeholder="Create password"
                    class="rf-input {{ $errors->has('password') ? 'is-invalid' : '' }}"
                    id="password">
                <i class="bi bi-lock rf-input-icon"></i>
                <button type="button" class="rf-pw-toggle" id="pwToggle1" tabindex="-1">
                    <i class="bi bi-eye" id="pwIcon1"></i>
                </button>
            </div>
            <div class="rf-strength-bar" id="strengthBar">
                <div class="rf-strength-seg" id="s1"></div>
                <div class="rf-strength-seg" id="s2"></div>
                <div class="rf-strength-seg" id="s3"></div>
                <div class="rf-strength-seg" id="s4"></div>
            </div>
            <div class="rf-strength-label" id="strengthLabel">Enter a password</div>
            @error('password')
                <div class="rf-error"><i class="bi bi-exclamation-circle-fill"></i>{{ $message }}</div>
            @enderror
        </div>

        {{-- Confirm password --}}
        <div class="rf-field">
            <label class="rf-label" for="password_confirmation">Confirm password</label>
            <div class="rf-input-wrap rf-pw-wrap">
                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="Repeat password"
                    class="rf-input {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}">
                <i class="bi bi-lock-fill rf-input-icon"></i>
                <button type="button" class="rf-pw-toggle" id="pwToggle2" tabindex="-1">
                    <i class="bi bi-eye" id="pwIcon2"></i>
                </button>
                <i class="rf-match" id="matchIcon"></i>
            </div>
            @error('password_confirmation')
                <div class="rf-error"><i class="bi bi-exclamation-circle-fill"></i>{{ $message }}</div>
            @enderror
        </div>

    </div>

    {{-- Terms --}}
    <div class="rf-terms">
        <input type="checkbox" id="terms" name="terms" required>
        <div class="rf-terms-text">
            I agree to Taskvel's
            <a href="#">Terms of Service</a> and
            <a href="#">Privacy Policy</a>.
            Your data is encrypted and never shared.
        </div>
    </div>

    {{-- Submit --}}
    <button type="submit" class="rf-btn" id="submitBtn">
        <i class="bi bi-lightning-charge-fill"></i>
        Create my free account
    </button>

</form>

{{-- ── Benefits ─────────────────────────────────────────── --}}
<div class="rf-benefits">
    <div class="rf-benefit"><i class="bi bi-check-circle-fill"></i>Free forever plan</div>
    <div class="rf-benefit"><i class="bi bi-check-circle-fill"></i>No credit card needed</div>
    <div class="rf-benefit"><i class="bi bi-check-circle-fill"></i>Setup in 60 seconds</div>
</div>

{{-- ── Login link ───────────────────────────────────────── --}}
<div class="rf-login">
    Already have an account?
    <a href="{{ route('login') }}">Sign in →</a>
</div>

<script>
/*── Password show/hide (both fields) ──────────────────────*/
[['pwToggle1','password','pwIcon1'],
 ['pwToggle2','password_confirmation','pwIcon2']].forEach(function ([btnId, inputId, iconId]) {
    const btn  = document.getElementById(btnId);
    const inp  = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    if (!btn || !inp) return;
    btn.addEventListener('click', function () {
        const isText = inp.type === 'text';
        inp.type = isText ? 'password' : 'text';
        icon.className = isText ? 'bi bi-eye' : 'bi bi-eye-slash';
    });
});

/*── Password strength meter ───────────────────────────────*/
const pwInput   = document.getElementById('password');
const segs      = [document.getElementById('s1'), document.getElementById('s2'),
                   document.getElementById('s3'), document.getElementById('s4')];
const strLabel  = document.getElementById('strengthLabel');

const levels = [
    { label: 'Too short',  color: '#ef4444', cls: 's1', fill: 1 },
    { label: 'Weak',       color: '#f97316', cls: 's1', fill: 2 },
    { label: 'Fair',       color: '#f59e0b', cls: 's2', fill: 3 },
    { label: 'Strong 💪',  color: '#10b981', cls: 's3', fill: 4 },
];

function scorePassword(pw) {
    if (pw.length === 0) return -1;
    let s = 0;
    if (pw.length >= 8)  s++;
    if (pw.length >= 12) s++;
    if (/[A-Z]/.test(pw) && /[a-z]/.test(pw)) s++;
    if (/\d/.test(pw) && /[^A-Za-z0-9]/.test(pw)) s++;
    return Math.min(s, 3);
}

pwInput?.addEventListener('input', function () {
    const score = scorePassword(this.value);

    segs.forEach(function (s) {
        s.className = 'rf-strength-seg';
    });

    if (score < 0) {
        strLabel.textContent = 'Enter a password';
        strLabel.style.color = '#b0aac8';
        return;
    }

    const lvl = levels[score];
    for (let i = 0; i < lvl.fill; i++) {
        segs[i].classList.add(lvl.cls);
        segs[i].style.background = lvl.color;
    }

    strLabel.textContent  = lvl.label;
    strLabel.style.color  = lvl.color;

    checkMatch();
});

/*── Password match indicator ──────────────────────────────*/
const confirmInput = document.getElementById('password_confirmation');
const matchIcon    = document.getElementById('matchIcon');

function checkMatch() {
    if (!confirmInput.value) {
        matchIcon.className = 'rf-match';
        return;
    }
    const ok = pwInput.value === confirmInput.value;
    matchIcon.className    = 'rf-match ' + (ok ? 'ok' : 'fail');
    matchIcon.className   += ' bi ' + (ok ? 'bi-check-circle-fill' : 'bi-x-circle-fill');
}

confirmInput?.addEventListener('input', checkMatch);

/*── Step indicator: advance on field completion ───────────*/
const steps    = document.querySelectorAll('.rf-step');
const nameInp  = document.getElementById('name');
const emailInp = document.getElementById('email');

function updateSteps() {
    const step1done = nameInp?.value.trim().length > 0 && emailInp?.value.includes('@');
    const step2done = step1done && pwInput?.value.length >= 8 && confirmInput?.value === pwInput?.value;

    steps[0].className = 'rf-step ' + (step1done ? 'done' : 'active');
    steps[1].className = 'rf-step ' + (step2done ? 'done' : step1done ? 'active' : '');
    steps[2].className = 'rf-step ' + (step2done ? 'active' : '');
}

[nameInp, emailInp, pwInput, confirmInput].forEach(function (el) {
    el?.addEventListener('input', updateSteps);
});

/*── Focus class on field containers ──────────────────────*/
document.querySelectorAll('.rf-input').forEach(function (inp) {
    inp.addEventListener('focus', function () {
        this.closest('.rf-field')?.classList.add('focused');
    });
    inp.addEventListener('blur', function () {
        this.closest('.rf-field')?.classList.remove('focused');
    });
});
</script>

</x-guest-layout>