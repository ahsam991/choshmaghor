<div class="product-card" data-id="<?= $product['id'] ?>" data-name="<?= e($product['name']) ?>" data-price="<?= $product['discount_price'] > 0 ? $product['discount_price'] : $product['price'] ?>" data-category="<?= $product['category_id'] ?? '' ?>">
    <div class="product-img-wrap">
        <?php if ($product['discount_price'] > 0): ?>
        <div class="product-badges">
            <span class="badge badge-red"><?= round((1 - $product['discount_price'] / $product['price']) * 100) ?>% OFF</span>
        </div>
        <?php endif; ?>
        
        <button class="wishlist-btn" onclick="toggleWishlist(this, '<?= $product['id'] ?>', '<?= e($product['name']) ?>')" data-id="<?= $product['id'] ?>">
            <i class="far fa-heart"></i>
        </button>

        <a href="<?= SITE_URL ?>/shop/product/<?= e($product['slug'] ?? $product['id']) ?>">
            <img src="<?= asset('images/products/' . ($product['image'] ?? 'placeholder.png')) ?>" alt="<?= e($product['name']) ?>" loading="lazy" onerror="this.src='<?= asset('images/placeholder.png') ?>'">
        </a>

        <div class="product-overlay">
            <button class="overlay-btn" onclick="addToCart('<?= $product['id'] ?>', '<?= e($product['name']) ?>', '<?= $product['discount_price'] > 0 ? $product['discount_price'] : $product['price'] ?>', '<?= asset('images/products/' . ($product['image'] ?? 'placeholder.png')) ?>', '<?= e($product['brand'] ?? 'ChoshmaZone') ?>')">
                <i class="fas fa-shopping-cart me-2"></i><?= __('add_to_cart') ?>
            </button>
        </div>
    </div>

    <div class="product-info">
        <div class="product-brand"><?= e($product['brand'] ?? 'Premium Collection') ?></div>
        <h3 class="product-name">
            <a href="<?= SITE_URL ?>/shop/product/<?= e($product['slug'] ?? $product['id']) ?>"><?= e($product['name']) ?></a>
        </h3>
        
        <div class="product-price">
            <?php if ($product['discount_price'] > 0): ?>
            <span class="price-current"><?= formatPrice($product['discount_price']) ?></span>
            <span class="price-old"><?= formatPrice($product['price']) ?></span>
            <?php else: ?>
            <span class="price-current"><?= formatPrice($product['price']) ?></span>
            <?php endif; ?>
        </div>

        <div class="product-footer">
            <div class="product-stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
            </div>
            <button class="add-cart-btn" onclick="addToCart('<?= $product['id'] ?>', '<?= e($product['name']) ?>', '<?= $product['discount_price'] > 0 ? $product['discount_price'] : $product['price'] ?>', '<?= asset('images/products/' . ($product['image'] ?? 'placeholder.png')) ?>', '<?= e($product['brand'] ?? 'ChoshmaZone') ?>')">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>
</div>