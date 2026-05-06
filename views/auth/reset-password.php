<div class="auth-page">
    <div class="auth-bg-blur b1"></div>
    <div class="auth-bg-blur b2"></div>
    
    <div class="auth-wrap">
        <div class="auth-card">
            <!-- Logo -->
            <div class="auth-logo">
                <img src="<?= asset('images/logo.png') ?>" alt="ChoshmaZone">
                <h1 class="auth-title">Reset Password 🔑</h1>
                <p class="auth-sub">Enter your new password below</p>
            </div>

            <!-- Alerts -->
            <?php if (!empty($error)): ?>
            <div class="alert alert-error mb-3">
                <i class="fas fa-exclamation-circle me-2"></i><?= e($error) ?>
            </div>
            <?php endif; ?>
            
            <?php if (!empty($success)): ?>
            <div class="alert alert-success mb-3">
                <i class="fas fa-check-circle me-2"></i><?= e($success) ?>
            </div>
            <?php endif; ?>

            <!-- Reset Password Form -->
            <?php if (empty($error) || strpos($error, 'Invalid reset token') === false): ?>
            <form method="POST" action="<?= SITE_URL ?>/auth/reset-password?token=<?= e($token) ?>" id="reset-password-form">
                <?= csrfField() ?>
                
                <div class="form-group">
                    <label class="form-label-text">New Password</label>
                    <div class="input-wrap">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" name="password" id="password" class="form-field" placeholder="Minimum 8 characters" required>
                        <button type="button" class="eye-toggle" onclick="togglePw('password','eye1')">
                            <i class="fas fa-eye" id="eye1"></i>
                        </button>
                    </div>
                    <small class="form-text">Must be at least 8 characters with uppercase, lowercase, number and special character</small>
                </div>

                <div class="form-group mb-4">
                    <label class="form-label-text">Confirm Password</label>
                    <div class="input-wrap">
                        <i class="fas fa-shield-alt input-icon"></i>
                        <input type="password" name="confirm_password" id="confirm_password" class="form-field" placeholder="Re-enter your password" required>
                        <button type="button" class="eye-toggle" onclick="togglePw('confirm_password','eye2')">
                            <i class="fas fa-eye" id="eye2"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-gold btn-full btn-lg">
                    <i class="fas fa-key me-2"></i> Reset Password
                </button>
            </form>
            <?php endif; ?>

            <p class="auth-footer-text mt-4">
                Remember your password? <a href="<?= SITE_URL ?>/auth/login">Login here</a>
            </p>
            
            <div class="back-home">
                <a href="<?= SITE_URL ?>"><i class="fas fa-arrow-left me-1"></i> Back to Home</a>
            </div>
        </div>
    </div>
</div>

<script>
function togglePw(id, eyeId) {
    const inp = document.getElementById(id);
    const eye = document.getElementById(eyeId);
    inp.type = inp.type === 'password' ? 'text' : 'password';
    eye.classList.toggle('fa-eye');
    eye.classList.toggle('fa-eye-slash');
}
</script>
