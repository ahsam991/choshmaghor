<div class="page-header">
    <div class="container d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-receipt"></i> অর্ডার বিস্তারিত</h1>
        <?php if ($order): 
            $shipping = json_decode($order['shipping_address'] ?? '{}', true);
        ?>
            <div>
                <?php if (!empty($shipping['phone'])): ?>
                    <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $shipping['phone']) ?>" class="btn btn-outline-gold" target="_blank">
                        <i class="fab fa-whatsapp me-2"></i> Message Customer
                    </a>
                <?php endif; ?>
                <a href="<?= SITE_URL ?>/admin/invoice/<?= $order['id'] ?>" class="btn btn-gold ms-2" target="_blank">
                    <i class="fas fa-print me-2"></i> Print Cash Memo
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Leaflet CSS for Admin -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<div class="container" style="padding: 20px 0;">
    <?php if (!$order): ?>
        <div class="alert alert-danger" style="background: rgba(224, 84, 84, 0.15); color: var(--red); padding: 16px; border-radius: 8px; margin-bottom: 24px; border: 1px solid rgba(224, 84, 84, 0.3);">
            <i class="fas fa-exclamation-circle me-2"></i> অর্ডার পাওয়া যায়নি।
        </div>
        <a href="<?= SITE_URL ?>/admin/orders" class="btn btn-gold">
            <i class="fas fa-arrow-left"></i> অর্ডারে ফিরে যান
        </a>
    <?php else: ?>
        <!-- Order Info Card -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="admin-card-title"><i class="fas fa-info-circle"></i> অর্ডার তথ্য</h3>
            </div>
            
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
                <div>
                    <div style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 4px;">অর্ডার আইডি</div>
                    <div style="color: var(--gold); font-weight: 700; font-size: 1.2rem;">#<?= e($order['id']) ?></div>
                </div>
                <div>
                    <div style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 4px;">গ্রাহক</div>
                    <div style="color: var(--white); font-weight: 600;"><?= e($shipping['name'] ?? $order['name'] ?? 'অতিথি') ?> <span class="badge bg-secondary"><?= empty($order['user_id']) ? 'Guest' : 'Member' ?></span></div>
                    <?php if (!empty($shipping['email'] ?? $order['email'])): ?>
                        <div style="color: var(--text-muted); font-size: 0.85rem;"><i class="fas fa-envelope"></i> <?= e($shipping['email'] ?? $order['email']) ?></div>
                    <?php endif; ?>
                    <?php if (!empty($shipping['phone'])): ?>
                        <div style="color: var(--text-muted); font-size: 0.85rem;"><i class="fas fa-phone"></i> <?= e($shipping['phone']) ?></div>
                    <?php endif; ?>
                </div>
                <div>
                    <div style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 4px;">তারিখ</div>
                    <div style="color: var(--white);"><?= date('d M Y, h:i A', strtotime($order['created_at'])) ?></div>
                </div>
                <div>
                    <div style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 4px;">মোট মূল্য</div>
                    <div style="color: var(--gold); font-weight: 700; font-size: 1.2rem;">৳<?= number_format($order['total_amount'], 0) ?></div>
                </div>
                <div>
                    <div style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 4px;">স্ট্যাটাস</div>
                    <select class="admin-form-control order-status-select" data-order-id="<?= $order['id'] ?>" style="width: auto; padding: 8px 12px; font-size: 0.9rem;">
                        <option value="pending" <?= $order['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="processing" <?= $order['status'] === 'processing' ? 'selected' : '' ?>>Processing</option>
                        <option value="completed" <?= $order['status'] === 'completed' ? 'selected' : '' ?>>Completed</option>
                        <option value="cancelled" <?= $order['status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                    </select>
                </div>
                <div>
                    <div style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 4px;">শিপিং ঠিকানা</div>
                    <div style="color: var(--white);">
                        <?= e($shipping['address'] ?? '') ?><br>
                        <?= e($shipping['city'] ?? '') ?> <?= e($shipping['postal_code'] ?? '') ?>
                        <?php if(!empty($shipping['landmark'])): ?>
                            <br><small style="color: var(--gold);"><i class="fas fa-building"></i> <?= e($shipping['landmark']) ?></small>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <?php if(!empty($shipping['latitude']) && !empty($shipping['longitude'])): ?>
            <div class="mt-4">
                <div style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 8px;"><i class="fas fa-map-marker-alt"></i> পিন করা লোকেশন (Customer Location)</div>
                <div id="admin-order-map" style="height: 300px; width: 100%; border-radius: 8px; border: 1px solid var(--border-color); z-index: 1;"></div>
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
                                .bindPopup('<b>Customer Location</b><br><?= e($shipping['address'] ?? '') ?>')
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
                <h3 class="admin-card-title"><i class="fas fa-boxes"></i> অর্ডার আইটেম</h3>
            </div>
            
            <?php if (!empty($items)): ?>
                <div style="overflow-x: auto;">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>পণ্য</th>
                                <th>ছবি</th>
                                <th>মূল্য</th>
                                <th>পরিমাণ</th>
                                <th>মোট</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $item): ?>
                            <tr>
                                <td style="font-weight: 600; color: var(--white);"><?= e($item['name']) ?></td>
                                <td>
                                    <?php if (!empty($item['image_url'])): ?>
                                        <img src="<?= e($item['image_url']) ?>" alt="<?= e($item['name']) ?>" style="width: 60px; height: 60px; object-fit: cover; border-radius: 6px;">
                                    <?php else: ?>
                                        <div style="width: 60px; height: 60px; background: var(--dark-3); border-radius: 6px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-image" style="color: var(--text-muted);"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td style="color: var(--gold);">৳<?= number_format($item['price'], 0) ?></td>
                                <td style="color: var(--white);"><?= $item['quantity'] ?></td>
                                <td style="color: var(--gold); font-weight: 700;">৳<?= number_format($item['price'] * $item['quantity'], 0) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div style="text-align: center; padding: 40px; color: var(--text-muted);">
                    <i class="fas fa-inbox" style="font-size: 3rem; margin-bottom: 16px; display: block;"></i>
                    কোনো আইটেম পাওয়া যায়নি।
                </div>
            <?php endif; ?>
        </div>

        <!-- Back Button -->
        <div style="margin-top: 24px;">
            <a href="<?= SITE_URL ?>/admin/orders" class="btn btn-dark">
                <i class="fas fa-arrow-left"></i> অর্ডারে ফিরে যান
            </a>
        </div>
    <?php endif; ?>
</div>

<script>
const SITE_URL = '<?= SITE_URL ?>';
</script>
