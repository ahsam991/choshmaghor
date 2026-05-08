<!-- Products Header -->
<div class="admin-page-header">
    <div>
        <h1 class="admin-page-title"><i class="fas fa-glasses"></i> পণ্য পরিচালনা</h1>
        <p class="admin-page-sub">সব পণ্য দেখুন, সম্পাদনা করুন বা মুছুন</p>
    </div>
    <a href="<?= SITE_URL ?>/admin/add-product" class="btn btn-gold">
        <i class="fas fa-plus"></i> নতুন পণ্য যোগ করুন
    </a>
</div>

<?php if (isset($_GET['success'])): ?>
<div class="alert alert-success mb-4"><i class="fas fa-check-circle me-2"></i> সফলভাবে সম্পন্ন হয়েছে!</div>
<?php endif; ?>

<?php if (isset($_SESSION['success_message'])): ?>
<div class="alert alert-success mb-4"><i class="fas fa-check-circle me-2"></i><?= e($_SESSION['success_message']) ?></div>
<?php unset($_SESSION['success_message']); endif; ?>

<div class="admin-card">
    <div class="admin-card-header">
        <div class="admin-card-title"><i class="fas fa-list"></i> সব পণ্য (<?= count($products ?? []) ?>)</div>
    </div>
    <div style="overflow-x: auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ছবি</th>
                    <th>পণ্যের নাম</th>
                    <th>ক্যাটাগরি</th>
                    <th>মূল্য</th>
                    <th>স্টক</th>
                    <th>স্ট্যাটাস</th>
                    <th>অ্যাকশন</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                    <tr>
                        <td style="color:var(--gold);font-weight:700;">#<?= e($product['id']) ?></td>
                        <td>
                            <?php if (!empty($product['image_url'])): ?>
                                <img src="<?= e($product['image_url']) ?>" alt="<?= e($product['name']) ?>" style="width:50px;height:50px;object-fit:cover;border-radius:8px;border:1px solid var(--border-dim);">
                            <?php else: ?>
                                <div style="width:50px;height:50px;background:var(--dark-3);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                                    <i class="fas fa-image" style="color:var(--text-muted);"></i>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td style="font-weight:600;color:var(--white);"><?= e($product['name']) ?></td>
                        <td style="color:var(--text-muted);"><?= e($product['category_name'] ?? 'N/A') ?></td>
                        <td>
                            <span style="color:var(--gold);font-weight:700;">৳<?= number_format($product['price'], 0) ?></span>
                            <?php if (!empty($product['discount_price']) && $product['discount_price'] < $product['price']): ?>
                                <br><small style="color:var(--text-muted);text-decoration:line-through;">৳<?= number_format($product['price'], 0) ?></small>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span style="color:<?= $product['stock_quantity'] > 0 ? 'var(--green)' : 'var(--red)' ?>;font-weight:600;">
                                <?= $product['stock_quantity'] ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($product['is_featured']): ?>
                                <span class="badge badge-gold"><i class="fas fa-star me-1"></i>Featured</span>
                            <?php else: ?>
                                <span class="badge" style="background:var(--border-dim);color:var(--text-muted);">Regular</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div style="display:flex;gap:6px;">
                                <a href="<?= SITE_URL ?>/admin/editProduct/<?= $product['id'] ?>" class="btn action-btn-sm btn-edit" title="সম্পাদনা">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn action-btn-sm btn-delete btn-delete-product"
                                    data-id="<?= $product['id'] ?>"
                                    data-name="<?= e($product['name']) ?>"
                                    title="মুছুন">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">
                            <div class="admin-empty">
                                <i class="fas fa-box-open"></i>
                                <p>কোনো পণ্য পাওয়া যায়নি।</p>
                                <a href="<?= SITE_URL ?>/admin/addProduct" class="btn btn-gold" style="margin-top:12px;">নতুন পণ্য যোগ করুন</a>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>const SITE_URL = '<?= SITE_URL ?>';</script>
