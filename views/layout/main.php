<!DOCTYPE html>
<html lang="<?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'en' : 'bn' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? e($title) : 'ChoshmaZone - Premium Sunglasses' ?></title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="বাংলাদেশের সেরা অনলাইন সানগ্লাস স্টোর। প্রিমিয়াম কোয়ালিটির সানগ্লাস সেরা দামে পাচ্ছেন শুধুমাত্র চশমাZone-এ।">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Hind+Siliguri:wght@300;400;500;600;700&family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="<?= asset('css/style.css') ?>" rel="stylesheet">
</head>
<body>

<!-- Topbar -->
<div class="topbar">
    <div class="container">
        <div class="topbar-inner">
            <div class="topbar-left">
                <a href="tel:+8801889688034"><i class="fas fa-phone me-1 text-gold"></i> +880 1889-688034</a>
                <span class="d-none d-sm-inline">|</span>
                <a href="mailto:contact@choshmazone.com" class="d-none d-sm-inline"><i class="fas fa-envelope me-1 text-gold"></i> contact@choshmazone.com</a>
            </div>
            <div class="topbar-right">
                <!-- Language Switch -->
                <div class="lang-switch d-inline-flex align-items-center gap-2">
                    <a href="<?= SITE_URL ?>/home/setLang/bn" class="nav-link p-0 <?= (!isset($_SESSION['lang']) || $_SESSION['lang'] === 'bn') ? 'active text-gold' : '' ?>">বাংলা</a>
                    <span class="text-dim">|</span>
                    <a href="<?= SITE_URL ?>/home/setLang/en" class="nav-link p-0 <?= (isset($_SESSION['lang']) && $_SESSION['lang'] === 'en') ? 'active text-gold' : '' ?>">EN</a>
                </div>
                
                <span class="text-dim mx-2">|</span>
                
                <?php if ($this->isLoggedIn()): ?>
                    <div class="nav-item">
                        <a href="<?= SITE_URL ?>/account" class="text-gold fw-600"><i class="fas fa-user-circle me-1"></i><?= e($_SESSION['user_name']) ?></a>
                    </div>
                <?php else: ?>
                    <a href="<?= SITE_URL ?>/auth/login"><i class="fas fa-sign-in-alt me-1 text-gold"></i> <?= __('login') ?></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Main Header -->
<header class="header">
    <div class="container">
        <div class="header-inner">
            <!-- Logo -->
            <a href="<?= SITE_URL ?>" class="logo">
                <img src="<?= asset('images/logo.png') ?>" alt="ChoshmaZone Logo" onerror="this.style.display='none'">
                <div class="logo-text">CHOSHMA<span>ZONE</span></div>
            </a>

            <!-- Nav -->
            <nav class="nav d-none d-lg-flex">
                <a href="<?= SITE_URL ?>" class="nav-link <?= isActive('') ?>"><?= __('home') ?></a>
                <div class="nav-item">
                    <a href="<?= SITE_URL ?>/shop" class="nav-link <?= isActive('shop') ?>"><?= __('shop') ?> <i class="fas fa-chevron-down ms-1" style="font-size: 0.7rem;"></i></a>
                    <div class="dropdown">
                        <a href="<?= SITE_URL ?>/shop?gender=male"><?= __('mens') ?></a>
                        <a href="<?= SITE_URL ?>/shop?gender=female"><?= __('womens') ?></a>
                        <a href="<?= SITE_URL ?>/shop?gender=unisex"><?= __('unisex') ?></a>
                    </div>
                </div>
                <a href="<?= SITE_URL ?>/about" class="nav-link <?= isActive('about') ?>"><?= __('about') ?></a>
                <a href="<?= SITE_URL ?>/contact" class="nav-link <?= isActive('contact') ?>"><?= __('contact') ?></a>
            </nav>

            <!-- Actions -->
            <div class="header-actions">
                <button class="action-btn d-none d-sm-flex" id="search-toggle"><i class="fas fa-search"></i></button>
                <a href="<?= SITE_URL ?>/account/wishlist" class="action-btn d-none d-sm-flex">
                    <i class="far fa-heart"></i>
                </a>
                <button class="action-btn cart-btn" id="open-cart">
                    <i class="fas fa-shopping-bag"></i>
                    <span class="badge-count cart-count"><?= cartCount() ?></span>
                </button>
                <div class="hamburger" id="mobile-toggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Mobile Nav -->
