<?php
require_once APP_PATH . '/models/Product.php';

class ProductController extends Controller {
    private $productModel;

    public function __construct() {
        $this->productModel = new Product();
    }

    // View single product
    public function view() {
        $product_id = intval($GLOBALS['product_id'] ?? 0);

        if ($product_id <= 0) {
            header('Location: ' . SITE_URL . '/shop');
            exit;
        }

        $product = $this->productModel->getById($product_id);

        if (!$product) {
            header('Location: ' . SITE_URL . '/shop');
            exit;
        }

        // Get related products (same category)
        $related = [];
        if ($product['category_id']) {
            $related = $this->productModel->getAll([
                'category_id' => $product['category_id']
            ]);
            // Remove current product from related
            $related = array_filter($related, function($p) use ($product_id) {
                return $p['id'] != $product_id;
            });
        }

        $this->render('shop/product', [
            'product' => $product,
            'related' => array_slice($related, 0, 4)
        ]);
    }
}
