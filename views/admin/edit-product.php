<div class="page-header">
    <div class="container">
        <h1><i class="fas fa-edit"></i> পণ্য সম্পাদনা করুন</h1>
    </div>
</div>

<div class="container" style="padding: 20px 0;">
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger" style="background: rgba(224, 84, 84, 0.15); color: var(--red); padding: 16px; border-radius: 8px; margin-bottom: 24px; border: 1px solid rgba(224, 84, 84, 0.3);">
            <i class="fas fa-exclamation-circle me-2"></i> <?= e($error) ?>
        </div>
    <?php endif; ?>
    
    <form method="POST" action="<?= SITE_URL ?>/admin/editProduct/<?= $product['id'] ?>" class="admin-form" enctype="multipart/form-data">
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="admin-card-title"><i class="fas fa-info-circle"></i> পণ্যের তথ্য</h3>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <!-- Product Name -->
                <div class="admin-form-group">
                    <label class="admin-form-label">পণ্যের নাম <span style="color: var(--red);">*</span></label>
                    <input type="text" name="name" class="admin-form-control" value="<?= e($product['name']) ?>" required>
                </div>
                
                <!-- Category -->
                <div class="admin-form-group">
                    <label class="admin-form-label">ক্যাটাগরি</label>
                    <select name="category_id" class="admin-form-control">
                        <option value="">ক্যাটাগরি নির্বাচন করুন</option>
                        <option value="1" <?= ($product['category_id'] ?? '') == 1 ? 'selected' : '' ?>>পুরুষদের চশমা</option>
                        <option value="2" <?= ($product['category_id'] ?? '') == 2 ? 'selected' : '' ?>>মহিলাদের চশমা</option>
                        <option value="3" <?= ($product['category_id'] ?? '') == 3 ? 'selected' : '' ?>>ইউনিসেক্স</option>
                    </select>
                </div>
            </div>
            
            <!-- Description -->
            <div class="admin-form-group">
                <label class="admin-form-label">বর্ণনা</label>
                <textarea name="description" class="admin-form-control" rows="4"><?= e($product['description'] ?? '') ?></textarea>
            </div>
            
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
                <!-- Price -->
                <div class="admin-form-group">
                    <label class="admin-form-label">মূল্য (৳) <span style="color: var(--red);">*</span></label>
                    <input type="number" name="price" class="admin-form-control" value="<?= e($product['price']) ?>" min="0" step="0.01" required>
                </div>
                
                <!-- Discount Price -->
                <div class="admin-form-group">
                    <label class="admin-form-label">ডিসকাউন্ট মূল্য (৳)</label>
                    <input type="number" name="discount_price" class="admin-form-control" value="<?= e($product['discount_price'] ?? 0) ?>" min="0" step="0.01">
                </div>
                
                <!-- Stock Quantity -->
                <div class="admin-form-group">
                    <label class="admin-form-label">স্টক পরিমাণ</label>
                    <input type="number" name="stock_quantity" class="admin-form-control" value="<?= e($product['stock_quantity'] ?? 0) ?>" min="0">
                </div>
            </div>
            
            <!-- Featured Checkbox -->
            <div class="admin-form-group">
                <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                    <input type="checkbox" name="is_featured" <?= $product['is_featured'] ? 'checked' : '' ?> style="width: 18px; height: 18px;">
                    <span style="color: var(--text); font-weight: 600;">ফিচার্ড পণ্য হিসেবে চিহ্নিত করুন</span>
                </label>
            </div>
        </div>
        
        <!-- Image Upload -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="admin-card-title"><i class="fas fa-image"></i> পণ্যের ছবি</h3>
            </div>
            
            <div class="admin-form-group">
                <label class="admin-form-label">বর্তমান ছবি</label>
                <?php if (!empty($product['image_url'])): ?>
                    <img src="<?= e($product['image_url']) ?>" alt="<?= e($product['name']) ?>" style="max-width: 200px; border-radius: 8px; margin-bottom: 16px;">
                <?php else: ?>
                    <div style="width: 200px; height: 200px; background: var(--dark-3); border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                        <i class="fas fa-image" style="font-size: 3rem; color: var(--text-muted);"></i>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="admin-form-group">
                <label class="admin-form-label">নতুন ছবি আপলোড করুন (ঐচ্ছিক)</label>
                <div class="admin-file-upload" onclick="document.getElementById('product-image').click()">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <p style="color: var(--text); margin-top: 12px;">ফাইল সিলেক্ট করতে ক্লিক করুন অথবা ড্র্যাগ করে ফেলুন</p>
                    <p style="color: var(--text-muted); font-size: 0.85rem; margin-top: 8px;">PNG, JPG, WebP (সর্বোচ্চ 5MB)</p>
                </div>
                <input type="file" name="image" id="product-image" class="admin-form-control" style="display: none;" accept="image/*">
                <div id="image-preview" style="margin-top: 16px;"></div>
            </div>
        </div>
        
        <!-- Submit Buttons -->
        <div style="display: flex; gap: 16px; margin-top: 24px;">
            <button type="submit" class="btn btn-gold btn-lg">
                <i class="fas fa-save"></i> পরিবর্তন সংরক্ষণ করুন
            </button>
            <a href="<?= SITE_URL ?>/admin/products" class="btn btn-dark btn-lg">
                <i class="fas fa-arrow-left"></i> ফিরে যান
            </a>
        </div>
    </form>
</div>

<script>
const SITE_URL = '<?= SITE_URL ?>';
</script>
