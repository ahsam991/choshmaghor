<div class="page-header">
    <div class="container">
        <div class="breadcrumb">
            <a href="<?= SITE_URL ?>">Home</a>
            <span class="sep">/</span>
            <a href="<?= SITE_URL ?>/shop">Shop</a>
            <span class="sep">/</span>
            <span><?= e($product['name']) ?></span>
        </div>
    </div>
</div>

<div class="container">
    <div class="product-details">
        <!-- Gallery -->
        <div class="product-gallery">
            <div class="main-img-wrap">
                <img src="<?= asset('images/products/' . ($product['image_url'] ?? 'placeholder.png')) ?>" alt="<?= e($product['name']) ?>" id="main-product-img" onerror="this.src='<?= asset('images/placeholder.png') ?>'">
            </div>
            <div class="thumb-grid">
                <div class="thumb-item active" onclick="updateMainImg(this)">
                    <img src="<?= asset('images/products/' . ($product['image_url'] ?? 'placeholder.png')) ?>" alt="" onerror="this.src='<?= asset('images/placeholder.png') ?>'">
                </div>
                <!-- Mock thumbs if any -->
                <div class="thumb-item" onclick="updateMainImg(this)">
                    <img src="<?= asset('images/placeholder.png') ?>" alt="">
                </div>
            </div>
        </div>

        <!-- Info -->
        <div class="product-main-info">
            <div class="pd-brand"><?= e($product['category_name'] ?? 'Premium Collection') ?></div>
            <h1 class="pd-name"><?= e($product['name']) ?></h1>
            
            <div class="pd-rating">
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <span class="rating-text">(24 Customer Reviews)</span>
            </div>

            <div class="pd-price">
                <?php if ($product['discount_price'] > 0): ?>
                <span class="price-current"><?= formatPrice($product['discount_price']) ?></span>
                <span class="price-old"><?= formatPrice($product['price']) ?></span>
                <span class="price-badge"><?= round((1 - $product['discount_price'] / $product['price']) * 100) ?>% OFF</span>
                <?php else: ?>
                <span class="price-current"><?= formatPrice($product['price']) ?></span>
                <?php endif; ?>
            </div>

            <p class="pd-desc">
                <?= e($product['description'] ?? 'চশমাজোনের এই প্রিমিয়াম সানগ্লাসটি আপনার স্টাইল এবং আভিজাত্যকে ফুটিয়ে তুলবে। ১০০% ইউভি প্রোটেকশন এবং হাই-কোয়ালিটি ফ্রেমের সাথে এটি দীর্ঘস্থায়ী ব্যবহারের নিশ্চয়তা দেয়।') ?>
            </p>

            <div class="pd-options">
                <div class="option-item">
                    <span class="option-label">Color:</span>
                    <div class="color-options">
                        <span class="color-dot active" style="background: #000;"></span>
                        <span class="color-dot" style="background: #555;"></span>
                        <span class="color-dot" style="background: #8B4513;"></span>
                    </div>
                </div>
            </div>

            <div class="pd-actions">
                <div class="qty-control">
                    <button type="button" class="qty-btn" onclick="updateQty(-1)">-</button>
                    <input type="number" id="pd-qty" value="1" min="1" readonly>
                    <button type="button" class="qty-btn" onclick="updateQty(1)">+</button>
                </div>
                <button class="btn btn-gold btn-lg flex-grow-1" onclick="addToCart('<?= $product['id'] ?>', '<?= e($product['name']) ?>', '<?= $product['discount_price'] > 0 ? $product['discount_price'] : $product['price'] ?>', '<?= asset('images/products/' . ($product['image_url'] ?? 'placeholder.png')) ?>')">
                    <i class="fas fa-shopping-cart me-2"></i> Add to Cart
                </button>
                <button class="wishlist-btn-outline">
                    <i class="far fa-heart"></i>
                </button>
            </div>

            <div class="pd-meta">
                <div class="meta-item">
                    <strong>SKU:</strong> <span>CZ-<?= str_pad($product['id'], 5, '0', STR_PAD_LEFT) ?></span>
                </div>
                <div class="meta-item">
                    <strong>Category:</strong> <span><?= e($product['category_name'] ?? 'Sunglasses') ?></span>
                </div>
                <div class="meta-item">
                    <strong>Availability:</strong> <span class="text-success">In Stock</span>
                </div>
            </div>

            <div class="pd-trust">
                <div class="trust-item">
                    <i class="fas fa-truck"></i>
                    <span>Free Shipping</span>
                </div>
                <div class="trust-item">
                    <i class="fas fa-shield-alt"></i>
                    <span>Authentic Product</span>
                </div>
                <div class="trust-item">
                    <i class="fas fa-undo"></i>
                    <span>7 Days Return</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Details Tabs -->
    <div class="pd-tabs mt-5">
        <div class="tab-headers">
            <button class="tab-btn active" data-tab="desc">Description</button>
            <button class="tab-btn" data-tab="info">Additional Info</button>
            <button class="tab-btn" data-tab="reviews">Reviews (24)</button>
        </div>
        <div class="tab-content">
            <div class="tab-pane active" id="desc">
                <p>আমাদের এই প্রিমিয়াম চশমাটি শুধুমাত্র একটি সানগ্লাস নয়, এটি আপনার ব্যক্তিত্বের বহিঃপ্রকাশ। এতে ব্যবহার করা হয়েছে উন্নতমানের লেন্স যা ক্ষতিকর আল্ট্রা-ভায়োলেট রশ্মি থেকে আপনার চোখকে রক্ষা করে। হালকা ওজনের ফ্রেমটি দীর্ঘক্ষণ পরে থাকলেও কোনো অস্বস্তি সৃষ্টি করে না।</p>
                <ul>
                    <li>১০০% ইউভি ৪০০ প্রোটেকশন</li>
                    <li>হাই-গ্রেড মেটাল/পলি-কার্বনেট ফ্রেম</li>
                    <li>প্রিমিয়াম কেস এবং ক্লিনিং ক্লথ সহ</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    <?php if (!empty($related)): ?>
    <section class="section">
        <div class="section-header text-start">
            <h2 class="section-title">Related <span>Products</span></h2>
            <div class="section-line"></div>
        </div>
        <div class="products-grid">
            <?php foreach (array_slice($related, 0, 4) as $product): ?>
            <?php include APP_PATH . '/views/shop/product_card.php'; ?>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>
</div>

<script>
function updateMainImg(el) {
    document.querySelectorAll('.thumb-item').forEach(i => i.classList.remove('active'));
    el.classList.add('active');
    document.getElementById('main-product-img').src = el.querySelector('img').src;
}

function updateQty(delta) {
    const input = document.getElementById('pd-qty');
    let val = parseInt(input.value) + delta;
    if (val < 1) val = 1;
    input.value = val;
}
</script>