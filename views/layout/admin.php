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
    <script>
        // Initialize theme
        const savedTheme = localStorage.getItem('theme') || 'dark';
        document.documentElement.setAttribute('data-theme', savedTheme);
    </script>
</head>
<body class="admin-body">

<div class="admin-wrapper">
    <!-- Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-brand">
            <?php if (!empty($settings['site_logo'])): ?>
                <img src="<?= e($settings['site_logo']) ?>" alt="Logo" class="admin-logo-img">
            <?php else: ?>
                <i class="fas fa-glasses"></i>
                <span><?= e($settings['site_title'] ?? 'ChoshmaZone') ?></span>
            <?php endif; ?>
        </div>
        <nav class="sidebar-nav">
            <div class="nav-section">Dashboard</div>
            <a href="<?= SITE_URL ?>/admin" class="nav-item <?= ($page ?? '') === 'dashboard' ? 'active' : '' ?>">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <div class="nav-section">Products</div>
            <a href="<?= SITE_URL ?>/admin/products" class="nav-item <?= ($page ?? '') === 'products' ? 'active' : '' ?>">
                <i class="fas fa-glasses"></i> All Products
            </a>
            <a href="<?= SITE_URL ?>/admin/addProduct" class="nav-item <?= ($page ?? '') === 'add-product' ? 'active' : '' ?>">
                <i class="fas fa-plus-circle"></i> Add New Product
            </a>
            <div class="nav-section">Sales</div>
            <a href="<?= SITE_URL ?>/admin/orders" class="nav-item <?= ($page ?? '') === 'orders' ? 'active' : '' ?>">
                <i class="fas fa-shopping-cart"></i> Orders
            </a>
            <a href="<?= SITE_URL ?>/admin/users" class="nav-item <?= ($page ?? '') === 'users' ? 'active' : '' ?>">
                <i class="fas fa-users"></i> Customers
            </a>
            <div class="nav-section">Settings</div>
            <a href="<?= SITE_URL ?>/admin/settings" class="nav-item <?= ($page ?? '') === 'settings' ? 'active' : '' ?>">
                <i class="fas fa-cog"></i> General Settings
            </a>
            <a href="<?= SITE_URL ?>" class="nav-item" target="_blank">
                <i class="fas fa-external-link-alt"></i> View Storefront
            </a>
            <a href="<?= SITE_URL ?>/auth/logout" class="nav-item text-danger">
                <i class="fas fa-sign-out-alt"></i> Logout
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
