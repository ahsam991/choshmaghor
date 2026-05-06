<div class="page-header">
    <div class="container">
        <h1><i class="fas fa-shopping-cart"></i> অর্ডার পরিচালনা</h1>
    </div>
</div>

<div class="container" style="padding: 20px 0;">
    <!-- Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <h2 style="color: var(--white); font-size: 1.4rem;">সব অর্ডার</h2>
    </div>
    
    <!-- Orders Table -->
    <div class="admin-card">
        <div style="overflow-x: auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>অর্ডার আইডি</th>
                        <th>গ্রাহক</th>
                        <th>ইমেইল</th>
                        <th>মোট</th>
                        <th>স্ট্যাটাস</th>
                        <th>তারিখ</th>
                        <th>অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($orders)): ?>
                        <?php foreach ($orders as $order): ?>
                        <tr>
                            <td style="color: var(--gold); font-weight: 600;">#<?= e($order['id']) ?></td>
                            <td style="font-weight: 600; color: var(--white);"><?= e($order['name'] ?? 'অতিথি') ?></td>
                            <td style="color: var(--text-muted);"><?= e($order['email'] ?? 'N/A') ?></td>
                            <td style="color: var(--gold); font-weight: 600;">৳<?= number_format($order['total_amount'], 0) ?></td>
                            <td>
                                <select class="admin-form-control order-status-select" data-order-id="<?= $order['id'] ?>" style="width: auto; padding: 6px 12px; font-size: 0.85rem;">
                                    <option value="pending" <?= $order['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                                    <option value="processing" <?= $order['status'] === 'processing' ? 'selected' : '' ?>>Processing</option>
                                    <option value="completed" <?= $order['status'] === 'completed' ? 'selected' : '' ?>>Completed</option>
                                    <option value="cancelled" <?= $order['status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                </select>
                            </td>
                            <td style="color: var(--text-muted);"><?= date('d M Y, h:i A', strtotime($order['created_at'])) ?></td>
                            <td>
                                <a href="<?= SITE_URL ?>/admin/order/<?= $order['id'] ?>" class="btn btn-edit action-btn-sm">
                                    <i class="fas fa-eye"></i> দেখুন
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 40px; color: var(--text-muted);">
                                <i class="fas fa-inbox" style="font-size: 3rem; margin-bottom: 16px; display: block;"></i>
                                কোনো অর্ডার পাওয়া যায়নি।
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
const SITE_URL = '<?= SITE_URL ?>';
</script>
