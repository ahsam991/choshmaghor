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

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

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
                        <label class="form-label-text">Landmark (Optional)</label>
                        <div class="input-wrap">
                            <i class="fas fa-building input-icon"></i>
                            <input type="text" name="landmark" class="form-field" placeholder="Near Hospital/School, etc.">
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label-text">Pin your exact delivery location on the map *</label>
                        <div id="checkout-map" style="height: 300px; width: 100%; border-radius: 8px; border: 1px solid var(--border-color); z-index: 1;"></div>
                        <p class="text-muted small mt-1"><i class="fas fa-info-circle"></i> Drag the marker or click on the map to set your location.</p>
                        <input type="hidden" name="latitude" id="latitude" required>
                        <input type="hidden" name="longitude" id="longitude" required>
                        <button type="button" class="btn btn-outline-gold btn-sm mt-2" onclick="getCurrentLocation()"><i class="fas fa-crosshairs"></i> Use My Current Location</button>
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Initialize Map
        var initialLat = 23.8103; // Default Dhaka
        var initialLng = 90.4125;
        
        var map = L.map('checkout-map').setView([initialLat, initialLng], 12);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        var marker = L.marker([initialLat, initialLng], {draggable: true}).addTo(map);

        function updateCoordinates(lat, lng) {
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
        }

        updateCoordinates(initialLat, initialLng);

        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            updateCoordinates(e.latlng.lat, e.latlng.lng);
        });

        marker.on('dragend', function(e) {
            var position = marker.getLatLng();
            updateCoordinates(position.lat, position.lng);
        });

        window.getCurrentLocation = function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var lat = position.coords.latitude;
                    var lng = position.coords.longitude;
                    map.setView([lat, lng], 15);
                    marker.setLatLng([lat, lng]);
                    updateCoordinates(lat, lng);
                }, function(error) {
                    alert("Could not get your location. Please check browser permissions.");
                });
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        };

        // Handle Form Submission via AJAX to show success or error
        document.getElementById('checkout-form').addEventListener('submit', function(e) {
            e.preventDefault();
            var form = this;
            var submitBtn = form.querySelector('button[type="submit"]');
            var originalText = submitBtn.innerHTML;
            
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
            submitBtn.disabled = true;

            var formData = new FormData(form);
            fetch(form.action, {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    window.location.href = data.redirect;
                } else {
                    alert(data.message || 'An error occurred. Please try again.');
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }
            })
            .catch(err => {
                alert('Connection error. Please try again.');
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        });
    });
</script>