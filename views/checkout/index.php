<div class="page-header">
    <div class="container">
        <h1>Checkout</h1>
        <div class="breadcrumb">
            <a href="<?= SITE_URL ?>">Home</a>
            <span class="sep">/</span>
            <a href="<?= SITE_URL ?>/cart">Cart</a>
            <span class="sep">/</span>
            <span>Checkout</span>
        </div>
    </div>
</div>

<div class="container">
    <form id="checkout-form" method="POST" action="<?= SITE_URL ?>/checkout/process">
        <div class="checkout-grid">
            <div class="checkout-main">
                <!-- Step 1: Delivery Info -->
                <div class="checkout-card">
                    <h3 class="checkout-section-title">
                        <span class="step-num">1</span> Delivery Information
                    </h3>
                    
                    <div class="checkout-2col">
                        <div class="form-group">
                            <label class="form-label-text">Full Name *</label>
                            <div class="input-wrap">
                                <i class="fas fa-user input-icon"></i>
                                <input type="text" name="name" class="form-field" placeholder="John Doe" required value="<?= isset($user['name']) ? e($user['name']) : '' ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label-text">Email Address *</label>
                            <div class="input-wrap">
                                <i class="fas fa-envelope input-icon"></i>
                                <input type="email" name="email" class="form-field" placeholder="john@example.com" required value="<?= isset($user['email']) ? e($user['email']) : '' ?>">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label-text">Phone Number *</label>
                        <div class="input-wrap">
                            <i class="fas fa-phone input-icon"></i>
                            <input type="tel" name="phone" class="form-field" placeholder="01XXXXXXXXX" required value="<?= isset($user['phone']) ? e($user['phone']) : '' ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label-text">Delivery Address *</label>
                        <div class="input-wrap">
                            <i class="fas fa-map-marker-alt input-icon"></i>
                            <input type="text" name="address" class="form-field" placeholder="Street Address, House/Flat No" required value="<?= isset($user['address']) ? e($user['address']) : '' ?>">
                        </div>
                    </div>

                    <div class="checkout-2col">
                        <div class="form-group">
                            <label class="form-label-text">City *</label>
                            <select name="city" class="form-field" required>
                                <option value="">Select City</option>
                                <option value="Dhaka">Dhaka</option>
                                <option value="Chittagong">Chittagong</option>
                                <option value="Rajshahi">Rajshahi</option>
                                <option value="Khulna">Khulna</option>
                                <option value="Sylhet">Sylhet</option>
                                <option value="Barishal">Barishal</option>
                                <option value="Rangpur">Rangpur</option>
                                <option value="Mymensingh">Mymensingh</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label-text">Postal Code</label>
                            <div class="input-wrap">
                                <i class="fas fa-mailbox input-icon"></i>
                                <input type="text" name="postal_code" class="form-field" placeholder="1234">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label-text">Order Notes (Optional)</label>
                        <textarea name="notes" class="form-field" rows="2" placeholder="Notes about your order..."></textarea>
                    </div>
                </div>

                <!-- Step 2: Payment -->
                <div class="checkout-card">
                    <h3 class="checkout-section-title">
                        <span class="step-num">2</span> Payment Method
                    </h3>
                    
                    <div class="payment-options">
                        <label class="payment-option">
                            <input type="radio" name="payment_method" value="cod" checked>
                            <div class="payment-icon-wrap">💵</div>
                            <div class="payment-label">
                                <strong>Cash on Delivery</strong>
                                <span>Pay when you receive the product</span>
                            </div>
                        </label>

                        <label class="payment-option disabled">
                            <input type="radio" name="payment_method" value="bkash" disabled>
                            <div class="payment-icon-wrap">📱</div>
                            <div class="payment-label">
                                <strong>bKash / Online Payment</strong>
                                <span>Currently Unavailable (Coming Soon)</span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Sidebar Summary -->
            <aside class="summary-sidebar">
                <div class="summary-card sticky-top" style="top: 100px;">
                    <h3 class="summary-title">Order Summary</h3>
                    
                    <div class="checkout-items">
                        <?php foreach ($cart as $item): 
                            $price = ($item['discount_price'] > 0) ? $item['discount_price'] : $item['price'];
                        ?>
                        <div class="checkout-item">
                            <div class="ci-info">
                                <span class="ci-name"><?= e($item['name']) ?></span>
                                <span class="ci-qty">Qty: <?= $item['quantity'] ?></span>
                            </div>
                            <span class="ci-price"><?= formatPrice($price * $item['quantity']) ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="summary-breakdown">
                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span><?= formatPrice($subtotal) ?></span>
                        </div>
                        <div class="summary-row">
                            <span>Shipping</span>
                            <span><?= formatPrice($shipping) ?></span>
                        </div>
                        <div class="summary-row total-row">
                            <strong>Total</strong>
                            <strong class="text-gold"><?= formatPrice($total) ?></strong>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-gold btn-full btn-lg mt-4">
                        Place Order <i class="fas fa-check-circle ms-2"></i>
                    </button>
                    
                    <div class="checkout-trust mt-3">
                        <i class="fas fa-lock me-1"></i> Secure 256-bit SSL Encrypted Payment
                    </div>
                </div>
            </aside>
        </div>
    </form>
</div>