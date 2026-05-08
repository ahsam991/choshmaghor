<?php
// SEO optimization for contact page
if (!isset($title)) {
    $title = 'Contact ChoshmaZone - Get in Touch';
}
if (!isset($meta_description)) {
    $meta_description = 'Contact ChoshmaZone for any inquiries about our premium sunglasses. Call, WhatsApp, or email us. Fast response guaranteed.';
}
?>

<!-- Hero Section -->
<section class="page-hero">
    <div class="container">
        <div class="hero-content">
            <h1><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Contact Us' : 'যোগাযোগ করুন' ?></h1>
            <p class="lead"><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'We\'re Here to Help You Find the Perfect Sunglasses' : 'আমরা আপনাকে নিখুঁত সানগ্লাস খুঁজে পেতে সাহায্য করতে প্রস্তুত' ?></p>
        </div>
    </div>
</section>

<!-- Contact Content -->
<section class="contact-section py-5">
    <div class="container">
        <!-- Contact Info Cards -->
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="contact-card p-4 text-center h-100 bg-light rounded">
                    <i class="fas fa-phone-alt text-gold fa-3x mb-3"></i>
                    <h4><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Call Us' : 'কল করুন' ?></h4>
                    <p class="text-muted mb-3"><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Speak with our customer support team' : 'আমাদের গ্রাহক সহায়তা দলের সাথে কথা বলুন' ?></p>
                    <a href="tel:+8801889688034" class="btn btn-gold">+880 1889-688034</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="contact-card p-4 text-center h-100 bg-light rounded">
                    <i class="fab fa-whatsapp text-gold fa-3x mb-3"></i>
                    <h4>WhatsApp</h4>
                    <p class="text-muted mb-3"><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Chat with us instantly' : 'আমাদের সাথে তাৎক্ষণিক চ্যাট করুন' ?></p>
                    <a href="https://wa.me/8801889688034" target="_blank" class="btn btn-success">
                        <i class="fab fa-whatsapp me-2"></i><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Chat Now' : 'চ্যাট করুন' ?>
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="contact-card p-4 text-center h-100 bg-light rounded">
                    <i class="fas fa-envelope text-gold fa-3x mb-3"></i>
                    <h4>Email</h4>
                    <p class="text-muted mb-3"><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Send us your inquiries' : 'আমাদের আপনার প্রশ্ন পাঠান' ?></p>
                    <a href="mailto:contact@choshmazone.com" class="btn btn-outline-dark">contact@choshmazone.com</a>
                </div>
            </div>
        </div>

        <!-- Contact Form & Map -->
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="contact-form-wrapper p-4 bg-light rounded">
                    <h3 class="mb-4"><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Send Us a Message' : 'আমাদের একটি বার্তা পাঠান' ?></h3>
                    <form id="contact-form" action="<?= SITE_URL ?>/contact/submit" method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label"><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Your Name' : 'আপনার নাম' ?></label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label"><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Email Address' : 'ইমেইল ঠিকানা' ?></label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label"><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Phone Number' : 'ফোন নম্বর' ?></label>
                            <input type="tel" class="form-control" id="phone" name="phone">
                        </div>
                        <div class="mb-3">
                            <label for="subject" class="form-label"><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Subject' : 'বিষয়' ?></label>
                            <select class="form-select" id="subject" name="subject" required>
                                <option value=""><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Select a subject' : 'একটি বিষয় নির্বাচন করুন' ?></option>
                                <option value="order"><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Order Inquiry' : 'অর্ডার সংক্রান্ত' ?></option>
                                <option value="product"><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Product Question' : 'পণ্য সংক্রান্ত' ?></option>
                                <option value="support"><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Customer Support' : 'গ্রাহক সহায়তা' ?></option>
                                <option value="other"><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Other' : 'অন্যান্য' ?></option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label"><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Message' : 'বার্তা' ?></label>
                            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-gold w-100">
                            <i class="fas fa-paper-plane me-2"></i><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Send Message' : 'বার্তা পাঠান' ?>
                        </button>
                    </form>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="contact-info-wrapper p-4 h-100">
                    <h3 class="mb-4"><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Get in Touch' : 'যোগাযোগ করুন' ?></h3>
                    
                    <div class="info-item d-flex mb-4">
                        <div class="info-icon me-3">
                            <i class="fas fa-map-marker-alt text-gold fa-2x"></i>
                        </div>
                        <div>
                            <h5><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Our Location' : 'আমাদের অবস্থান' ?></h5>
                            <p class="text-muted"><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Dhaka, Bangladesh' : 'ঢাকা, বাংলাদেশ' ?></p>
                        </div>
                    </div>
                    
                    <div class="info-item d-flex mb-4">
                        <div class="info-icon me-3">
                            <i class="fas fa-clock text-gold fa-2x"></i>
                        </div>
                        <div>
                            <h5><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Business Hours' : 'ব্যবসায়িক ঘন্টা' ?></h5>
                            <p class="text-muted">
                                <?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 
                                    'Sunday - Friday: 9:00 AM - 10:00 PM<br>Saturday: 10:00 AM - 8:00 PM' : 
                                    'রবিবার - শুক্রবার: সকাল ৯:০০ - রাত ১০:০০<br>শনিবার: সকাল ১০:০০ - রাত ৮:০০' ?>
                            </p>
                        </div>
                    </div>
                    
                    <div class="info-item d-flex mb-4">
                        <div class="info-icon me-3">
                            <i class="fas fa-shipping-fast text-gold fa-2x"></i>
                        </div>
                        <div>
                            <h5><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Delivery Information' : 'ডেলিভারি তথ্য' ?></h5>
                            <p class="text-muted">
                                <?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 
                                    'Fast delivery across all 64 districts of Bangladesh. Cash on Delivery available.' : 
                                    'বাংলাদেশের ৬৪টি জেলায় দ্রুত ডেলিভারি। ক্যাশ অন ডেলিভারি সুবিধা উপলব্ধ।' ?>
                            </p>
                        </div>
                    </div>
                    
                    <div class="faq-section mt-5">
                        <h4 class="mb-3"><?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Quick FAQs' : 'দ্রুত FAQ' ?></h4>
                        <div class="accordion" id="contactAccordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                        <?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'How long does delivery take?' : 'ডেলিভারি করতে কত সময় লাগে?' ?>
                                    </button>
                                </h2>
                                <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#contactAccordion">
                                    <div class="accordion-body">
                                        <?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 
                                            'Inside Dhaka: 1-2 days. Outside Dhaka: 3-5 days.' : 
                                            'ঢাকার ভিতরে: ১-২ দিন। ঢাকার বাইরে: ৩-৫ দিন।' ?>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                        <?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Can I return products?' : 'আমি কি পণ্য ফেরত দিতে পারি?' ?>
                                    </button>
                                </h2>
                                <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#contactAccordion">
                                    <div class="accordion-body">
                                        <?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 
                                            'Yes, we have a 7-day return policy for unused products in original condition.' : 
                                            'হ্যাঁ, মূল অবস্থায় অ ব্যবহৃত পণ্যের জন্য আমাদের ৭ দিনের রিটার্ন পলিসি আছে।' ?>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                        <?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Is Cash on Delivery available?' : 'ক্যাশ অন ডেলিভারি সুবিধা আছে কি?' ?>
                                    </button>
                                </h2>
                                <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#contactAccordion">
                                    <div class="accordion-body">
                                        <?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 
                                            'Yes! Cash on Delivery is available for all orders nationwide.' : 
                                            'হ্যাঁ! সারা দেশের সব অর্ডারের জন্য ক্যাশ অন ডেলিভারি সুবিধা উপলব্ধ।' ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CSS Styles -->
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