<div class="mobile-nav" id="mobile-nav">
    <button class="mobile-nav-close" id="mobile-close"><i class="fas fa-times"></i></button>
    <div class="logo mb-4 px-3">
        <div class="logo-text">CHOSHMA<span>ZONE</span></div>
    </div>
    <a href="<?= SITE_URL ?>" class="nav-link active"><?= __('home') ?></a>
    <a href="<?= SITE_URL ?>/shop" class="nav-link"><?= __('shop') ?></a>
    <a href="<?= SITE_URL ?>/about" class="nav-link"><?= __('about') ?></a>
    <a href="<?= SITE_URL ?>/contact" class="nav-link"><?= __('contact') ?></a>
    <hr class="border-dim mx-3 my-3">
    <?php if ($this->isLoggedIn()): ?>
        <a href="<?= SITE_URL ?>/account" class="nav-link"><i class="fas fa-user me-2 text-gold"></i><?= __('account') ?></a>
        <a href="<?= SITE_URL ?>/auth/logout" class="nav-link text-danger"><i class="fas fa-sign-out-alt me-2"></i><?= __('logout') ?></a>
    <?php else: ?>
        <a href="<?= SITE_URL ?>/auth/login" class="nav-link"><i class="fas fa-sign-in-alt me-2 text-gold"></i><?= __('login') ?></a>
        <a href="<?= SITE_URL ?>/auth/register" class="nav-link"><i class="fas fa-user-plus me-2 text-gold"></i><?= __('register') ?></a>
    <?php endif; ?>
</div>
<div class="overlay" id="overlay"></div>

<!-- Flash Messages -->
<div class="container mt-3">
    <?= flashMessage() ?>
</div>

<!-- Main Content -->
<main>
    <?= $content ?>
</main>

<!-- Footer -->
<footer class="footer">
    <div class="footer-main">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-info">
                    <div class="footer-logo">
                        <div class="logo-text">CHOSHMA<span>ZONE</span></div>
                    </div>
                    <p class="footer-desc">বাংলাদেশের সেরা অনলাইন সানগ্লাস স্টোর। প্রিমিয়াম কোয়ালিটির সানগ্লাস সেরা দামে পাচ্ছেন শুধুমাত্র চশমাZone-এ।</p>
                    <div class="footer-social">
                        <a href="https://www.facebook.com/profile.php?id=100066797659136" target="_blank" class="social-btn"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://wa.me/8801889688034" target="_blank" class="social-btn"><i class="fab fa-whatsapp"></i></a>
                        <a href="#" class="social-btn"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div>
                    <h6 class="footer-heading"><?= __('quick_links') ?></h6>
                    <ul class="footer-links">
                        <li><a href="<?= SITE_URL ?>"><?= __('home') ?></a></li>
                        <li><a href="<?= SITE_URL ?>/shop"><?= __('shop') ?></a></li>
                        <li><a href="<?= SITE_URL ?>/about"><?= __('about') ?></a></li>
                        <li><a href="<?= SITE_URL ?>/contact"><?= __('contact') ?></a></li>
                    </ul>
                </div>
                <div>
                    <h6 class="footer-heading"><?= __('customer_service') ?></h6>
                    <ul class="footer-links">
                        <li><a href="<?= SITE_URL ?>/account"><?= __('account') ?></a></li>
                        <li><a href="<?= SITE_URL ?>/account/orders">অর্ডার ট্র্যাক</a></li>
                        <li><a href="<?= SITE_URL ?>/contact">রিটার্ন পলিসি</a></li>
                        <li><a href="<?= SITE_URL ?>/contact">সাহায্য কেন্দ্র</a></li>
                    </ul>
                </div>
                <div>
                    <h6 class="footer-heading">যোগাযোগ করুন</h6>
                    <div class="footer-contact-item">
                        <i class="fas fa-map-marker-alt fci-icon"></i>
                        <span class="fci-text">ঢাকা, বাংলাদেশ</span>
                    </div>
                    <div class="footer-contact-item">
                        <i class="fas fa-phone fci-icon"></i>
                        <span class="fci-text">+880 1889-688034</span>
                    </div>
                    <div class="footer-contact-item">
                        <i class="fab fa-whatsapp fci-icon"></i>
                        <span class="fci-text"><a href="https://wa.me/8801889688034" target="_blank">Chat on WhatsApp</a></span>
                    </div>
                    <div class="footer-contact-item">
                        <i class="fas fa-envelope fci-icon"></i>
                        <span class="fci-text">contact@choshmazone.com</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <p>&copy; <?= date('Y') ?> ChoshmaZone. <?= __('rights_reserved') ?>.</p>
            <div class="footer-payments">
                <span class="payment-icon">bKash</span>
                <span class="payment-icon">Nagad</span>
                <span class="payment-icon">Visa</span>
                <span class="payment-icon">COD</span>
            </div>
        </div>
    </div>
</footer>

<!-- WhatsApp Float -->
<a href="https://wa.me/8801889688034" target="_blank" class="whatsapp-float">
    <i class="fab fa-whatsapp"></i>
</a>

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="<?= asset('js/app.js') ?>"></script>
</body>
</html>