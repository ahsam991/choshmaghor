<div class="auth-page">
    <div class="auth-bg-blur b1"></div>
    <div class="auth-bg-blur b2"></div>
    
    <div class="auth-wrap">
        <div class="auth-card">
            <!-- Logo -->
            <div class="auth-logo">
                <img src="<?= asset('images/logo.png') ?>" alt="ChoshmaZone">
                <h1 class="auth-title">Welcome Back 👋</h1>
                <p class="auth-sub">আপনার অ্যাকাউন্টে লগইন করুন</p>
            </div>

            <!-- Error/Success messages -->
            <?php if (!empty($error)): ?>
            <div class="alert alert-error mb-3">
                <i class="fas fa-exclamation-circle me-2"></i><?= e($error) ?>
            </div>
            <?php endif; ?>

            <!-- Login Form -->
            <form method="POST" action="<?= SITE_URL ?>/auth/login" id="login-form">
                <?= csrfField() ?>
                <div class="form-group">
                    <label class="form-label-text">ইমেইল এড্রেস</label>
                    <div class="input-wrap">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" name="email" class="form-field" placeholder="example@email.com"
                            value="<?= isset($_POST['email']) ? e($_POST['email']) : '' ?>" required>
                    </div>
                </div>

                <div class="form-group mb-1">
                    <label class="form-label-text">পাসওয়ার্ড</label>
                    <div class="input-wrap">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" name="password" id="password" class="form-field" placeholder="আপনার পাসওয়ার্ড" required>
                        <button type="button" class="eye-toggle" onclick="togglePassword()">
                            <i class="fas fa-eye" id="eye-icon"></i>
                        </button>
                    </div>
                </div>

                <div class="form-check-row mb-4">
                    <label class="form-check-label">
                        <input type="checkbox" name="remember"> মনে রাখুন
                    </label>
                    <a href="<?= SITE_URL ?>/auth/forgot-password" class="auth-link" style="font-size: 0.85rem;">পাসওয়ার্ড ভুলে গেছেন?</a>
                </div>

                <button type="submit" class="btn btn-gold btn-full btn-lg">
                    <i class="fas fa-sign-in-alt me-2"></i> লগইন করুন
                </button>
            </form>

            <div class="auth-divider">
                <span>OR</span>
            </div>

            <p class="auth-footer-text">
                অ্যাকাউন্ট নেই? <a href="<?= SITE_URL ?>/auth/register">এখনই নিবন্ধন করুন</a>
            </p>
            
            <div class="back-home">
                <a href="<?= SITE_URL ?>"><i class="fas fa-arrow-left me-1"></i> হোমে ফিরে যান</a>
            </div>
            
            <div style="margin-top: 20px; background: rgba(201,168,76,0.07); border: 1px solid rgba(201,168,76,0.2); border-radius: 8px; padding: 12px 16px; text-align: center;">
                <div style="color: var(--gold); font-size: 0.78rem; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 6px;">
                    <i class="fas fa-shield-alt me-1"></i> অ্যাডমিন লগইন
                </div>
                <div style="color: var(--text-muted); font-size: 0.82rem;">
                    Email: <strong style="color: var(--text);">admin@choshmazone.com</strong><br>
                    Password: <strong style="color: var(--text);">admin123</strong>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const p = document.getElementById('password');
    const eye = document.getElementById('eye-icon');
    if (p.type === 'password') {
        p.type = 'text';
        eye.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        p.type = 'password';
        eye.classList.replace('fa-eye-slash', 'fa-eye');
    }
}
</script>