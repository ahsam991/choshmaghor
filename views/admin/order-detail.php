<div class="page-header">
    <div class="container d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-receipt"></i> অর্ডার বিস্তারিত</h1>
        <?php if ($order): ?>
            <a href="<?= SITE_URL ?>/admin/invoice/<?= $order['id'] ?>" class="btn btn-gold" target="_blank">
                <i class="fas fa-print me-2"></i> Print Cash Memo
            </a>
        <?php endif; ?>
    </div>
</div>

<div class="container" style="padding: 20px 0;">
    <?php if (!$order): ?>
        <div class="alert alert-danger" style="background: rgba(224, 84, 84, 0.15); color: var(--red); padding: 16px; border-radius: 8px; margin-bottom: 24px; border: 1px solid rgba(224, 84, 84, 0.3);">
            <i class="fas fa-exclamation-circle me-2"></i> অর্ডার পাওয়া যায়নি।
        </div>
        <a href="<?= SITE_URL ?>/admin/orders" class="btn btn-gold">
            <i class="fas fa-arrow-left"></i> অর্ডারে ফিরে যান
        </a>
    <?php else: ?>
        <!-- Order Info Card -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="admin-card-title"><i class="fas fa-info-circle"></i> অর্ডার তথ্য</h3>
            </div>
            
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
                <div>
                    <div style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 4px;">অর্ডার আইডি</div>
                    <div style="color: var(--gold); font-weight: 700; font-size: 1.2rem;">#<?= e($order['id']) ?></div>
                </div>
                <div>
                    <div style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 4px;">গ্রাহক</div>
                    <div style="color: var(--white); font-weight: 600;"><?= e($order['name'] ?? 'অতিথি') ?></div>
                    <?php if (!empty($order['email'])): ?>
                        <div style="color: var(--text-muted); font-size: 0.85rem;"><?= e($order['email']) ?></div>
                    <?php endif; ?>
                </div>
                <div>
                    <div style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 4px;">তারিখ</div>
                    <div style="color: var(--white);"><?= date('d M Y, h:i A', strtotime($order['created_at'])) ?></div>
                </div>
                <div>
                    <div style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 4px;">মোট মূল্য</div>
                    <div style="color: var(--gold); font-weight: 700; font-size: 1.2rem;">৳<?= number_format($order['total_amount'], 0) ?></div>
                </div>
                <div>
                    <div style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 4px;">স্ট্যাটাস</div>
                    <select class="admin-form-control order-status-select" data-order-id="<?= $order['id'] ?>" style="width: auto; padding: 8px 12px; font-size: 0.9rem;">
                        <option value="pending" <?= $order['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="processing" <?= $order['status'] === 'processing' ? 'selected' : '' ?>>Processing</option>
                        <option value="completed" <?= $order['status'] === 'completed' ? 'selected' : '' ?>>Completed</option>
                        <option value="cancelled" <?= $order['status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                    </select>
                </div>
                <div>
                    <div style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 4px;">শিপিং ঠিকানা</div>
                    <div style="color: var(--white);"><?= nl2br(e($order['shipping_address'] ?? 'N/A')) ?></div>
                </div>
            </div>
        </div>

        <!-- Order Items Card -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="admin-card-title"><i class="fas fa-boxes"></i> অর্ডার আইটেম</h3>
            </div>
            
            <?php if (!empty($items)): ?>
                <div style="overflow-x: auto;">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>পণ্য</th>
                                <th>ছবি</th>
                                <th>মূল্য</th>
                                <th>পরিমাণ</th>
                                <th>মোট</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $item): ?>
                            <tr>
                                <td style="font-weight: 600; color: var(--white);"><?= e($item['name']) ?></td>
                                <td>
                                    <?php if (!empty($item['image_url'])): ?>
                                        <img src="<?= e($item['image_url']) ?>" alt="<?= e($item['name']) ?>" style="width: 60px; height: 60px; object-fit: cover; border-radius: 6px;">
                                    <?php else: ?>
                                        <div style="width: 60px; height: 60px; background: var(--dark-3); border-radius: 6px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-image" style="color: var(--text-muted);"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td style="color: var(--gold);">৳<?= number_format($item['price'], 0) ?></td>
                                <td style="color: var(--white);"><?= $item['quantity'] ?></td>
                                <td style="color: var(--gold); font-weight: 700;">৳<?= number_format($item['price'] * $item['quantity'], 0) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div style="text-align: center; padding: 40px; color: var(--text-muted);">
                    <i class="fas fa-inbox" style="font-size: 3rem; margin-bottom: 16px; display: block;"></i>
                    কোনো আইটেম পাওয়া যায়নি।
                </div>
            <?php endif; ?>
        </div>

        <!-- Back Button -->
        <div style="margin-top: 24px;">
            <a href="<?= SITE_URL ?>/admin/orders" class="btn btn-dark">
                <i class="fas fa-arrow-left"></i> অর্ডারে ফিরে যান
            </a>
        </div>
    <?php endif; ?>
</div>

<script>
const SITE_URL = '<?= SITE_URL ?>';
</script>
