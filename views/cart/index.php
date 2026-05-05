<div class="page-header">
    <div class="container">
        <h1><?= __('your_cart') ?></h1>
        <div class="breadcrumb">
            <a href="<?= SITE_URL ?>">Home</a>
            <span class="sep">/</span>
            <span>Cart</span>
        </div>
    </div>
</div>

<div class="container">
    <?php if (empty($cart)): ?>
    <div class="empty-state">
        <div class="empty-state-icon">🛒</div>
        <h3><?= __('empty_cart') ?></h3>
        <p>আপনার কার্টে কোনো পণ্য নেই। আমাদের কালেকশন থেকে আপনার পছন্দের পণ্যটি বেছে নিন।</p>
        <a href="<?= SITE_URL ?>/shop" class="btn btn-gold btn-lg mt-4"><?= __('continue_shopping') ?></a>
    </div>
    <?php else: ?>
    <div class="cart-layout">
        <div class="cart-main">
            <div class="cart-table-wrap">
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="cart-items-tbody">
                        <?php foreach ($cart as $item): 
                            $price = ($item['discount_price'] > 0) ? $item['discount_price'] : $item['price'];
                        ?>
                        <tr id="cart-row-<?= $item['product_id'] ?>">
                            <td>
                                <div class="cart-product">
                                    <div class="cart-thumb">
                                        <img src="<?= asset('images/products/' . ($item['image'] ?? 'placeholder.png')) ?>" alt="<?= e($item['name']) ?>" onerror="this.src='<?= asset('images/placeholder.png') ?>'">
                                    </div>
                                    <div class="cart-info">
                                        <a href="<?= SITE_URL ?>/shop/product/<?= e($item['slug'] ?? $item['product_id']) ?>" class="cart-name"><?= e($item['name']) ?></a>
                                        <span class="cart-brand"><?= e($item['brand'] ?? 'Premium Collection') ?></span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="cart-price"><?= formatPrice($price) ?></div>
                            </td>
                            <td>
                                <div class="qty-control">
                                    <button type="button" class="qty-btn cart-qty-btn" data-action="minus" data-id="<?= $item['product_id'] ?>">-</button>
                                    <input type="number" class="qty-input cart-qty-input" value="<?= $item['quantity'] ?>" min="1" readonly>
                                    <button type="button" class="qty-btn cart-qty-btn" data-action="plus" data-id="<?= $item['product_id'] ?>">+</button>
                                </div>
                            </td>
                            <td>
                                <div class="cart-subtotal" id="item-total-<?= $item['product_id'] ?>"><?= formatPrice($price * $item['quantity']) ?></div>
                            </td>
                            <td>
                                <button class="cart-remove remove-cart-btn" data-id="<?= $item['product_id'] ?>" title="Remove">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="cart-actions mt-4">
                <a href="<?= SITE_URL ?>/shop" class="btn btn-outline-gold">
                    <i class="fas fa-arrow-left me-2"></i> Continue Shopping
                </a>
                <button class="btn btn-dark" onclick="location.reload()">
                    <i class="fas fa-sync-alt me-2"></i> Update Cart
                </button>
            </div>
        </div>

        <div class="cart-sidebar">
            <div class="cart-summary">
                <h3 class="summary-title">Order Summary</h3>
                
                <div class="summary-list">
                    <div class="summary-item">
                        <span>Subtotal</span>
                        <span id="cart-subtotal"><?= formatPrice(cartTotal()) ?></span>
                    </div>
                    <div class="summary-item">
                        <span>Shipping Fee</span>
                        <span class="text-success">৳৬০</span>
                    </div>
                    <div class="summary-item coupon-item">
                        <div class="coupon-input-wrap">
                            <input type="text" placeholder="Coupon Code" class="coupon-input">
                            <button class="coupon-btn">Apply</button>
                        </div>
                    </div>
                    <div class="summary-item total-item">
                        <span>Grand Total</span>
                        <span class="total-price" id="cart-grand-total"><?= formatPrice(cartTotal() + 60) ?></span>
                    </div>
                </div>

                <a href="<?= SITE_URL ?>/checkout" class="btn btn-gold btn-full btn-lg mt-4">
                    Proceed to Checkout <i class="fas fa-arrow-right ms-2"></i>
                </a>
                
                <div class="payment-methods mt-4">
                    <p class="pm-title">Secure Checkout with</p>
                    <div class="pm-icons">
                        <i class="fab fa-cc-visa"></i>
                        <i class="fab fa-cc-mastercard"></i>
                        <span class="bkash-icon">bKash</span>
                        <span class="nagad-icon">Nagad</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>