.contact-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.contact-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
}

.btn-gold {
    background: #D4AF37;
    color: white;
    border: none;
    padding: 10px 25px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-gold:hover {
    background: #b8942e;
    color: white;
    transform: translateY(-2px);
}

.info-item {
    border-bottom: 1px solid #e0e0e0;
    padding-bottom: 1.5rem;
}

.info-item:last-child {
    border-bottom: none;
}

.accordion-button:not(.collapsed) {
    background-color: #fff8e1;
    color: #D4AF37;
}

.accordion-button:focus {
    border-color: #D4AF37;
    box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.25);
}

@media (max-width: 768px) {
    .hero-content h1 {
        font-size: 2rem;
    }
    
    .section-title {
        font-size: 1.5rem;
    }
}
</style>

<script>
document.getElementById('contact-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Sending...';
    
    fetch(this.action, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('<?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Message sent successfully! We will get back to you soon.' : 'বার্তা সফলভাবে পাঠানো হয়েছে! আমরা শীঘ্রই আপনার সাথে যোগাযোগ করব।' ?>');
            this.reset();
        } else {
            alert('<?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'Something went wrong. Please try again.' : 'কিছু ভুল হয়েছে। অনুগ্রহ করে আবার চেষ্টা করুন।' ?>');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('<?= isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? 'An error occurred. Please try again later.' : 'একটি ত্রুটি ঘটেছে। অনুগ্রহ করে পরে আবার চেষ্টা করুন।' ?>');
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    });
});
</script>
