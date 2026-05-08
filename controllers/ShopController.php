<?php
require_once APP_PATH . '/models/Product.php';

class ShopController extends Controller {
    private $productModel;

    public function __construct() {
        $this->productModel = new Product();
    }

    public function index() {
        $filters = [
            'category_id' => $_GET['category'] ?? null,
            'search' => $_GET['search'] ?? null,
            'sort' => $_GET['sort'] ?? 'newest',
            'gender' => $_GET['gender'] ?? null,
            'min_price' => $_GET['min_price'] ?? null,
            'max_price' => $_GET['max_price'] ?? null
        ];

        $products = $this->productModel->getAll($filters);
        
        // In a real app, categories would come from a Category model
        $categories = [
            ['id' => 1, 'name' => 'Sunglasses', 'product_count' => count($products)],
            ['id' => 2, 'name' => 'Frames', 'product_count' => 0]
        ];

        $this->render('shop/index', [
            'products' => $products,
            'categories' => $categories,
            'filters' => $filters,
            'total' => count($products),
            'totalPages' => 1,
            'page' => 1
        ]);
    }

    public function product($id) {
        $product = $this->productModel->getById($id);
        
        if (!$product) {
            header("Location: " . SITE_URL . "/shop");
            exit;
        }

        $related = $this->productModel->getFeatured(); // Simple related products

        $this->render('shop/product', [
            'product' => $product,
            'related' => $related
        ]);
    }
}

