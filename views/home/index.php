<?php
// SEO Optimization for Home Page
$title = 'Buy Premium Sunglasses Online in Bangladesh';
$meta_description = 'Shop premium sunglasses online in Bangladesh at ChoshmaZone. 100% original UV400 protection eyewear for men & women. Best price, free shipping, cash on delivery. Explore Ray-Ban, Oakley style sunglasses in Dhaka.';
$og_title = 'ChoshmaZone - Premium Sunglasses Store in Bangladesh';
$og_type = 'website';
?>

<!-- Hero Section -->
<section class="hero">
    <div class="hero-bg"></div>
    <div class="hero-grid"></div>
    <div class="hero-glow"></div>
    <div class="hero-circle-ring"></div>
    
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <div class="hero-content">
                    <div class="hero-badge">
                        <span class="badge-dot"></span> ✨ <?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'New Collection 2024' : 'নতুন কালেকশন ২০২৪' ?>
                    </div>
                    <h1 class="hero-title">
                        Discover Your <br>
                        <span class="gold-text"><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Signature Style' : 'স্বাক্ষর শৈলী' ?></span>
                    </h1>
                    <p class="hero-sub">
                        <?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 
                            "Bangladesh's premium sunglasses collection. Every product reflects your elegance and taste. Original sunglasses with 100% UV protection." : 
                            'বাংলাদেশের সেরা প্রিমিয়াম সানগ্লাস কালেকশন। আমাদের প্রতিটি পণ্য আপনার আভিজাত্য এবং রুচির পরিচয় বহন করে। ১০০% ইউভি প্রোটেকশন সহ অরিজিনাল সানগ্লাস।' ?>
                    </p>
                    <div class="hero-cta">
                        <a href="<?= SITE_URL ?>/shop" class="btn btn-gold btn-lg"><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Shop Now' : 'এখনই কিনুন' ?> <i class="fas fa-arrow-right ms-2"></i></a>
                        <a href="<?= SITE_URL ?>/shop?sort=newest" class="btn btn-outline-gold btn-lg"><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Explore Collection' : 'কালেকশন দেখুন' ?></a>
                    </div>
                    <div class="hero-stats">
                        <div class="stat-item">
                            <span class="stat-num"><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? '500+' : '৫০০+' ?></span>
                            <span class="stat-label"><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Premium Products' : 'প্রিমিয়াম পণ্য' ?></span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-num"><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? '1000+' : '১০০০+' ?></span>
                            <span class="stat-label"><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Happy Customers' : 'সন্তুষ্ট গ্রাহক' ?></span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-num"><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? '100%' : '১০০%' ?></span>
                            <span class="stat-label"><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Original' : 'অরিজিনাল' ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-block">
                <div class="hero-visual">
                    <div class="hero-img-wrap">
                        <img src="<?= asset('images/hero-glasses.png') ?>" alt="Premium Sunglasses Online Bangladesh - ChoshmaZone" class="hero-img" onerror="this.src='<?= asset('images/placeholder.png') ?>'">
                    </div>
                    <div class="hero-floating-badge badge-1">
                        <div class="hfb-icon text-gold">🕶️</div>
                        <div class="hfb-text">
                            <strong>Luxury Wear</strong>
                            <span>Handcrafted Quality</span>
                        </div>
                    </div>
                    <div class="hero-floating-badge badge-2">
                        <div class="hfb-icon text-gold">⭐</div>
                        <div class="hfb-text">
                            <strong>4.9/5 Rating</strong>
                            <span>Customer Reviews</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Strip -->
<section class="features-strip">
    <div class="container">
        <div class="features-grid">
            <div class="feature-item">
                <i class="fas fa-shipping-fast feature-icon"></i>
                <div class="feature-text">
                    <strong><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Fast Delivery' : 'দ্রুত ডেলিভারি' ?></strong>
                    <small><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? '24hr delivery in Dhaka' : 'ঢাকায় ২৪ ঘণ্টায় ডেলিভারি' ?></small>
                </div>
            </div>
            <div class="feature-item">
                <i class="fas fa-shield-alt feature-icon"></i>
                <div class="feature-text">
                    <strong><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? '100% Original' : '১০০% অরিজিনাল' ?></strong>
                    <small><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Quality guaranteed' : 'পণ্যের মানের গ্যারান্টি' ?></small>
                </div>
            </div>
            <div class="feature-item">
                <i class="fas fa-undo-alt feature-icon"></i>
                <div class="feature-text">
                    <strong><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Easy Return' : 'সহজ রিটার্ন' ?></strong>
                    <small><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? '7 days return policy' : '৭ দিনের মধ্যে রিটার্ন সুবিধা' ?></small>
                </div>
            </div>
            <div class="feature-item">
                <i class="fas fa-headset feature-icon"></i>
                <div class="feature-text">
                    <strong><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? '24/7 Support' : '২৪/৭ সাপোর্ট' ?></strong>
                    <small><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Always here to help' : 'যেকোনো প্রয়োজনে পাশে আছি' ?></small>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="section-tag"><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Categories - Shop by Type' : 'ক্যাটাগরি - টাইপ অনুযায়ী কিনুন' ?></span>
            <h2 class="section-title"><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Shop by' : 'ক্যাটাগরি অনুযায়ী' ?> <span><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Category' : 'কিনুন' ?></span></h2>
            <div class="section-line">
                <div class="section-line-dot"></div>
            </div>
            <p class="section-desc"><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? "Choose your preferred category and start shopping. Men's sunglasses, women's sunglasses, unisex eyewear - all types of glasses available in one place." : 'আপনার পছন্দের ক্যাটাগরি বেছে নিন এবং শুরু করুন কেনাকাটা। Men'\''s sunglasses, women'\''s sunglasses, unisex eyewear - সব ধরনের চশমা পাচ্ছেন একসাথে।' ?></p>
        </div>
        
        <div class="categories-grid">
            <?php 
            $cat_icons = [1 => '🕶️', 2 => '👩', 3 => '👨', 4 => '✨'];
            foreach ($categories as $cat): 
            ?>
            <a href="<?= SITE_URL ?>/shop?category=<?= $cat['id'] ?>" class="category-card" title="Buy <?= e($cat['name']) ?> Online Bangladesh">
                <div class="cat-icon"><?= $cat_icons[$cat['id']] ?? '🕶️' ?></div>
                <div class="cat-name"><?= e($cat['name']) ?></div>
                <div class="cat-count"><?= $cat['product_count'] ?> Products</div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Featured Products -->
