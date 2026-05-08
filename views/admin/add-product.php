<div class="admin-page-header">
    <div>
        <h1 class="admin-page-title"><i class="fas fa-plus-circle"></i> Add New Product</h1>
        <p class="admin-page-sub">Fill in the details below to add a new product to the catalog.</p>
    </div>
    <a href="<?= SITE_URL ?>/admin/products" class="btn btn-dark">
        <i class="fas fa-arrow-left me-2"></i> Back to Products
    </a>
</div>

<?php if (!empty($error)): ?>
<div class="alert alert-error mb-4"><i class="fas fa-exclamation-circle me-2"></i><?= e($error) ?></div>
<?php endif; ?>

<form method="POST" action="<?= SITE_URL ?>/admin/addProduct" class="admin-form" enctype="multipart/form-data">
    <div class="product-form-layout">
        <!-- Left: Main Info -->
        <div>
            <div class="admin-card">
                <div class="admin-card-header">
                    <div class="admin-card-title"><i class="fas fa-info-circle"></i> Basic Information</div>
                </div>

                <div class="admin-form-group">
                    <label class="admin-form-label">Product Name <span style="color:var(--red)">*</span></label>
                    <input type="text" name="name" class="admin-form-control" placeholder="Enter product name" value="<?= e($_POST['name'] ?? '') ?>" required>
                </div>

                <div class="admin-form-group">
                    <label class="admin-form-label">Category</label>
                    <select name="category_id" class="admin-form-control">
                        <option value="">-- Select Category --</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= (isset($_POST['category_id']) && $_POST['category_id'] == $cat['id']) ? 'selected' : '' ?>>
                                <?= e($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="admin-form-group">
                    <label class="admin-form-label">Description</label>
                    <textarea name="description" class="admin-form-control" rows="5" placeholder="Enter detailed product description..."><?= e($_POST['description'] ?? '') ?></textarea>
                </div>

                <div class="product-form-row-3">
                    <div class="admin-form-group">
                        <label class="admin-form-label">Base Price (৳) <span style="color:var(--red)">*</span></label>
                        <input type="number" name="price" class="admin-form-control" placeholder="0" min="0" step="1" value="<?= e($_POST['price'] ?? '') ?>" required>
                    </div>
                    <div class="admin-form-group">
                        <label class="admin-form-label">Discount Price (৳)</label>
                        <input type="number" name="discount_price" class="admin-form-control" placeholder="0" min="0" step="1" value="<?= e($_POST['discount_price'] ?? '') ?>">
                    </div>
                    <div class="admin-form-group">
                        <label class="admin-form-label">Stock Quantity</label>
                        <input type="number" name="stock_quantity" class="admin-form-control" placeholder="0" min="0" value="<?= e($_POST['stock_quantity'] ?? 0) ?>">
                    </div>
                </div>

                <div class="admin-form-group">
                    <label class="admin-featured-toggle">
                        <input type="checkbox" name="is_featured" style="accent-color:var(--gold);width:18px;height:18px;" <?= isset($_POST['is_featured']) ? 'checked' : '' ?>>
                        <span class="ms-2" style="font-weight:600;color:var(--text);">⭐ Mark as Featured Product</span>
                    </label>
                </div>
            </div>

            <!-- Actions -->
            <div class="d-flex gap-3 mt-4">
                <button type="submit" class="btn btn-gold btn-lg shadow-gold">
                    <i class="fas fa-save me-2"></i> Save Product
                </button>
                <a href="<?= SITE_URL ?>/admin/products" class="btn btn-dark btn-lg">
                    <i class="fas fa-times me-2"></i> Cancel
                </a>
            </div>
        </div>

        <!-- Right: Image Upload -->
        <div class="admin-card">
            <div class="admin-card-header">
                <div class="admin-card-title"><i class="fas fa-image"></i> Product Media</div>
            </div>
            <div class="admin-form-group">
                <div class="admin-file-upload" onclick="document.getElementById('product-image').click()">
                    <i class="fas fa-cloud-upload-alt fa-2x mb-3" style="color: var(--gold);"></i>
                    <p class="text-white mb-1 fw-semibold">Click to select image</p>
                    <p class="text-muted small">Supports PNG, JPG, WebP (Max 5MB)</p>
                </div>
                <input type="file" name="image" id="product-image" style="display:none;" accept="image/*">
                <div id="image-preview" class="mt-3 text-center"></div>
            </div>
        </div>
    </div>
</form>

<script>const SITE_URL = '<?= SITE_URL ?>';</script>
