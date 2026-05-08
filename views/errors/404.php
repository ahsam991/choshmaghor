<div class="page-header text-center" style="padding: 100px 0;">
    <div class="container">
        <h1 style="font-size: 120px; font-weight: 800; color: var(--gold); line-height: 1; margin-bottom: 20px;">404</h1>
        <h2 style="font-size: 32px; font-weight: 600; margin-bottom: 20px;">Oops! Page Not Found</h2>
        <p style="font-size: 18px; color: var(--text-muted); max-width: 600px; margin: 0 auto 40px;">
            The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.
        </p>
        
        <form action="<?= SITE_URL ?>/shop" method="GET" style="max-width: 500px; margin: 0 auto 40px; display: flex; gap: 10px;">
            <input type="text" name="q" placeholder="Search products..." class="form-control" style="flex-grow: 1; padding: 15px 20px; border-radius: 30px; border: 1px solid var(--border); background: var(--card-bg); color: var(--text);">
            <button type="submit" class="btn btn-gold" style="border-radius: 30px; padding: 0 30px;"><i class="fas fa-search"></i></button>
        </form>
        
        <div style="display: flex; gap: 15px; justify-content: center;">
            <a href="<?= SITE_URL ?>" class="btn btn-gold btn-lg"><i class="fas fa-home me-2"></i> Go Home</a>
            <a href="<?= SITE_URL ?>/shop" class="btn btn-outline-gold btn-lg"><i class="fas fa-shopping-bag me-2"></i> Browse Shop</a>
        </div>
    </div>
</div>
