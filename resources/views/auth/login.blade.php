<x-guest-layout>

<style>
/*══════════════════════════════════════════
  LOGIN FORM — Premium
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

/* ── Remember + forgot row ── */
.lf-meta {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 24px;
}

.lf-remember {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    user-select: none;
}

.lf-remember input[type="checkbox"] {
    width: 17px; height: 17px;
    accent-color: #6d5efc;
    border-radius: 4px;
    cursor: pointer;
}

.lf-remember span {
    font-size: .82rem;
    color: #6b6b7a;
    font-weight: 500;
}

.lf-forgot {
    font-size: .8rem;
    font-weight: 600;
    color: #6d5efc;
    text-decoration: none;
}
.lf-forgot:hover { text-decoration: underline; }

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

/* ── Divider ── */
.lf-divider {
    display: flex;
    align-items: center;
    gap: 14px;
    margin: 28px 0;
    font-size: .76rem;
    color: #c8c4e4;
    font-weight: 600;
    letter-spacing: .04em;
}
.lf-divider::before,
.lf-divider::after {
    content: '';
    flex: 1;
    height: 1px;
    background: linear-gradient(90deg, transparent, #e8e4f8, transparent);
}

/* ── Social logins ── */
.lf-social {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
    margin-bottom: 28px;
}

.lf-social-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 11px;
    border: 1.5px solid #e8e4f8;
    border-radius: 12px;
    background: #fdfcff;
    font-size: .82rem;
    font-weight: 600;
    color: #3a3a4a;
    cursor: pointer;
    transition: all .18s ease;
    text-decoration: none;
    font-family: 'Inter', sans-serif;
}

.lf-social-btn:hover {
    border-color: #6d5efc;
    background: rgba(109,94,252,.04);
    color: #6d5efc;
    transform: translateY(-1px);
}

.lf-social-btn img {
    width: 18px; height: 18px;
    object-fit: contain;
}

/* ── Register link ── */
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
}
.lf-register a:hover { text-decoration: underline; }

/* ── Dark mode (right panel goes dark on mobile) ── */
@media (max-width: 900px) {
    .lf-logo-mobile { display: flex; }
    .lf-title  { color: #fff; }
    .lf-subtitle { color: rgba(255,255,255,.5); }
    .lf-label  { color: rgba(255,255,255,.75); }
    .lf-remember span { color: rgba(255,255,255,.5); }
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
    .lf-social-btn {
        background: rgba(255,255,255,.06);
        border-color: rgba(255,255,255,.1);
        color: rgba(255,255,255,.7);
    }
    .lf-social-btn:hover { background: rgba(109,94,252,.18); color: #fff; }
    .lf-divider { color: rgba(255,255,255,.2); }
    .lf-divider::before, .lf-divider::after { background: rgba(255,255,255,.1); }
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
    <div class="lf-logo-mobile">
        <i class="bi bi-lightning-charge-fill"></i>
    </div>
    <h2 class="lf-title">Welcome back 👋</h2>
    <p class="lf-subtitle">
        New to Taskvel?
        @if(Route::has('register'))
            <a href="{{ route('register') }}">Create a free account</a>
        @endif
    </p>
</div>

{{-- ── Social login buttons ─────────────────────────────── --}}
<div class="lf-social">
    <button type="button" class="lf-social-btn" onclick="alert('Coming soon')">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" fill="#FBBC05"/>
            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
        </svg>
        Google
    </button>
    <button type="button" class="lf-social-btn" onclick="alert('Coming soon')">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 0C5.374 0 0 5.373 0 12c0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0 1 12 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z"/>
        </svg>
        GitHub
    </button>
</div>

<div class="lf-divider">or sign in with email</div>

{{-- ── Form ─────────────────────────────────────────────── --}}
<form method="POST" action="{{ route('login') }}" novalidate>
    @csrf

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
                value="{{ old('email') }}"
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

    {{-- Password --}}
    <div class="lf-field">
        <div class="lf-label">
            <span>Password</span>
            @if(Route::has('password.request'))
                <a href="{{ route('password.request') }}">Forgot password?</a>
            @endif
        </div>
        <div class="lf-input-wrap">
            <input
                id="password"
                type="password"
                name="password"
                required
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

    {{-- Remember me --}}
    <div class="lf-meta">
        <label class="lf-remember">
            <input type="checkbox" name="remember" id="remember_me"
                   {{ old('remember') ? 'checked' : '' }}>
            <span>Keep me signed in</span>
        </label>
    </div>

    {{-- Submit --}}
    <button type="submit" class="lf-btn">
        <i class="bi bi-lightning-charge-fill"></i>
        Sign in to Taskvel
    </button>

</form>

{{-- ── Register link ────────────────────────────────────── --}}
@if(Route::has('register'))
    <div class="lf-register">
        Don't have an account?
        <a href="{{ route('register') }}">Sign up free →</a>
    </div>
@endif

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