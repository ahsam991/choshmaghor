<div class="container py-5">
    <div class="order-success text-center">
        <div class="success-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <h2 class="mt-3"><?= __('order_confirmed') ?></h2>
        <p class="lead">আপনার অর্ডার নম্বর: <strong class="text-gold">#<?= e($order['order_number']) ?></strong></p>
        <p class="text-muted">শীঘ্রই আপনার সাথে যোগাযোগ করা হবে</p>

        <div class="order-detail-box mt-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="detail-card">
                        <h6>ডেলিভারি ঠিকানা</h6>
                        <p><strong><?= e($order['name']) ?></strong><br>
                        <?= e($order['address']) ?><br>
                        <?= e($order['city']) ?><br>
                        <?= e($order['phone']) ?></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-card">
                        <h6>পেমেন্ট তথ্য</h6>
                        <p>পদ্ধতি: <?= $order['payment_method'] === 'cod' ? 'ক্যাশ অন ডেলিভারি' : e($order['payment_method']) ?><br>
                        অবস্থা: <span class="badge bg-warning">অপেক্ষমান</span><br>
                        মোট: <strong class="text-gold"><?= formatPrice($order['total']) ?></strong></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="order-items-list mt-4">
            <h5 class="text-start mb-3">অর্ডারকৃত পণ্য</h5>
            <?php foreach ($items as $item): ?>
            <div class="order-item-row d-flex justify-content-between align-items-center">
                <span><?= e($item['name']) ?> × <?= $item['quantity'] ?></span>
                <span><?= formatPrice($item['total']) ?></span>
            </div>
            <?php endforeach; ?>
            <div class="d-flex justify-content-between mt-3 border-top pt-3">
                <strong>মোট মূল্য:</strong>
                <strong class="text-gold"><?= formatPrice($order['total']) ?></strong>
            </div>
        </div>

        <div class="mt-4 d-flex justify-content-center gap-3 flex-wrap">
            <a href="<?= SITE_URL ?>/account/orders" class="btn btn-gold"><i class="fas fa-list me-2"></i>আমার অর্ডার</a>
            <a href="<?= SITE_URL ?>/shop" class="btn btn-outline-gold"><i class="fas fa-shopping-bag me-2"></i>কেনাকাটা চালিয়ে যান</a>
        </div>
    </div>
</div>