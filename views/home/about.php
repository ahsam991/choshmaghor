<?php
// SEO optimization for about page
if (!isset($title)) {
    $title = 'About ChoshmaZone - Premium Sunglasses Store in Bangladesh';
}
if (!isset($meta_description)) {
    $meta_description = 'Learn about ChoshmaZone, Bangladesh\'s leading online sunglasses store. We offer 100% original UV400 protection eyewear with fast delivery and cash on delivery options.';
}
?>

<!-- Hero Section -->
<section class="page-hero">
    <div class="container">
        <div class="hero-content">
            <h1><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'About ChoshmaZone' : 'চশমাZone সম্পর্কে' ?></h1>
            <p class="lead"><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Your Trusted Partner for Premium Eyewear in Bangladesh' : 'বাংলাদেশে প্রিমিয়াম আইওয়্যারের বিশ্বস্ত সহযোগী' ?></p>
        </div>
    </div>
</section>

<!-- About Content -->
<section class="about-section py-5">
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <img src="https://images.unsplash.com/photo-1511499767150-a48a237f0083?auto=format&fit=crop&q=80&w=800&h=600" alt="ChoshmaZone Team" class="img-fluid rounded shadow-lg" style="object-fit:cover; width:100%; height:auto;">
            </div>
            <div class="col-lg-6">
                <h2 class="section-title mb-4"><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Our Story' : 'আমাদের গল্প' ?></h2>
                <p class="text-muted">
                    <?php if (isset($_SESSION['lang']) && $_SESSION['lang'] === 'en'): ?>
                        Founded with a vision to bring premium quality eyewear to Bangladesh, ChoshmaZone has become the country's most trusted online sunglasses destination. We believe that everyone deserves access to high-quality, stylish eyewear that protects their eyes while enhancing their look.
                    <?php else: ?>
                        বাংলাদেশে প্রিমিয়াম মানের আইওয়্যার নিয়ে আসার লক্ষ্যে প্রতিষ্ঠিত, চশমাZone দেশের সবচেয়ে বিশ্বস্ত অনলাইন সানগ্লাস গন্তব্যে পরিণত হয়েছে। আমরা বিশ্বাস করি যে সবার উচিত উচ্চমানের, স্টাইলিশ আইওয়্যার পাওয়া যা তাদের চোখ রক্ষা করে এবং তাদের চেহারা উন্নত করে।
                    <?php endif; ?>
                </p>
                <p class="text-muted">
                    <?php if (isset($_SESSION['lang']) && $_SESSION['lang'] === 'en'): ?>
                        Every pair of sunglasses at ChoshmaZone is carefully selected to meet our strict quality standards. We offer 100% authentic products with UV400 protection, ensuring your eyes are shielded from harmful rays while you look your best.
                    <?php else: ?>
                        চশমাZone-এর প্রতিটি সানগ্লাস আমাদের কঠোর মানের মান পূরণ করার জন্য যত্ন সহকারে নির্বাচন করা হয়। আমরা ১০০% আসল পণ্য অফার করি ইউভি৪০০ সুরক্ষা সহ, নিশ্চিত করি যে আপনার চোখ ক্ষতিকারক রশ্মি থেকে সুরক্ষিত থাকে এবং আপনি সেরা দেখেন।
                    <?php endif; ?>
                </p>
            </div>
        </div>

        <!-- Mission & Vision -->
        <div class="row mb-5">
            <div class="col-md-6 mb-4">
                <div class="feature-box p-4 h-100 bg-light rounded">
                    <div class="icon-box mb-3">
                        <i class="fas fa-bullseye text-gold fa-3x"></i>
                    </div>
                    <h3><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Our Mission' : 'আমাদের মিশন' ?></h3>
                    <p class="text-muted">
                        <?php if (isset($_SESSION['lang']) && $_SESSION['lang'] === 'en'): ?>
                            To provide every customer with premium quality sunglasses at affordable prices, backed by exceptional customer service and fast delivery across Bangladesh.
                        <?php else: ?>
                            প্রতিটি গ্রাহককে সাশ্রয়ী মূল্যে প্রিমিয়াম মানের সানগ্লাস প্রদান করা, বাংলাদেশ জুড়ে চমৎকার গ্রাহক সেবা এবং দ্রুত ডেলিভারি সমর্থিত।
                        <?php endif; ?>
                    </p>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="feature-box p-4 h-100 bg-light rounded">
                    <div class="icon-box mb-3">
                        <i class="fas fa-eye text-gold fa-3x"></i>
                    </div>
                    <h3><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Our Vision' : 'আমাদের ভিশন' ?></h3>
                    <p class="text-muted">
                        <?php if (isset($_SESSION['lang']) && $_SESSION['lang'] === 'en'): ?>
                            To become Bangladesh's #1 eyewear brand, recognized for quality, authenticity, and customer satisfaction. We envision a future where everyone has access to stylish, protective eyewear.
                        <?php else: ?>
                            বাংলাদেশের #১ আইওয়্যার ব্র্যান্ড হওয়া, গুণমান, আসলতা এবং গ্রাহক সন্তুষ্টির জন্য স্বীকৃত। আমরা এমন একটি ভবিষ্যৎ কল্পনা করি যেখানে সবার কাছে স্টাইলিশ, সুরক্ষামূলক আইওয়্যার আছে।
                        <?php endif; ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Why Choose Us -->
        <div class="text-center mb-5">
            <h2 class="section-title"><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Why Choose ChoshmaZone?' : 'কেন চশমাZone বেছে নেবেন?' ?></h2>
        </div>
        <div class="row g-4">
            <div class="col-md-3 col-sm-6">
                <div class="feature-card text-center p-4">
                    <i class="fas fa-check-circle text-gold fa-3x mb-3"></i>
                    <h5><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? '100% Authentic' : '১০০% আসল' ?></h5>
                    <p class="small text-muted"><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Genuine products guaranteed' : 'আসল পণ্যের নিশ্চয়তা' ?></p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="feature-card text-center p-4">
                    <i class="fas fa-shield-alt text-gold fa-3x mb-3"></i>
                    <h5><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'UV400 Protection' : 'ইউভি৪০০ সুরক্ষা' ?></h5>
                    <p class="small text-muted"><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Complete eye protection' : 'পূর্ণ চোখের সুরক্ষা' ?></p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="feature-card text-center p-4">
                    <i class="fas fa-truck text-gold fa-3x mb-3"></i>
                    <h5><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Fast Delivery' : 'দ্রুত ডেলিভারি' ?></h5>
                    <p class="small text-muted"><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Nationwide shipping' : 'সারা দেশে শিপিং' ?></p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="feature-card text-center p-4">
                    <i class="fas fa-hand-holding-usd text-gold fa-3x mb-3"></i>
                    <h5><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Cash on Delivery' : 'ক্যাশ অন ডেলিভারি' ?></h5>
                    <p class="small text-muted"><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Pay after receiving' : 'পাওয়ার পরে পরিশোধ করুন' ?></p>
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="row mt-5 pt-4">
            <div class="col-12">
                <div class="stats-section bg-dark text-white rounded p-5">
                    <div class="row text-center">
                        <div class="col-md-3 mb-4 mb-md-0">
                            <h3 class="text-gold display-4 fw-bold">5000+</h3>
                            <p><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Happy Customers' : 'সুখী গ্রাহক' ?></p>
                        </div>
                        <div class="col-md-3 mb-4 mb-md-0">
                            <h3 class="text-gold display-4 fw-bold">200+</h3>
                            <p><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Premium Styles' : 'প্রিমিয়াম স্টাইল' ?></p>
                        </div>
                        <div class="col-md-3 mb-4 mb-md-0">
                            <h3 class="text-gold display-4 fw-bold">64+</h3>
                            <p><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Districts Covered' : 'জেলা কভার' ?></p>
                        </div>
                        <div class="col-md-3">
                            <h3 class="text-gold display-4 fw-bold">100%</h3>
                            <p><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Satisfaction' : 'সন্তুষ্টি' ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact CTA -->
        <div class="row mt-5 pt-4">
            <div class="col-12 text-center">
                <div class="cta-box p-5 bg-light rounded">
                    <h3 class="mb-3"><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Have Questions?' : 'কোন প্রশ্ন আছে?' ?></h3>
                    <p class="mb-4 text-muted">
                        <?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 
                            'Our customer support team is here to help you find the perfect sunglasses. Reach out to us anytime!' : 
                            'আমাদের গ্রাহক সহায়তা দল আপনাকে নিখুঁত সানগ্লাস খুঁজে পেতে সাহায্য করতে প্রস্তুত। যেকোনো সময় আমাদের সাথে যোগাযোগ করুন!' ?>
                    </p>
                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                        <a href="tel:+8801889688034" class="btn btn-gold btn-lg">
                            <i class="fas fa-phone me-2"></i>
                            <?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Call Now' : 'কল করুন' ?>
                        </a>
                        <a href="https://wa.me/8801889688034" target="_blank" class="btn btn-success btn-lg">
                            <i class="fab fa-whatsapp me-2"></i>
                            <?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Chat on WhatsApp' : 'WhatsApp এ চ্যাট করুন' ?>
                        </a>
                        <a href="<?= SITE_URL ?>/contact" class="btn btn-outline-dark btn-lg">
                            <i class="fas fa-envelope me-2"></i>
                            <?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Contact Us' : 'যোগাযোগ করুন' ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Additional CSS for About Page -->
<style>
.page-hero {
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
    color: white;
    padding: 80px 0;
    text-align: center;
}

.hero-content h1 {
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.hero-content .lead {
    font-size: 1.25rem;
    opacity: 0.9;
}

.section-title {
    font-size: 2rem;
    font-weight: 700;
    color: #1a1a1a;
    position: relative;
    display: inline-block;
}

.section-title::after {
    content: '';
    display: block;
    width: 60px;
    height: 3px;
    background: #D4AF37;
    margin: 10px auto 0;
}

.feature-box {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.feature-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.feature-card {
    background: white;
    border-radius: 10px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
}

.feature-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.15);
}

.stats-section {
    background: linear-gradient(135deg, #1a1a1a 0%, #333 100%);
}

.cta-box {
    border: 2px solid #D4AF37;
}

.btn-gold {
    background: #D4AF37;
    color: white;
    border: none;
    padding: 12px 30px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-gold:hover {
    background: #b8942e;
    color: white;
    transform: translateY(-2px);
}

@media (max-width: 768px) {
    .hero-content h1 {
        font-size: 2rem;
    }
    
    .section-title {
        font-size: 1.5rem;
    }
    
    .display-4 {
        font-size: 2.5rem;
    }
}
</style>
