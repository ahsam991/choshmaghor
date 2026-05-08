<!-- Dashboard Header -->
<div class="admin-page-header">
    <div>
        <h1 class="admin-page-title">
            <i class="fas fa-tachometer-alt"></i> অ্যাডমিন ড্যাশবোর্ড
        </h1>
        <p class="admin-page-sub"><?= date('d F Y, l') ?> — স্বাগতম, <strong><?= e($_SESSION['user_name'] ?? 'Admin') ?></strong>!</p>
    </div>
    <a href="<?= SITE_URL ?>/admin/addProduct" class="btn btn-gold">
        <i class="fas fa-plus"></i> নতুন পণ্য
    </a>
</div>

<?php if (!empty($error)): ?>
<div class="alert alert-error mb-4"><i class="fas fa-exclamation-circle me-2"></i><?= e($error) ?></div>
<?php endif; ?>

<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card-inner">
            <div>
                <div class="stat-label">মোট পণ্য</div>
                <div class="stat-value"><?= isset($productCount) ? $productCount : 0 ?></div>
                <a href="<?= SITE_URL ?>/admin/products" class="stat-link">পণ্য পরিচালনা →</a>
            </div>
            <div class="stat-icon-box" style="background: rgba(201,168,76,0.12);">
                <i class="fas fa-glasses" style="color: var(--gold);"></i>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-card-inner">
            <div>
                <div class="stat-label">মোট অর্ডার</div>
                <div class="stat-value"><?= isset($orderCount) ? $orderCount : 0 ?></div>
                <a href="<?= SITE_URL ?>/admin/orders" class="stat-link">অর্ডার পরিচালনা →</a>
            </div>
            <div class="stat-icon-box" style="background: rgba(33,150,243,0.12);">
                <i class="fas fa-shopping-cart" style="color: #64b5f6;"></i>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-card-inner">
            <div>
                <div class="stat-label">মোট ব্যবহারকারী</div>
                <div class="stat-value"><?= isset($userCount) ? $userCount : 0 ?></div>
                <a href="<?= SITE_URL ?>/admin/users" class="stat-link">ব্যবহারকারী →</a>
            </div>
            <div class="stat-icon-box" style="background: rgba(76,175,80,0.12);">
                <i class="fas fa-users" style="color: var(--green);"></i>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-card-inner">
            <div>
                <div class="stat-label">মোট রাজস্ব</div>
                <div class="stat-value" style="color: var(--gold);">৳<?= isset($revenue) ? number_format($revenue, 0) : 0 ?></div>
                <span class="stat-link" style="cursor:default;">সমস্ত অর্ডার থেকে</span>
            </div>
            <div class="stat-icon-box" style="background: rgba(201,168,76,0.12);">
                <i class="fas fa-taka-sign" style="color: var(--gold);"></i>
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders -->
<div class="admin-card">
    <div class="admin-card-header">
        <div class="admin-card-title">
            <i class="fas fa-clock"></i> সাম্প্রতিক অর্ডার
        </div>
        <a href="<?= SITE_URL ?>/admin/orders" class="btn btn-sm btn-outline-gold">সব দেখুন</a>
    </div>
    <div style="overflow-x: auto;">
        <?php if (!empty($recentOrders)): ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>অর্ডার</th>
                    <th>গ্রাহক</th>
                    <th>মোট</th>
                    <th>স্ট্যাটাস</th>
                    <th>তারিখ</th>
                    <th>অ্যাকশন</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recentOrders as $order): ?>
                <tr>
                    <td style="color:var(--gold);font-weight:700;">#<?= e($order['id']) ?></td>
                    <td><?= e($order['name'] ?? 'অতিথি') ?></td>
                    <td style="color:var(--gold);font-weight:600;">৳<?= number_format($order['total_amount'], 0) ?></td>
                    <td>
                        <?php
                        $cls = match($order['status']) {
                            'delivered','completed' => 'status-completed',
                            'pending'   => 'status-pending',
                            'cancelled' => 'status-cancelled',
                            default     => 'status-processing'
                        };
                        ?>
                        <span class="status-badge <?= $cls ?>"><?= ucfirst($order['status']) ?></span>
                    </td>
                    <td style="color:var(--text-muted);"><?= date('d M, h:i A', strtotime($order['created_at'])) ?></td>
                    <td>
                        <a href="<?= SITE_URL ?>/admin/order/<?= $order['id'] ?>" class="btn action-btn-sm btn-edit">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <div class="admin-empty"><i class="fas fa-inbox"></i><p>কোনো অর্ডার নেই</p></div>
        <?php endif; ?>
    </div>
</div>

<!-- Quick Actions -->
<div class="admin-card" style="margin-top:20px;">
    <div class="admin-card-header">
        <div class="admin-card-title"><i class="fas fa-bolt"></i> দ্রুত অ্যাক্সেস</div>
    </div>
    <div class="quick-actions-grid">
        <a href="<?= SITE_URL ?>/admin/addProduct" class="quick-action-card">
            <i class="fas fa-plus-circle"></i>
            <span>নতুন পণ্য যোগ</span>
        </a>
        <a href="<?= SITE_URL ?>/admin/products" class="quick-action-card">
            <i class="fas fa-glasses"></i>
            <span>সব পণ্য</span>
        </a>
        <a href="<?= SITE_URL ?>/admin/orders" class="quick-action-card">
            <i class="fas fa-receipt"></i>
            <span>অর্ডার দেখুন</span>
        </a>
        <a href="<?= SITE_URL ?>/admin/users" class="quick-action-card">
            <i class="fas fa-users"></i>
            <span>ব্যবহারকারী</span>
        </a>
    </div>
</div>

<script>const SITE_URL = '<?= SITE_URL ?>';</script>