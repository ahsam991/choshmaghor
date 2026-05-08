<div class="auth-page">
    <div class="auth-bg-blur b1"></div>
    <div class="auth-bg-blur b2"></div>
    
    <div class="auth-wrap">
        <div class="auth-card">
            <!-- Logo -->
            <div class="auth-logo">
                <img src="<?= asset('images/logo.png') ?>" alt="ChoshmaZone">
                <h1 class="auth-title">Email Verification ✉️</h1>
                <p class="auth-sub">Verifying your email address</p>
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

            <div class="text-center my-4">
                <?php if (!empty($success)): ?>
                <div class="verification-icon success">
                    <i class="fas fa-check-circle fa-4x text-success"></i>
                </div>
                <p class="mt-3">Your email has been verified successfully!</p>
                <a href="<?= SITE_URL ?>/auth/login" class="btn btn-gold btn-lg mt-3">
                    <i class="fas fa-sign-in-alt me-2"></i> Go to Login
                </a>
                <?php else: ?>
                <div class="verification-icon error">
                    <i class="fas fa-times-circle fa-4x text-danger"></i>
                </div>
                <p class="mt-3"><?= e($error) ?></p>
                <a href="<?= SITE_URL ?>" class="btn btn-gold btn-lg mt-3">
                    <i class="fas fa-home me-2"></i> Back to Home
                </a>
                <?php endif; ?>
            </div>
            
            <div class="back-home">
                <a href="<?= SITE_URL ?>"><i class="fas fa-arrow-left me-1"></i> Back to Home</a>
            </div>
        </div>
    </div>
</div>

<style>
.verification-icon {
    margin: 2rem 0;
}
.verification-icon.success i {
    color: #28a745;
}
.verification-icon.error i {
    color: #dc3545;
}
.text-center {
    text-align: center;
}
.my-4 {
    margin-top: 1.5rem;
    margin-bottom: 1.5rem;
}
.mt-3 {
    margin-top: 1rem;
}
.text-success {
    color: #28a745;
}
.text-danger {
    color: #dc3545;
}
</style>
