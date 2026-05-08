<!DOCTYPE html>
<html lang="<?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'en' : 'bn' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? e($title) : 'Admin Dashboard - ChoshmaZone' ?></title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Hind+Siliguri:wght@300;400;500;600;700&family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="<?= asset('css/style.css') ?>" rel="stylesheet">
    <link href="<?= asset('css/admin.css') ?>" rel="stylesheet">
</head>
<body class="admin-body">

<div class="admin-wrapper">
    <!-- Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-brand">
            <i class="fas fa-glasses"></i>
            <span>চশমাZone</span>
        </div>
        <nav class="sidebar-nav">
            <div class="nav-section">ড্যাশবোর্ড</div>
            <a href="<?= SITE_URL ?>/admin" class="nav-item <?= ($page ?? '') === 'dashboard' ? 'active' : '' ?>">
                <i class="fas fa-tachometer-alt"></i> ড্যাশবোর্ড
            </a>
            <div class="nav-section">পণ্য</div>
            <a href="<?= SITE_URL ?>/admin/products" class="nav-item <?= ($page ?? '') === 'products' ? 'active' : '' ?>">
                <i class="fas fa-glasses"></i> সব পণ্য
            </a>
            <a href="<?= SITE_URL ?>/admin/addProduct" class="nav-item <?= ($page ?? '') === 'add-product' ? 'active' : '' ?>">
                <i class="fas fa-plus-circle"></i> নতুন পণ্য
            </a>
            <div class="nav-section">বিক্রয়</div>
            <a href="<?= SITE_URL ?>/admin/orders" class="nav-item <?= ($page ?? '') === 'orders' ? 'active' : '' ?>">
                <i class="fas fa-shopping-cart"></i> অর্ডার
            </a>
            <a href="<?= SITE_URL ?>/admin/users" class="nav-item <?= ($page ?? '') === 'users' ? 'active' : '' ?>">
                <i class="fas fa-users"></i> ব্যবহারকারী
            </a>
            <div class="nav-section">সেটিংস</div>
            <a href="<?= SITE_URL ?>/admin/settings" class="nav-item <?= ($page ?? '') === 'settings' ? 'active' : '' ?>">
                <i class="fas fa-cog"></i> সাইট সেটিংস
            </a>
            <a href="<?= SITE_URL ?>" class="nav-item" target="_blank">
                <i class="fas fa-external-link-alt"></i> সাইট দেখুন
            </a>
            <a href="<?= SITE_URL ?>/auth/logout" class="nav-item text-danger">
                <i class="fas fa-sign-out-alt"></i> লগআউট
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="admin-main">
        <header class="admin-header">
            <button class="sidebar-toggle" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
            <div class="admin-header-right">
                <?= flashMessage() ?>
                <div class="admin-user">
                    <i class="fas fa-user-circle me-2"></i>
                    <?= e($_SESSION['user_name'] ?? 'Admin') ?>
                </div>
            </div>
        </header>
        <div class="admin-content">
            <?= $content ?>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="<?= asset('js/admin.js') ?>"></script>
</body>
</html>
