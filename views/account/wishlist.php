<div class="page-header">
    <div class="container">
        <h1>My Wishlist</h1>
        <div class="breadcrumb">
            <a href="<?= SITE_URL ?>">Home</a>
            <span class="sep">/</span>
            <a href="<?= SITE_URL ?>/account">Account</a>
            <span class="sep">/</span>
            <span>Wishlist</span>
        </div>
    </div>
</div>

<div class="container">
    <div class="account-layout">
        <!-- Sidebar -->
        <div class="account-sidebar">
            <div class="user-card">
                <div class="user-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="user-info">
                    <h3><?= e($_SESSION['user_name'] ?? 'User') ?></h3>
                    <p>Customer</p>
                </div>
            </div>
            
            <ul class="account-nav">
                <li><a href="<?= SITE_URL ?>/account"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="<?= SITE_URL ?>/account/orders"><i class="fas fa-box"></i> Orders</a></li>
                <li class="active"><a href="<?= SITE_URL ?>/account/wishlist"><i class="fas fa-heart"></i> Wishlist</a></li>
                <li><a href="<?= SITE_URL ?>/account/profile"><i class="fas fa-user-cog"></i> Profile</a></li>
                <li><a href="<?= SITE_URL ?>/auth/logout" class="text-danger"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="account-main">
            <div class="dashboard-card">
                <div class="card-header">
                    <h2>My Wishlist</h2>
                </div>
                <div class="card-body">
                    <?php if (empty($products)): ?>
                        <div class="empty-state">
                            <div class="empty-state-icon"><i class="far fa-heart"></i></div>
                            <h3>Your wishlist is empty</h3>
                            <p>Browse our collection and add your favorite items here.</p>
                            <a href="<?= SITE_URL ?>/shop" class="btn btn-gold mt-4">Browse Products</a>
                        </div>
                    <?php else: ?>
                        <div class="product-grid" style="grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));">
                            <?php foreach ($products as $product): ?>
                                <?php include APP_PATH . '/views/shop/product_card.php'; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
