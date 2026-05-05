<div class="auth-page">
    <div class="auth-bg-blur b1"></div>
    <div class="auth-bg-blur b2"></div>
    
    <div class="auth-wrap">
        <div class="auth-card">
            <!-- Logo -->
            <div class="auth-logo">
                <img src="<?= asset('images/logo.png') ?>" alt="ChoshmaZone">
                <h1 class="auth-title">Create Account ✨</h1>
                <p class="auth-sub">আজই যোগ দিন এবং প্রিমিয়াম সানগ্লাস উপভোগ করুন</p>
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

            <!-- Register Form -->
            <form method="POST" action="<?= SITE_URL ?>/auth/register" id="register-form">
                <div class="form-group">
                    <label class="form-label-text">পুরো নাম</label>
                    <div class="input-wrap">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" name="name" class="form-field" placeholder="আপনার নাম"
                            value="<?= isset($_POST['name']) ? e($_POST['name']) : '' ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label-text">ইমেইল এড্রেস</label>
                    <div class="input-wrap">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" name="email" class="form-field" placeholder="example@email.com"
                            value="<?= isset($_POST['email']) ? e($_POST['email']) : '' ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label-text">পাসওয়ার্ড</label>
                    <div class="input-wrap">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" name="password" id="password" class="form-field" placeholder="কমপক্ষে ৮ অক্ষর" required>
                        <button type="button" class="eye-toggle" onclick="togglePw('password','eye1')">
                            <i class="fas fa-eye" id="eye1"></i>
                        </button>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label class="form-label-text">পাসওয়ার্ড নিশ্চিত করুন</label>
                    <div class="input-wrap">
                        <i class="fas fa-shield-alt input-icon"></i>
                        <input type="password" name="confirm_password" id="confirm_password" class="form-field" placeholder="পাসওয়ার্ড পুনরায় লিখুন" required>
                        <button type="button" class="eye-toggle" onclick="togglePw('confirm_password','eye2')">
                            <i class="fas fa-eye" id="eye2"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-gold btn-full btn-lg">
                    <i class="fas fa-user-plus me-2"></i> অ্যাকাউন্ট তৈরি করুন
                </button>
            </form>

            <p class="auth-footer-text mt-4">
                ইতিমধ্যে অ্যাকাউন্ট আছে? <a href="<?= SITE_URL ?>/auth/login">লগইন করুন</a>
            </p>
            
            <div class="back-home">
                <a href="<?= SITE_URL ?>"><i class="fas fa-arrow-left me-1"></i> হোমে ফিরে যান</a>
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