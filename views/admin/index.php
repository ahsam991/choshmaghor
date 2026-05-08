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

<!-- Analytics Charts -->
<div class="admin-charts-grid" style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-top: 20px;">
    <!-- Revenue Chart -->
    <div class="admin-card">
        <div class="admin-card-header">
            <div class="admin-card-title"><i class="fas fa-chart-line"></i> সাপ্তাহিক রাজস্ব (Weekly Revenue)</div>
        </div>
        <div class="admin-card-body" style="padding: 20px;">
            <canvas id="revenueChart" height="100"></canvas>
        </div>
    </div>

    <!-- Order Status Chart -->
    <div class="admin-card">
        <div class="admin-card-header">
            <div class="admin-card-title"><i class="fas fa-chart-pie"></i> অর্ডার স্ট্যাটাস (Order Status)</div>
        </div>
        <div class="admin-card-body" style="padding: 20px; display: flex; justify-content: center;">
            <canvas id="statusChart" height="200" style="max-height: 250px;"></canvas>
        </div>
    </div>
</div>

<!-- Top Products Chart & Server Health -->
<div class="admin-charts-grid" style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-top: 20px;">
    <!-- Top Products Chart -->
    <div class="admin-card">
        <div class="admin-card-header">
            <div class="admin-card-title"><i class="fas fa-star"></i> শীর্ষ বিক্রীত পণ্য (Top Selling Products)</div>
        </div>
        <div class="admin-card-body" style="padding: 20px;">
            <canvas id="topProductsChart" height="150"></canvas>
        </div>
    </div>

    <!-- Server Health -->
    <div class="admin-card">
        <div class="admin-card-header">
            <div class="admin-card-title"><i class="fas fa-server"></i> সিস্টেম হেলথ (System Health)</div>
        </div>
        <div class="admin-card-body" style="padding: 20px;">
            <div class="health-item mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span style="color: var(--text-muted);"><i class="fas fa-microchip me-2"></i> PHP Memory</span>
                    <span style="font-weight: 600;"><?= e($serverHealth['memory_usage']) ?></span>
                </div>
                <div style="background: var(--dark-3); height: 6px; border-radius: 3px; overflow: hidden;">
                    <div style="background: var(--green); height: 100%; width: 45%;"></div>
                </div>
            </div>
            
            <div class="health-item mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span style="color: var(--text-muted);"><i class="fas fa-database me-2"></i> DB Status</span>
                    <?php if ($serverHealth['db_health']['status'] === 'Healthy'): ?>
                        <span class="badge" style="background: rgba(76,175,80,0.2); color: var(--green); padding: 4px 8px; border-radius: 4px;">Healthy</span>
                    <?php else: ?>
                        <span class="badge" style="background: rgba(244,67,54,0.2); color: var(--red); padding: 4px 8px; border-radius: 4px;">Error</span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="health-item mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <span style="color: var(--text-muted);"><i class="fas fa-clock me-2"></i> DB Uptime</span>
                    <span style="font-weight: 600; font-family: monospace;"><?= e($serverHealth['db_health']['uptime']) ?></span>
                </div>
            </div>

            <div class="health-item">
                <div class="d-flex justify-content-between align-items-center">
                    <span style="color: var(--text-muted);"><i class="fas fa-network-wired me-2"></i> DB Threads</span>
                    <span style="font-weight: 600;"><?= e($serverHealth['db_health']['threads_connected']) ?> Active</span>
                </div>
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

<!-- Chart.js Integration -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Parse PHP data
    const weeklyRevenueData = <?= isset($weeklyRevenueData) ? $weeklyRevenueData : '[]' ?>;
    const orderStatusData = <?= isset($orderStatusData) ? $orderStatusData : '[]' ?>;
    const topSellingData = <?= isset($topSellingData) ? $topSellingData : '[]' ?>;

    // --- Weekly Revenue Chart ---
    const revCtx = document.getElementById('revenueChart').getContext('2d');
    const revLabels = weeklyRevenueData.map(item => item.date);
    const revTotals = weeklyRevenueData.map(item => parseFloat(item.daily_total));

    new Chart(revCtx, {
        type: 'line',
        data: {
            labels: revLabels,
            datasets: [{
                label: 'রাজস্ব (Revenue ৳)',
                data: revTotals,
                borderColor: '#c9a84c',
                backgroundColor: 'rgba(201, 168, 76, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // --- Order Status Chart ---
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    
    // Map status colors
    const statusColors = {
        'pending': '#f39c12',
        'processing': '#3498db',
        'completed': '#2ecc71',
        'delivered': '#27ae60',
        'cancelled': '#e74c3c'
    };

    const statLabels = orderStatusData.map(item => item.status.toUpperCase());
    const statCounts = orderStatusData.map(item => parseInt(item.count));
    const statBgColors = orderStatusData.map(item => statusColors[item.status.toLowerCase()] || '#95a5a6');

    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: statLabels,
            datasets: [{
                data: statCounts,
                backgroundColor: statBgColors,
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: { position: 'right' }
            }
        }
    });

    // --- Top Products Chart ---
    const topCtx = document.getElementById('topProductsChart').getContext('2d');
    const topLabels = topSellingData.map(item => item.name);
    const topSold = topSellingData.map(item => parseInt(item.total_sold));

    new Chart(topCtx, {
        type: 'bar',
        data: {
            labels: topLabels,
            datasets: [{
                label: 'বিক্রিত পরিমাণ (Total Sold)',
                data: topSold,
                backgroundColor: 'rgba(201, 168, 76, 0.8)',
                borderColor: '#c9a84c',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } },
                x: {
                    ticks: {
                        callback: function(value) {
                            let lbl = this.getLabelForValue(value);
                            return lbl.length > 20 ? lbl.substring(0, 20) + '...' : lbl;
                        }
                    }
                }
            }
        }
    });
});
</script>