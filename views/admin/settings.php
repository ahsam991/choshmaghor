<div class="admin-page-header">
    <div>
        <h1 class="admin-page-title"><i class="fas fa-cog"></i> General Settings</h1>
        <p class="admin-page-sub">Manage your website branding, contact info, and global configurations.</p>
    </div>
</div>

<?php if (isset($_GET['success'])): ?>
<div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
    <strong>Success!</strong> Your settings have been updated and applied instantly.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<form action="<?= SITE_URL ?>/admin/settings" method="POST">
    <div class="row">
        <!-- Branding & Identity -->
        <div class="col-lg-8">
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title"><i class="fas fa-branding"></i> Site Identity</h2>
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label">Site Title</label>
                    <input type="text" name="site_title" class="admin-form-control" value="<?= e($settings['site_title'] ?? 'ChoshmaZone') ?>" placeholder="e.g. ChoshmaZone">
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label">Site Tagline</label>
                    <input type="text" name="site_tagline" class="admin-form-control" value="<?= e($settings['site_tagline'] ?? '') ?>" placeholder="e.g. Premium Sunglasses Store">
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label">Logo URL</label>
                    <div class="input-group">
                        <input type="text" name="site_logo" id="logo_url" class="admin-form-control" value="<?= e($settings['site_logo'] ?? '') ?>" placeholder="https://example.com/logo.png">
                    </div>
                    <p class="text-muted mt-2 small">Provide a direct link to your logo image or upload one to assets/images/.</p>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title"><i class="fas fa-headset"></i> Contact Details</h2>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="admin-form-group">
                            <label class="admin-form-label">Support Email</label>
                            <input type="email" name="contact_email" class="admin-form-control" value="<?= e($settings['contact_email'] ?? '') ?>" placeholder="info@choshmazone.com">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="admin-form-group">
                            <label class="admin-form-label">Support Phone</label>
                            <input type="text" name="contact_phone" class="admin-form-control" value="<?= e($settings['contact_phone'] ?? '') ?>" placeholder="+880 1XXX XXXXXX">
                        </div>
                    </div>
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label">Store Address</label>
                    <textarea name="contact_address" class="admin-form-control" placeholder="123 Street, Dhaka, Bangladesh"><?= e($settings['contact_address'] ?? '') ?></textarea>
                </div>
            </div>
        </div>

        <!-- Sidebar Settings -->
        <div class="col-lg-4">
            <!-- Appearance -->
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title"><i class="fas fa-palette"></i> Appearance</h2>
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label">Currency Symbol</label>
                    <input type="text" name="currency" class="admin-form-control" value="<?= e($settings['currency'] ?? '৳') ?>" placeholder="৳ or $">
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label">Primary Brand Color</label>
                    <div class="d-flex gap-2">
                        <input type="color" name="theme_color" class="form-control form-control-color" value="<?= e($settings['theme_color'] ?? '#c9a84c') ?>" title="Choose brand color">
                        <input type="text" class="admin-form-control" value="<?= e($settings['theme_color'] ?? '#c9a84c') ?>" readonly>
                    </div>
                </div>
            </div>

            <!-- Social Links -->
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title"><i class="fas fa-share-alt"></i> Social Media</h2>
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label"><i class="fab fa-facebook text-primary me-2"></i> Facebook URL</label>
                    <input type="text" name="facebook" class="admin-form-control" value="<?= e($settings['social_links']['facebook'] ?? '') ?>" placeholder="https://facebook.com/choshmazone">
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label"><i class="fab fa-instagram text-danger me-2"></i> Instagram URL</label>
                    <input type="text" name="instagram" class="admin-form-control" value="<?= e($settings['social_links']['instagram'] ?? '') ?>" placeholder="https://instagram.com/choshmazone">
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label"><i class="fab fa-whatsapp text-success me-2"></i> WhatsApp Number</label>
                    <input type="text" name="whatsapp" class="admin-form-control" value="<?= e($settings['social_links']['whatsapp'] ?? '') ?>" placeholder="8801XXXXXXXXX">
                </div>
            </div>

            <div class="sticky-top" style="top: 100px;">
                <button type="submit" class="btn btn-gold w-100 py-3 shadow-gold">
                    <i class="fas fa-save me-2"></i> Save All Settings
                </button>
            </div>
        </div>
    </div>
</form>
