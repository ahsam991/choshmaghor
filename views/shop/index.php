<div class="page-header">
    <div class="container">
        <h1><?= __('shop') ?></h1>
        <div class="breadcrumb">
            <a href="<?= SITE_URL ?>">Home</a>
            <span class="sep">/</span>
            <span>Shop</span>
        </div>
    </div>
</div>

<div class="container">
    <div class="shop-layout">
        <!-- Sidebar Filters -->
        <aside class="filter-sidebar">
            <div class="filter-title">
                <i class="fas fa-sliders-h"></i> Filters
            </div>
            
            <form method="GET" action="<?= SITE_URL ?>/shop" id="filter-form">
                <!-- Search -->
                <div class="filter-section">
                    <span class="filter-label">Search</span>
                    <input type="text" name="search" class="filter-input" placeholder="Product name..." value="<?= isset($filters['search']) ? e($filters['search']) : '' ?>">
                </div>

                <!-- Categories -->
                <div class="filter-section">
                    <span class="filter-label">Categories</span>
                    <?php foreach ($categories as $cat): ?>
                    <label class="filter-check">
                        <input type="radio" name="category" value="<?= $cat['id'] ?>" 
                            <?= (isset($filters['category_id']) && $filters['category_id'] == $cat['id']) ? 'checked' : '' ?>>
                        <span class="filter-check-label"><?= e($cat['name']) ?></span>
                        <small class="text-dim">(<?= $cat['product_count'] ?>)</small>
                    </label>
                    <?php endforeach; ?>
                </div>

                <!-- Gender -->
                <div class="filter-section">
                    <span class="filter-label">Gender</span>
                    <label class="filter-check">
                        <input type="radio" name="gender" value="" <?= empty($filters['gender']) ? 'checked' : '' ?>>
                        <span class="filter-check-label">All</span>
                    </label>
                    <label class="filter-check">
                        <input type="radio" name="gender" value="male" <?= (isset($filters['gender']) && $filters['gender'] === 'male') ? 'checked' : '' ?>>
                        <span class="filter-check-label">Mens</span>
                    </label>
                    <label class="filter-check">
                        <input type="radio" name="gender" value="female" <?= (isset($filters['gender']) && $filters['gender'] === 'female') ? 'checked' : '' ?>>
                        <span class="filter-check-label">Womens</span>
                    </label>
                </div>

                <!-- Price Range -->
                <div class="filter-section">
                    <span class="filter-label">Price Range</span>
                    <div class="price-range-grid">
                        <input type="number" name="min_price" class="filter-input" placeholder="Min" value="<?= $filters['min_price'] ?? '' ?>">
                        <input type="number" name="max_price" class="filter-input" placeholder="Max" value="<?= $filters['max_price'] ?? '' ?>">
                    </div>
                </div>

                <button type="submit" class="btn btn-gold btn-full mt-3">Apply Filters</button>
                <a href="<?= SITE_URL ?>/shop" class="btn btn-dark btn-full mt-2">Reset</a>
            </form>
        </aside>

        <!-- Product Listing -->
        <main class="shop-main">
            <!-- Toolbar -->
            <div class="shop-toolbar">
                <div class="results-count">
                    Showing <span><?= $total ?></span> products found
                </div>
                <div class="sort-wrap">
                    <select class="sort-select" onchange="window.location='<?= SITE_URL ?>/shop?sort='+this.value">
                        <option value="newest" <?= (isset($filters['sort']) && $filters['sort'] === 'newest') ? 'selected' : '' ?>>Newest First</option>
                        <option value="price_asc" <?= (isset($filters['sort']) && $filters['sort'] === 'price_asc') ? 'selected' : '' ?>>Price: Low to High</option>
                        <option value="price_desc" <?= (isset($filters['sort']) && $filters['sort'] === 'price_desc') ? 'selected' : '' ?>>Price: High to Low</option>
                        <option value="name_asc" <?= (isset($filters['sort']) && $filters['sort'] === 'name_asc') ? 'selected' : '' ?>>Name: A to Z</option>
                    </select>
                </div>
            </div>

            <?php if (empty($products)): ?>
            <div class="empty-state">
                <div class="empty-state-icon">🔍</div>
                <h3>No products found</h3>
                <p>Try adjusting your filters or search terms.</p>
                <a href="<?= SITE_URL ?>/shop" class="btn btn-gold">Browse All Products</a>
            </div>
            <?php else: ?>
            <div class="shop-products-grid">
                <?php foreach ($products as $product): ?>
                <?php include APP_PATH . '/views/shop/product_card.php'; ?>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <?php if ($totalPages > 1): ?>
            <div class="pagination">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?<?= http_build_query(array_merge($filters, ['page' => $i])) ?>" class="page-btn <?= $i === $page ? 'active' : '' ?>">
                    <?= $i ?>
                </a>
                <?php endfor; ?>
            </div>
            <?php endif; ?>
            <?php endif; ?>
        </main>
    </div>
</div>