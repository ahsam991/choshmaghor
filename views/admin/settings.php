<div class="admin-header">
    <div class="d-flex justify-content-between align-items-center">
        <h2><i class="fas fa-cog text-gold me-2"></i>General Settings</h2>
        <a href="<?= SITE_URL ?>/admin/backup" class="btn btn-outline-gold">
            <i class="fas fa-database me-2"></i>Backup Database
        </a>
    </div>
</div>

<div class="admin-card">
    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?= e($success) ?></div>
    <?php endif; ?>

    <form action="<?= SITE_URL ?>/admin/settings" method="POST">
        <div class="mb-4">
            <h5 class="text-gold border-bottom border-secondary pb-2 mb-3">General Website Settings</h5>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Site Title / Brand Name</label>
                    <input type="text" class="form-control" name="site_title" value="<?= e($settings['site_title'] ?? '') ?>" placeholder="e.g. ChoshmaZone">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Site Logo URL</label>
                    <input type="text" class="form-control" name="site_logo" value="<?= e($settings['site_logo'] ?? '') ?>" placeholder="URL to your logo image">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Primary Color (Hex)</label>
                    <input type="color" class="form-control form-control-color w-100" name="primary_color" value="<?= e($settings['primary_color'] ?? '#D4AF37') ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Contact Phone</label>
                    <input type="text" class="form-control" name="contact_phone" value="<?= e($settings['contact_phone'] ?? '') ?>" placeholder="+8801...">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Contact Email</label>
                    <input type="email" class="form-control" name="contact_email" value="<?= e($settings['contact_email'] ?? '') ?>" placeholder="contact@...">
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Facebook Page Link</label>
                    <input type="url" class="form-control" name="facebook_link" value="<?= e($settings['facebook_link'] ?? '') ?>" placeholder="https://facebook.com/...">
                </div>
            </div>
        </div>

        <div class="mb-4">
            <h5 class="text-gold border-bottom border-secondary pb-2 mb-3">Homepage Settings</h5>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Limited Time Offer End Date & Time</label>
                    <input type="datetime-local" class="form-control" name="promo_end_time" value="<?= e($settings['promo_end_time'] ?? '') ?>" placeholder="Leave empty to disable">
                    <small class="text-muted">E.g., for setting the "Ending in: 05 Hours" countdown on the homepage. Leave blank to hide the countdown.</small>
                </div>
            </div>
        </div>

        <div class="mb-5">
            <h5 class="text-gold border-bottom border-secondary pb-2 mb-3">Promotion Popup Settings</h5>
            
            <div class="mb-3 form-check form-switch">
                <input class="form-check-input" type="checkbox" id="popup_enabled" name="popup_enabled" value="1" <?= ($settings['popup_enabled'] ?? '0') === '1' ? 'checked' : '' ?>>
                <label class="form-check-label" for="popup_enabled">Enable Promotion Popup</label>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Popup Title</label>
                    <input type="text" class="form-control" name="popup_title" value="<?= e($settings['popup_title'] ?? '') ?>" placeholder="e.g. Eid Mega Sale!">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Popup Image URL</label>
                    <input type="text" class="form-control" name="popup_image" value="<?= e($settings['popup_image'] ?? '') ?>" placeholder="URL to promotional image">
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Popup Content / Description</label>
                    <textarea class="form-control" name="popup_content" rows="3" placeholder="Description of the offer..."><?= e($settings['popup_content'] ?? '') ?></textarea>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Button Link</label>
                    <input type="text" class="form-control" name="popup_link" value="<?= e($settings['popup_link'] ?? '') ?>" placeholder="e.g. /shop?category=1">
                    <small class="text-muted">Where the user goes when they click "Shop Now" in the popup.</small>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-gold px-4 py-2">
                <i class="fas fa-save me-2"></i>Save Settings
            </button>
        </div>
    </form>
</div>
