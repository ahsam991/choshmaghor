<div class="page-header">
    <div class="container">
        <h1>My Account</h1>
        <div class="breadcrumb">
            <a href="<?= SITE_URL ?>">Home</a>
            <span class="sep">/</span>
            <span>Dashboard</span>
        </div>
    </div>
</div>

<div class="container">
    <div class="account-layout">
        <!-- Sidebar -->
        <aside class="account-sidebar">
            <div class="account-user">
                <div class="user-avatar">
                    <i class="fas fa-user-circle"></i>
                </div>
                <div class="user-info">
                    <h4 class="user-name"><?= e($_SESSION['user_name']) ?></h4>
                    <p class="user-email"><?= e($_SESSION['user_email']) ?></p>
                </div>
            </div>
            
            <nav class="account-nav">
                <a href="<?= SITE_URL ?>/account" class="nav-item active">
                    <i class="fas fa-th-large"></i> Dashboard
                </a>
                <a href="<?= SITE_URL ?>/account/orders" class="nav-item">
                    <i class="fas fa-shopping-bag"></i> My Orders
                </a>
                <a href="<?= SITE_URL ?>/account/profile" class="nav-item">
                    <i class="fas fa-user-edit"></i> Profile Settings
                </a>
                <a href="<?= SITE_URL ?>/auth/logout" class="nav-item text-danger">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="account-main">
            <div class="welcome-banner">
                <div class="wb-text">
                    <h2>Hello, <?= explode(' ', e($user['name']))[0] ?>! 👋</h2>
                    <p>Welcome to your premium dashboard. Here you can track your orders and manage your account details.</p>
                </div>
                <div class="wb-icon">🕶️</div>
            </div>

            <!-- Stats -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-box"></i></div>
                    <div class="stat-info">
                        <span class="stat-num"><?= count($orders) ?></span>
                        <span class="stat-label">Total Orders</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon text-success"><i class="fas fa-check-double"></i></div>
                    <div class="stat-info">
                        <span class="stat-num"><?= count(array_filter($orders, fn($o) => $o['status'] === 'delivered')) ?></span>
                        <span class="stat-label">Delivered</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon text-gold"><i class="fas fa-clock"></i></div>
                    <div class="stat-info">
                        <span class="stat-num"><?= count(array_filter($orders, fn($o) => in_array($o['status'], ['pending','confirmed','shipped']))) ?></span>
                        <span class="stat-label">In Progress</span>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="account-card mt-4">
                <div class="card-header">
                    <h3 class="card-title">Recent Orders</h3>
                    <a href="<?= SITE_URL ?>/account/orders" class="btn btn-outline-gold btn-sm">View All</a>
                </div>
                
                <?php if (empty($orders)): ?>
                <div class="empty-state py-4">
                    <p class="text-dim">You haven't placed any orders yet.</p>
                    <a href="<?= SITE_URL ?>/shop" class="btn btn-gold btn-sm mt-2">Start Shopping</a>
                </div>
                <?php else: ?>
                <div class="table-responsive">
                    <table class="premium-table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (array_slice($orders, 0, 5) as $order): ?>
                            <tr>
                                <td><span class="text-gold">#<?= e($order['order_number']) ?></span></td>
                                <td><?= date('M d, Y', strtotime($order['created_at'])) ?></td>
                                <td><strong><?= formatPrice($order['total']) ?></strong></td>
                                <td>
                                    <?php
                                    $statusClasses = [
                                        'pending' => 'st-pending',
                                        'confirmed' => 'st-confirmed',
                                        'shipped' => 'st-shipped',
                                        'delivered' => 'st-delivered',
                                        'cancelled' => 'st-cancelled'
                                    ];
                                    $statusName = ucfirst($order['status']);
                                    echo '<span class="status-badge ' . ($statusClasses[$order['status']] ?? '') . '">' . $statusName . '</span>';
                                    ?>
                                </td>
                                <td>
                                    <a href="<?= SITE_URL ?>/account/order/<?= e($order['order_number']) ?>" class="action-link">Details</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</div>