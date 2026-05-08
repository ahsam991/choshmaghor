<div class="admin-page-header">
    <div>
        <h1 class="admin-page-title"><i class="fas fa-shopping-cart"></i> অর্ডার পরিচালনা</h1>
        <p class="admin-page-sub">সব অর্ডার দেখুন ও স্ট্যাটাস আপডেট করুন</p>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <div class="admin-card-title"><i class="fas fa-list"></i> সব অর্ডার (<?= count($orders ?? []) ?>)</div>
    </div>
    <div style="overflow-x:auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>অর্ডার</th>
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
                        <td style="color:var(--gold);font-weight:700;">#<?= e($order['id']) ?></td>
                        <td style="font-weight:600;"><?= e($order['name'] ?? 'অতিথি') ?></td>
                        <td style="color:var(--text-muted);"><?= e($order['email'] ?? 'N/A') ?></td>
                        <td style="color:var(--gold);font-weight:700;">৳<?= number_format($order['total_amount'], 0) ?></td>
                        <td>
                            <select class="order-status-select" data-order-id="<?= $order['id'] ?>" style="background:var(--dark-3);border:1px solid var(--border-dim);color:var(--text);padding:6px 10px;border-radius:6px;font-size:0.82rem;cursor:pointer;">
                                <?php foreach (['pending'=>'Pending','processing'=>'Processing','confirmed'=>'Confirmed','shipped'=>'Shipped','delivered'=>'Delivered','cancelled'=>'Cancelled'] as $val => $label): ?>
                                    <option value="<?= $val ?>" <?= $order['status'] === $val ? 'selected' : '' ?>><?= $label ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td style="color:var(--text-muted);font-size:0.85rem;"><?= date('d M Y, h:i A', strtotime($order['created_at'])) ?></td>
                        <td>
                            <a href="<?= SITE_URL ?>/admin/order/<?= $order['id'] ?>" class="btn action-btn-sm btn-edit" title="বিস্তারিত দেখুন">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="7">
                        <div class="admin-empty"><i class="fas fa-inbox"></i><p>কোনো অর্ডার নেই।</p></div>
                    </td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>const SITE_URL = '<?= SITE_URL ?>';</script>