<?php if (!empty($featured)): ?>
<section class="section bg-dark-2">
    <div class="container">
        <div class="section-header d-flex justify-content-between align-items-end text-start">
            <div>
                <span class="section-tag"><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Featured - Best Selling Sunglasses' : 'ফিচার্ড - সেরা বিক্রিত সানগ্লাস' ?></span>
                <h2 class="section-title"><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Exclusive' : 'এক্সক্লুসিভ' ?> <span><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Collection' : 'কালেকশন' ?></span></h2>
                <p class="text-dim mt-2" style="max-width: 600px;"><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? "Our exclusive collection features premium quality sunglasses that will make your personality more attractive. Original glasses with UV400 protection." : 'আমাদের এক্সক্লুসিভ কালেকশনে পাচ্ছেন প্রিমিয়াম কোয়ালিটির সানগ্লাস যা আপনার ব্যক্তিত্বকে করে তুলবে আরও আকর্ষণীয়। UV400 প্রোটেকশন সহ অরিজিনাল চশমা।' ?></p>
            </div>
            <a href="<?= SITE_URL ?>/shop" class="btn btn-outline-gold mb-3" title="<?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'View All Premium Sunglasses' : 'সব প্রিমিয়াম সানগ্লাস দেখুন' ?>"><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'View All' : 'সব দেখুন' ?> <i class="fas fa-arrow-right ms-2"></i></a>
        </div>
        
        <div class="products-grid">
            <?php foreach ($featured as $product): ?>
            <?php include APP_PATH . '/views/shop/product_card.php'; ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Promo Banner -->
<section class="promo-section">
    <div class="container">
        <div class="promo-banner">
            <div class="promo-content">
                <span class="promo-tag"><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Limited Time Offer' : 'সীমিত সময়ের অফার' ?></span>
                <h2 class="promo-title"><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Special Offer' : 'বিশেষ অফার' ?> 🎉</h2>
                <p class="promo-desc"><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Get 15% OFF when you buy any 2 sunglasses! Grab your favorite one today.' : 'যেকোনো ২টি সানগ্লাস কিনলে ১৫% ছাড়! আজই আপনার পছন্দেরটি সংগ্রহ করুন।' ?></p>
                <div class="promo-timer" id="promo-timer">
                    <div class="timer-box">
                        <span class="timer-num t-h">05</span>
                        <span class="timer-label"><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Hours' : 'ঘণ্টা' ?></span>
                    </div>
                    <div class="timer-box">
                        <span class="timer-num t-m">32</span>
                        <span class="timer-label"><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Min' : 'মিনিট' ?></span>
                    </div>
                    <div class="timer-box">
                        <span class="timer-num t-s">17</span>
                        <span class="timer-label"><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Sec' : 'সেকেন্ড' ?></span>
                    </div>
                </div>
                <a href="<?= SITE_URL ?>/shop" class="btn btn-gold btn-lg mt-4"><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Shop Now' : 'এখনই কিনুন' ?></a>
            </div>
            <div class="promo-badge">🕶️</div>
        </div>
    </div>
</section>

<!-- New Arrivals -->
<?php if (!empty($new_arrivals)): ?>
<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="section-tag"><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'New Arrivals - Latest Sunglasses 2024' : 'নতুন আগমন - লেটেস্ট সানগ্লাস ২০২৪' ?></span>
            <h2 class="section-title"><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Latest' : 'লেটেস্ট' ?> <span><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Styles' : 'স্টাইল' ?></span></h2>
            <div class="section-line">
                <div class="section-line-dot"></div>
            </div>
            <p class="section-desc" style="max-width: 700px;"><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? "New Collection 2024 - Our latest styles of sunglasses are now within your reach. Buy trendy designs, premium quality and affordable prices online." : 'নতুন কালেকশন ২০২৪ - আমাদের লেটেস্ট স্টাইলের সানগ্লাসগুলো এখন আপনার হাতের নাগালে। ট্রেন্ডি ডিজাইন, প্রিমিয়াম কোয়ালিটি এবং সাশ্রয়ী মূল্যে কিনুন অনলাইনে।' ?></p>
        </div>
        
        <div class="products-grid">
            <?php foreach ($new_arrivals as $product): ?>
            <?php include APP_PATH . '/views/shop/product_card.php'; ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>
