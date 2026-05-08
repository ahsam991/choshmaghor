<div class="admin-page-header">
    <div>
        <h1 class="admin-page-title"><i class="fas fa-edit"></i> পণ্য সম্পাদনা</h1>
        <p class="admin-page-sub">#<?= e($product['id']) ?> — <?= e($product['name']) ?></p>
    </div>
    <a href="<?= SITE_URL ?>/admin/products" class="btn btn-dark">
        <i class="fas fa-arrow-left"></i> পণ্যের তালিকা
    </a>
</div>

<?php if (!empty($error)): ?>
<div class="alert alert-error mb-4"><i class="fas fa-exclamation-circle me-2"></i><?= e($error) ?></div>
<?php endif; ?>

<form method="POST" action="<?= SITE_URL ?>/admin/editProduct/<?= $product['id'] ?>" class="admin-form" enctype="multipart/form-data">
    <div class="product-form-layout">

        <!-- Left: Main Info -->
        <div>
            <div class="admin-card">
                <div class="admin-card-header">
                    <div class="admin-card-title"><i class="fas fa-info-circle"></i> পণ্যের তথ্য</div>
                </div>

                <div class="admin-form-group">
                    <label class="admin-form-label">পণ্যের নাম <span style="color:var(--red)">*</span></label>
                    <input type="text" name="name" class="admin-form-control" value="<?= e($product['name']) ?>" required>
                </div>

                <div class="admin-form-group">
                    <label class="admin-form-label">ক্যাটাগরি</label>
                    <select name="category_id" class="admin-form-control">
                        <option value="">-- ক্যাটাগরি নির্বাচন করুন --</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= ($product['category_id'] ?? '') == $cat['id'] ? 'selected' : '' ?>>
                                <?= e($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="admin-form-group">
                    <label class="admin-form-label">বর্ণনা</label>
                    <textarea name="description" class="admin-form-control" rows="5"><?= e($product['description'] ?? '') ?></textarea>
                </div>

                <div class="product-form-row-3">
                    <div class="admin-form-group">
                        <label class="admin-form-label">মূল্য (৳) <span style="color:var(--red)">*</span></label>
                        <input type="number" name="price" class="admin-form-control" value="<?= e($product['price']) ?>" min="0" step="1" required>
                    </div>
                    <div class="admin-form-group">
                        <label class="admin-form-label">ডিসকাউন্ট মূল্য (৳)</label>
                        <input type="number" name="discount_price" class="admin-form-control" value="<?= e($product['discount_price'] ?? 0) ?>" min="0" step="1">
                    </div>
                    <div class="admin-form-group">
                        <label class="admin-form-label">স্টক</label>
                        <input type="number" name="stock_quantity" class="admin-form-control" value="<?= e($product['stock_quantity'] ?? 0) ?>" min="0">
                    </div>
                </div>

                <div class="admin-form-group">
                    <label class="admin-featured-toggle">
                        <input type="checkbox" name="is_featured" style="accent-color:var(--gold);width:18px;height:18px;" <?= $product['is_featured'] ? 'checked' : '' ?>>
                        <span style="font-weight:600;">⭐ ফিচার্ড পণ্য হিসেবে চিহ্নিত করুন</span>
                    </label>
                </div>
            </div>

            <div style="display:flex;gap:12px;margin-top:16px;">
                <button type="submit" class="btn btn-gold btn-lg">
                    <i class="fas fa-save"></i> পরিবর্তন সংরক্ষণ করুন
                </button>
                <a href="<?= SITE_URL ?>/admin/products" class="btn btn-dark btn-lg">
                    <i class="fas fa-times"></i> বাতিল
                </a>
            </div>
        </div>

        <!-- Right: Image -->
        <div class="admin-card">
            <div class="admin-card-header">
                <div class="admin-card-title"><i class="fas fa-image"></i> পণ্যের ছবি</div>
            </div>

            <?php if (!empty($product['image_url'])): ?>
                <div style="margin-bottom:16px;text-align:center;">
                    <img src="<?= e($product['image_url']) ?>" alt="<?= e($product['name']) ?>"
                         style="max-width:100%;max-height:200px;border-radius:10px;border:1px solid var(--border-dim);object-fit:cover;">
                    <p style="color:var(--text-muted);font-size:0.8rem;margin-top:8px;">বর্তমান ছবি</p>
                </div>
            <?php endif; ?>

            <div class="admin-form-group">
                <div class="admin-file-upload" onclick="document.getElementById('product-image').click()">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <p style="color:var(--text);margin-top:10px;font-size:0.9rem;"><?= !empty($product['image_url']) ? 'নতুন ছবি দিয়ে বদলান' : 'ছবি আপলোড করুন' ?></p>
                    <p style="color:var(--text-muted);font-size:0.8rem;margin-top:4px;">PNG, JPG, WebP (সর্বোচ্চ 5MB)</p>
                </div>
                <input type="file" name="image" id="product-image" style="display:none;" accept="image/*">
                <div id="image-preview" style="margin-top:12px;text-align:center;"></div>
            </div>
        </div>
    </div>
</form>

<script>const SITE_URL = '<?= SITE_URL ?>';</script>
