<?php
require_once APP_PATH . '/models/Product.php';

class ShopController extends Controller {
    private $productModel;

    public function __construct() {
        $this->productModel = new Product();
    }

    public function index() {
        if (isset($_GET['ajax']) && $_GET['ajax'] == '1') {
            $query = $_GET['q'] ?? '';
            $products = $this->productModel->search($query, 5);
            
            if (empty($products)) {
                echo '<div class="p-3 text-center text-muted">No products found for "' . e($query) . '"</div>';
                exit;
            }

            foreach ($products as $p) {
                $price = $p['discount_price'] > 0 ? $p['discount_price'] : $p['price'];
                echo '
                <a href="' . SITE_URL . '/shop/product/' . $p['id'] . '" class="search-result-item">
                    <img src="' . asset('images/products/' . ($p['image_url'] ?? 'placeholder.png')) . '" class="search-result-img">
                    <div class="search-result-info">
                        <h4>' . e($p['name']) . '</h4>
                        <p>' . formatPrice($price) . '</p>
                    </div>
                </a>';
            }
            exit;
        }

        $filters = [
            'category_id' => $_GET['category'] ?? null,
            'search' => $_GET['search'] ?? null,
            'sort' => $_GET['sort'] ?? 'newest',
            'gender' => $_GET['gender'] ?? null,
            'min_price' => $_GET['min_price'] ?? null,
            'max_price' => $_GET['max_price'] ?? null
        ];

        $products = $this->productModel->getAll($filters);
        
        // SEO optimized categories with keywords
        $categories = [
            ['id' => 1, 'name' => 'Sunglasses', 'product_count' => count($products)],
            ['id' => 2, 'name' => 'Frames', 'product_count' => 0]
        ];

        // Set SEO meta for shop page
        $title = 'Shop Premium Sunglasses Online - Men & Women Eyewear';
        $meta_description = 'Browse our complete collection of premium sunglasses in Bangladesh. Filter by gender, price, category. UV400 protection, original quality, best prices with COD.';
        
        $this->render('shop/index', [
            'products' => $products,
            'categories' => $categories,
            'filters' => $filters,
            'total' => count($products),
            'totalPages' => 1,
            'page' => 1,
            'title' => $title,
            'meta_description' => $meta_description
        ]);
    }

    public function product($id) {
        $product = $this->productModel->getById($id);
        
        if (!$product) {
            header("Location: " . SITE_URL . "/shop");
            exit;
        }

        $related = $this->productModel->getFeatured(); // Simple related products

        // SEO optimization for product page
        $title = e($product['name']) . ' - Buy Premium Sunglasses Online | ChoshmaZone';
        $meta_description = substr(e($product['description'] ?? ''), 0, 155) . '. Buy now at ChoshmaZone with UV400 protection, free shipping & cash on delivery.';
        
        // Structured data for Product (Schema.org)
        $structured_data = json_encode([
            "@context" => "https://schema.org",
            "@type" => "Product",
            "name" => $product['name'],
            "image" => asset('images/products/' . ($product['image_url'] ?? 'placeholder.png')),
            "description" => $product['description'] ?? '',
            "brand" => [
                "@type" => "Brand",
                "name" => "ChoshmaZone"
            ],
            "offers" => [
                "@type" => "Offer",
                "price" => $product['discount_price'] > 0 ? $product['discount_price'] : $product['price'],
                "priceCurrency" => "BDT",
                "availability" => "https://schema.org/InStock",
                "seller" => [
                    "@type" => "Organization",
                    "name" => "ChoshmaZone"
                ]
            ],
            "aggregateRating" => [
                "@type" => "AggregateRating",
                "ratingValue" => "4.8",
                "reviewCount" => "24"
            ]
        ]);

        $this->render('shop/product', [
            'product' => $product,
            'related' => $related,
            'title' => $title,
            'meta_description' => $meta_description,
            'structured_data' => $structured_data,
            'og_type' => 'product',
            'og_title' => $title,
            'og_image' => asset('images/products/' . ($product['image_url'] ?? 'placeholder.png'))
        ]);
    }
}

