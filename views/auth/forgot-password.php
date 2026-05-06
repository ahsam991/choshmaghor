<div class="auth-page">
    <div class="auth-bg-blur b1"></div>
    <div class="auth-bg-blur b2"></div>
    
    <div class="auth-wrap">
        <div class="auth-card">
            <!-- Logo -->
            <div class="auth-logo">
                <img src="<?= asset('images/logo.png') ?>" alt="ChoshmaZone">
                <h1 class="auth-title">Forgot Password 🔐</h1>
                <p class="auth-sub">Enter your email to receive password reset instructions</p>
            </div>

            <!-- Alerts -->
            <?php if (!empty($error)): ?>
            <div class="alert alert-error mb-3">
                <i class="fas fa-exclamation-circle me-2"></i><?= e($error) ?>
            </div>
            <?php endif; ?>
            
            <?php if (!empty($success)): ?>
            <div class="alert alert-success mb-3">
                <i class="fas fa-check-circle me-2"></i><?= $success ?>
            </div>
            <?php endif; ?>

            <!-- Forgot Password Form -->
            <form method="POST" action="<?= SITE_URL ?>/auth/forgot-password" id="forgot-password-form">
                <?= csrfField() ?>
                
                <div class="form-group mb-4">
                    <label class="form-label-text">ইমেইল এড্রেস</label>
                    <div class="input-wrap">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" name="email" class="form-field" placeholder="example@email.com"
                            value="<?= isset($_POST['email']) ? e($_POST['email']) : '' ?>" required>
                    </div>
                    <small class="form-text">We'll send you a link to reset your password</small>
                </div>

                <button type="submit" class="btn btn-gold btn-full btn-lg">
                    <i class="fas fa-paper-plane me-2"></i> Send Reset Link
                </button>
            </form>

            <p class="auth-footer-text mt-4">
                Remember your password? <a href="<?= SITE_URL ?>/auth/login">Login here</a>
            </p>
            
            <div class="back-home">
                <a href="<?= SITE_URL ?>"><i class="fas fa-arrow-left me-1"></i> Back to Home</a>
            </div>
        </div>
    </div>
</div>
