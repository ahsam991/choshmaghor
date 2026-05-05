<div class="page-header">
    <div class="container">
        <h1>অ্যাডমিন ড্যাশবোর্ড</h1>
    </div>
</div>

<div class="container" style="padding: 40px 0;">
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 40px;">
        <!-- Products Card -->
        <div style="background: var(--dark-2); border: 1px solid var(--border-dim); border-radius: var(--radius-lg); padding: 24px; text-align: center;">
            <div style="font-size: 2.4rem; color: var(--gold); margin-bottom: 10px;">📦</div>
            <div style="color: var(--text-muted); font-size: 0.85rem;">মোট পণ্য</div>
            <div style="font-size: 1.8rem; font-weight: 700; color: var(--white);"><?= isset($productCount) ? $productCount : 0 ?></div>
            <a href="<?= SITE_URL ?>/admin/products" style="color: var(--gold); font-size: 0.8rem; text-decoration: none; margin-top: 8px; display: inline-block;">পণ্য পরিচালনা →</a>
        </div>
        
        <!-- Orders Card -->
        <div style="background: var(--dark-2); border: 1px solid var(--border-dim); border-radius: var(--radius-lg); padding: 24px; text-align: center;">
            <div style="font-size: 2.4rem; color: var(--gold); margin-bottom: 10px;">🛒</div>
            <div style="color: var(--text-muted); font-size: 0.85rem;">মোট অর্ডার</div>
            <div style="font-size: 1.8rem; font-weight: 700; color: var(--white);"><?= isset($orderCount) ? $orderCount : 0 ?></div>
            <a href="<?= SITE_URL ?>/admin/orders" style="color: var(--gold); font-size: 0.8rem; text-decoration: none; margin-top: 8px; display: inline-block;">অর্ডার পরিচালনা →</a>
        </div>
        
        <!-- Users Card -->
        <div style="background: var(--dark-2); border: 1px solid var(--border-dim); border-radius: var(--radius-lg); padding: 24px; text-align: center;">
            <div style="font-size: 2.4rem; color: var(--gold); margin-bottom: 10px;">👥</div>
            <div style="color: var(--text-muted); font-size: 0.85rem;">মোট ব্যবহারকারী</div>
            <div style="font-size: 1.8rem; font-weight: 700; color: var(--white);"><?= isset($userCount) ? $userCount : 0 ?></div>
            <a href="<?= SITE_URL ?>/admin/users" style="color: var(--gold); font-size: 0.8rem; text-decoration: none; margin-top: 8px; display: inline-block;">ব্যবহারকারী পরিচালনা →</a>
        </div>
        
        <!-- Revenue Card -->
        <div style="background: var(--dark-2); border: 1px solid var(--border-dim); border-radius: var(--radius-lg); padding: 24px; text-align: center;">
            <div style="font-size: 2.4rem; color: var(--gold); margin-bottom: 10px;">💰</div>
            <div style="color: var(--text-muted); font-size: 0.85rem;">মোট রাজস্ব</div>
            <div style="font-size: 1.8rem; font-weight: 700; color: var(--gold);">৳<?= isset($revenue) ? number_format($revenue, 0) : 0 ?></div>
        </div>
    </div>
    
    <!-- Recent Orders Section -->
    <?php if (!empty($recentOrders)): ?>
    <div style="background: var(--dark-2); border: 1px solid var(--border-dim); border-radius: var(--radius-lg); padding: 28px;">
        <h3 style="margin-bottom: 20px; display: flex; align-items: center; gap: 12px;">
            <i class="fas fa-list"></i> সাম্প্রতিক অর্ডার
        </h3>
        
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 1px solid var(--border-dim);">
                        <th style="text-align: left; padding: 12px; color: var(--text-muted); font-weight: 600; font-size: 0.85rem;">অর্ডার আইডি</th>
                        <th style="text-align: left; padding: 12px; color: var(--text-muted); font-weight: 600; font-size: 0.85rem;">গ্রাহক</th>
                        <th style="text-align: left; padding: 12px; color: var(--text-muted); font-weight: 600; font-size: 0.85rem;">মোট</th>
                        <th style="text-align: left; padding: 12px; color: var(--text-muted); font-weight: 600; font-size: 0.85rem;">স্ট্যাটাস</th>
                        <th style="text-align: left; padding: 12px; color: var(--text-muted); font-weight: 600; font-size: 0.85rem;">তারিখ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentOrders as $order): ?>
                    <tr style="border-bottom: 1px solid var(--border-dim);">
                        <td style="padding: 12px; color: var(--gold); font-weight: 600;">#<?= e($order['id']) ?></td>
                        <td style="padding: 12px; color: var(--white);"><?= e($order['name'] ?? 'অতিথি') ?></td>
                        <td style="padding: 12px; color: var(--white);">৳<?= number_format($order['total_amount'], 0) ?></td>
                        <td style="padding: 12px;">
                            <span style="background: <?= $order['status'] === 'completed' ? 'var(--gold)' : 'var(--border-dim)' ?>; color: var(--black); padding: 4px 8px; border-radius: 4px; font-size: 0.8rem; font-weight: 600;">
                                <?= ucfirst($order['status']) ?>
                            </span>
                        </td>
                        <td style="padding: 12px; color: var(--text-muted);"><?= date('d M Y', strtotime($order['created_at'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Quick Actions -->
    <div style="background: var(--dark-2); border: 1px solid var(--border-dim); border-radius: var(--radius-lg); padding: 28px; margin-top: 20px;">
        <h3 style="margin-bottom: 20px; display: flex; align-items: center; gap: 12px;">
            <i class="fas fa-cogs"></i> দ্রুত অ্যাক্সেস
        </h3>
        
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px;">
            <a href="<?= SITE_URL ?>/admin/products" class="btn btn-gold btn-full">
                <i class="fas fa-boxes"></i> পণ্য পরিচালনা
            </a>
            <a href="<?= SITE_URL ?>/admin/orders" class="btn btn-gold btn-full">
                <i class="fas fa-receipt"></i> অর্ডার পরিচালনা
            </a>
            <a href="<?= SITE_URL ?>/admin/users" class="btn btn-gold btn-full">
                <i class="fas fa-users"></i> ব্যবহারকারী পরিচালনা
            </a>
        </div>
    </div>
</div>
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
            <a href="<?= SITE_URL ?>/admin" class="nav-item <?= isActive('admin') && !isset($_GET['url']) || (isset($_GET['url']) && $_GET['url'] === 'admin') ? 'active' : '' ?>">
                <i class="fas fa-tachometer-alt"></i> ড্যাশবোর্ড
            </a>
            <div class="nav-section">পণ্য</div>
            <a href="<?= SITE_URL ?>/admin/products" class="nav-item">
                <i class="fas fa-glasses"></i> সব পণ্য
            </a>
            <a href="<?= SITE_URL ?>/admin/addProduct" class="nav-item">
                <i class="fas fa-plus-circle"></i> নতুন পণ্য
            </a>
            <a href="<?= SITE_URL ?>/admin/categories" class="nav-item">
                <i class="fas fa-tags"></i> ক্যাটাগরি
            </a>
            <div class="nav-section">বিক্রয়</div>
            <a href="<?= SITE_URL ?>/admin/orders" class="nav-item">
                <i class="fas fa-shopping-cart"></i> অর্ডার
            </a>
            <a href="<?= SITE_URL ?>/admin/users" class="nav-item">
                <i class="fas fa-users"></i> ব্যবহারকারী
            </a>
            <div class="nav-section">সেটিংস</div>
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