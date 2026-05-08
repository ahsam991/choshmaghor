<div class="admin-page-header">
    <div>
        <h1 class="admin-page-title"><i class="fas fa-receipt"></i> Order Details</h1>
        <p class="admin-page-sub">Review order status, customer info, and items.</p>
    </div>
    <?php if ($order): 
        $shipping = json_decode($order['shipping_address'] ?? '{}', true);
    ?>
        <div class="d-flex gap-2">
            <?php if (!empty($shipping['phone'])): ?>
                <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $shipping['phone']) ?>" class="btn btn-outline-gold" target="_blank">
                    <i class="fab fa-whatsapp me-2"></i> Message Customer
                </a>
            <?php endif; ?>
            <a href="<?= SITE_URL ?>/admin/invoice/<?= $order['id'] ?>" class="btn btn-gold" target="_blank">
                <i class="fas fa-print me-2"></i> Print Invoice
            </a>
        </div>
    <?php endif; ?>
</div>

<!-- Leaflet CSS for Admin -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<div class="admin-content-container">
    <?php if (!$order): ?>
        <div class="alert alert-danger shadow-sm mb-4">
            <i class="fas fa-exclamation-circle me-2"></i> Order not found. It might have been deleted.
        </div>
        <a href="<?= SITE_URL ?>/admin/orders" class="btn btn-gold">
            <i class="fas fa-arrow-left me-2"></i> Back to Orders
        </a>
    <?php else: ?>
        <!-- Order Info Card -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="admin-card-title"><i class="fas fa-info-circle"></i> Summary</h3>
            </div>
            
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="text-muted small mb-1 uppercase tracking-wider">Order ID</div>
                    <div class="text-gold h5 fw-bold mb-0">#<?= e($order['id']) ?></div>
                </div>
                <div class="col-md-3">
                    <div class="text-muted small mb-1 uppercase tracking-wider">Customer</div>
                    <div class="text-white fw-semibold mb-1"><?= e($shipping['name'] ?? $order['name'] ?? 'Guest') ?> <span class="badge bg-secondary ms-1"><?= empty($order['user_id']) ? 'Guest' : 'Member' ?></span></div>
                    <?php if (!empty($shipping['email'] ?? $order['email'])): ?>
                        <div class="text-muted small"><i class="fas fa-envelope me-1"></i> <?= e($shipping['email'] ?? $order['email']) ?></div>
                    <?php endif; ?>
                    <?php if (!empty($shipping['phone'])): ?>
                        <div class="text-muted small"><i class="fas fa-phone me-1"></i> <?= e($shipping['phone']) ?></div>
                    <?php endif; ?>
                </div>
                <div class="col-md-3">
                    <div class="text-muted small mb-1 uppercase tracking-wider">Date & Time</div>
                    <div class="text-white"><?= date('d M Y, h:i A', strtotime($order['created_at'])) ?></div>
                </div>
                <div class="col-md-3">
                    <div class="text-muted small mb-1 uppercase tracking-wider">Total Amount</div>
                    <div class="text-gold h5 fw-bold mb-0">৳<?= number_format($order['total_amount'], 0) ?></div>
                </div>
                <div class="col-md-3">
                    <div class="text-muted small mb-1 uppercase tracking-wider">Status</div>
                    <select class="admin-form-control order-status-select mt-1" data-order-id="<?= $order['id'] ?>" style="width: auto;">
                        <option value="pending" <?= $order['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="processing" <?= $order['status'] === 'processing' ? 'selected' : '' ?>>Processing</option>
                        <option value="completed" <?= $order['status'] === 'completed' ? 'selected' : '' ?>>Completed</option>
                        <option value="cancelled" <?= $order['status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-9">
                    <div class="text-muted small mb-1 uppercase tracking-wider">Shipping Address</div>
                    <div class="text-white">
                        <?= e($shipping['address'] ?? '') ?>, 
                        <?= e($shipping['city'] ?? '') ?> <?= e($shipping['postal_code'] ?? '') ?>
                        <?php if(!empty($shipping['landmark'])): ?>
                            <br><small class="text-gold"><i class="fas fa-building me-1"></i> Landmark: <?= e($shipping['landmark']) ?></small>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <?php if(!empty($shipping['latitude']) && !empty($shipping['longitude'])): ?>
            <div class="mt-4 pt-3 border-top border-secondary">
                <div class="text-muted small mb-2"><i class="fas fa-map-marker-alt me-1"></i> Pinpointed Location (Customer Provided)</div>
                <div id="admin-order-map" style="height: 350px; width: 100%; border-radius: 12px; border: 1px solid rgba(255,255,255,0.1); z-index: 1;"></div>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        var lat = <?= json_encode($shipping['latitude']) ?>;
                        var lng = <?= json_encode($shipping['longitude']) ?>;
                        if(lat && lng) {
                            var map = L.map('admin-order-map').setView([lat, lng], 16);
                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                maxZoom: 19,
                                attribution: '© OpenStreetMap'
                            }).addTo(map);
                            L.marker([lat, lng]).addTo(map)
                                .bindPopup('<b>Delivery Point</b><br><?= e($shipping['address'] ?? '') ?>')
                                .openPopup();
                        }
                    });
                </script>
            </div>
            <?php endif; ?>
        </div>

        <!-- Order Items Card -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="admin-card-title"><i class="fas fa-boxes"></i> Items Purchased</h3>
            </div>
            
            <?php if (!empty($items)): ?>
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Thumbnail</th>
                                <th>Unit Price</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $item): ?>
                            <tr>
                                <td class="fw-bold text-white"><?= e($item['name']) ?></td>
                                <td>
                                    <?php if (!empty($item['image_url'])): ?>
                                        <img src="<?= e($item['image_url']) ?>" alt="<?= e($item['name']) ?>" class="rounded-2" style="width: 50px; height: 50px; object-fit: cover;">
                                    <?php else: ?>
                                        <div class="bg-dark text-muted rounded-2 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                            <i class="fas fa-image"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="text-gold">৳<?= number_format($item['price'], 0) ?></td>
                                <td class="text-white"><?= $item['quantity'] ?></td>
                                <td class="text-gold fw-bold">৳<?= number_format($item['price'] * $item['quantity'], 0) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4" class="text-end text-muted">Grand Total</th>
                                <th class="text-gold h5 fw-bold">৳<?= number_format($order['total_amount'], 0) ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                    No items found for this order.
                </div>
            <?php endif; ?>
        </div>

        <!-- Actions -->
        <div class="mt-4">
            <a href="<?= SITE_URL ?>/admin/orders" class="btn btn-dark px-4">
                <i class="fas fa-arrow-left me-2"></i> Back to Orders
            </a>
        </div>
    <?php endif; ?>
</div>

<script>
const SITE_URL = '<?= SITE_URL ?>';
</script>
