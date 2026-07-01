<footer class="premium-footer border-top">

    <div class="container-fluid py-4">

        <div class="row gy-4 align-items-start">

            {{-- Brand --}}
            <div class="col-lg-4 col-md-12">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="footer-logo-dot"></span>
                    <span class="fw-bold fs-5">Taskvel</span>
                </div>
                <p class="text-muted small mb-0" style="max-width: 320px;">
                    A premium workspace to plan, focus, and get things done — beautifully.
                </p>
            </div>

            {{-- Quick Links --}}
            <div class="col-lg-3 col-6">
                <h6 class="footer-heading">Product</h6>
                <ul class="footer-links">
                    <li><a href="#">Dashboard</a></li>
                    <li><a href="#">Tasks</a></li>
                    <li><a href="#">Focus Mode</a></li>
                    <li><a href="#">Reports</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-6">
                <h6 class="footer-heading">Company</h6>
                <ul class="footer-links">
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms of Service</a></li>
                    <li><a href="#">Support</a></li>
                    <li><a href="#">Changelog</a></li>
                </ul>
            </div>

            {{-- Socials --}}
            <div class="col-lg-2 col-12">
                <h6 class="footer-heading">Connect</h6>
                <div class="d-flex gap-2">
                    <a href="https://github.com" target="_blank" class="footer-social"><i class="bi bi-github"></i></a>
                    <a href="#" class="footer-social"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="footer-social"><i class="bi bi-linkedin"></i></a>
                </div>
            </div>

        </div>

    </div>

    {{-- Bottom Bar --}}
    <div class="footer-bottom py-3">
        <div class="container-fluid">
            <div class="row align-items-center gy-2">

                <div class="col-md-6 text-center text-md-start">
                    <span class="text-muted small">© {{ date('Y') }} Taskvel. All rights reserved.</span>
                </div>

                <div class="col-md-6 text-center text-md-end">
                    <span class="footer-version">
                        <i class="bi bi-patch-check-fill"></i>
                        v1.0.0
                    </span>
                </div>

            </div>
        </div>
    </div>

</footer>

<style>
    .premium-footer {
        background: linear-gradient(180deg, #fff, #fafaff);
        border-top: 1px solid rgba(0,0,0,0.06) !important;
        font-size: .875rem;
        margin-top: auto;
    }

    .footer-logo-dot {
        width: 9px;
        height: 9px;
        border-radius: 50%;
        background: linear-gradient(135deg, #6d5efc, #a06dfc);
        display: inline-block;
        box-shadow: 0 0 0 4px rgba(109, 94, 252, 0.12);
    }

    .footer-heading {
        font-size: .78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .06em;
        color: #9a9aab;
        margin-bottom: 12px;
    }

    .footer-links {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .footer-links a {
        color: #5b5b6b;
        text-decoration: none;
        font-size: .875rem;
        transition: color .15s ease, padding-left .15s ease;
    }
    .footer-links a:hover {
        color: #6d5efc;
        padding-left: 3px;
    }

    .footer-social {
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: rgba(109, 94, 252, 0.06);
        color: #6b6b7a;
        transition: all .2s ease;
    }
    .footer-social:hover {
        background: linear-gradient(135deg, #6d5efc, #a06dfc);
        color: #fff;
        transform: translateY(-2px);
    }

    .footer-bottom {
        border-top: 1px solid rgba(0,0,0,0.05);
        background: rgba(109, 94, 252, 0.02);
    }

    .footer-version {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        border-radius: 20px;
        background: rgba(109, 94, 252, 0.08);
        color: #6d5efc;
        font-weight: 600;
        font-size: .78rem;
    }

    [data-bs-theme="dark"] .premium-footer {
        background: linear-gradient(180deg, #14141e, #0f0f18);
        border-top-color: rgba(255,255,255,0.06) !important;
    }
    [data-bs-theme="dark"] .footer-links a { color: #a0a0b0; }
    [data-bs-theme="dark"] .footer-bottom { background: rgba(109, 94, 252, 0.04); border-top-color: rgba(255,255,255,0.05); }
</style>