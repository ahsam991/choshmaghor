<div class="page-header">
    <div class="container">
        <h1><i class="fas fa-glasses"></i> পণ্য পরিচালনা</h1>
    </div>
</div>

<div class="container" style="padding: 20px 0;">
    <!-- Flash Messages -->
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success" style="background: rgba(76, 175, 80, 0.15); color: #4caf50; padding: 16px; border-radius: 8px; margin-bottom: 24px; border: 1px solid rgba(76, 175, 80, 0.3);">
            <i class="fas fa-check-circle me-2"></i> সফলভাবে সম্পন্ন হয়েছে!
        </div>
    <?php endif; ?>
    
    <!-- Header Actions -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <h2 style="color: var(--white); font-size: 1.4rem;">সব পণ্য</h2>
        <a href="<?= SITE_URL ?>/admin/addProduct" class="btn btn-gold">
            <i class="fas fa-plus-circle"></i> নতুন পণ্য যোগ করুন
        </a>
    </div>
    
    <!-- Products Table -->
    <div class="admin-card">
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
                            <td style="color: var(--gold);">#<?= e($product['id']) ?></td>
                            <td>
                                <?php if (!empty($product['image_url'])): ?>
                                    <img src="<?= e($product['image_url']) ?>" alt="<?= e($product['name']) ?>" style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px;">
                                <?php else: ?>
                                    <div style="width: 50px; height: 50px; background: var(--dark-3); border-radius: 6px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-image" style="color: var(--text-muted);"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td style="font-weight: 600; color: var(--white);"><?= e($product['name']) ?></td>
                            <td style="color: var(--text-muted);"><?= e($product['category_name'] ?? 'N/A') ?></td>
                            <td style="color: var(--gold); font-weight: 600;">
                                ৳<?= number_format($product['price'], 0) ?>
                                <?php if (!empty($product['discount_price']) && $product['discount_price'] < $product['price']): ?>
                                    <br><small style="color: var(--text-muted); text-decoration: line-through;">৳<?= number_format($product['price'], 0) ?></small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span style="color: <?= $product['stock_quantity'] > 0 ? 'var(--green)' : 'var(--red)' ?>;">
                                    <?= $product['stock_quantity'] ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($product['is_featured']): ?>
                                    <span class="badge badge-gold">Featured</span>
                                <?php else: ?>
                                    <span class="badge" style="background: var(--border-dim); color: var(--text-muted);">Regular</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div style="display: flex; gap: 8px;">
                                    <a href="<?= SITE_URL ?>/admin/editProduct/<?= $product['id'] ?>" class="btn btn-edit action-btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-delete action-btn-sm btn-delete-product" data-id="<?= $product['id'] ?>" data-name="<?= e($product['name']) ?>">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" style="text-align: center; padding: 40px; color: var(--text-muted);">
                                <i class="fas fa-box-open" style="font-size: 3rem; margin-bottom: 16px; display: block;"></i>
                                কোনো পণ্য পাওয়া যায়নি। নতুন পণ্য যোগ করুন!
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
