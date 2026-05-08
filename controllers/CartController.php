<?php
require_once APP_PATH . '/models/Product.php';

class CartController extends Controller {
    private $productModel;

    public function __construct() {
        $this->productModel = new Product();
    }

    private function calculateCartTotals() {
        $subtotal = 0;
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $id => $qty) {
                $product = $this->productModel->getById($id);
                if ($product) {
                    $price = ($product['discount_price'] > 0) ? $product['discount_price'] : $product['price'];
                    $subtotal += $price * $qty;
                }
            }
        }
        return [
            'subtotal' => $subtotal,
            'total' => $subtotal + 60, // Assuming 60 is shipping
            'formatted_subtotal' => CURRENCY . number_format($subtotal, 2),
            'formatted_total' => CURRENCY . number_format($subtotal + 60, 2)
        ];
    }

    // Display cart page
    public function index() {
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        $items = [];
        $total = 0;

        foreach ($cart as $product_id => $quantity) {
            $product = $this->productModel->getById($product_id);
            if ($product) {
                $items[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'subtotal' => $product['price'] * $quantity
                ];
                $total += $product['price'] * $quantity;
            }
        }

        $this->render('cart/index', [
            'items' => $items,
            'total' => $total
        ]);
    }

    // Add to cart via AJAX
    public function add() {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
            exit;
        }

        $product_id = intval($_POST['product_id'] ?? 0);
        $quantity = intval($_POST['quantity'] ?? 1);

        if ($product_id <= 0 || $quantity <= 0) {
            echo json_encode(['success' => false, 'message' => 'Invalid product or quantity']);
            exit;
        }

        // Verify product exists and has stock
        $product = $this->productModel->getById($product_id);
        if (!$product) {
            echo json_encode(['success' => false, 'message' => 'Product not found']);
            exit;
        }

        if ($product['stock_quantity'] < $quantity) {
            echo json_encode(['success' => false, 'message' => 'Insufficient stock']);
            exit;
        }

        // Initialize cart session if empty
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Add or update product in cart
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] += $quantity;
        } else {
            $_SESSION['cart'][$product_id] = $quantity;
        }

        $totals = $this->calculateCartTotals();

        echo json_encode([
            'success' => true,
            'message' => 'Product added to cart',
            'cart_count' => count($_SESSION['cart']),
            'totals' => $totals
        ]);
        exit;
    }

    // Remove from cart
    public function remove() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
            exit;
        }

        header('Content-Type: application/json');

        $product_id = intval($_POST['product_id'] ?? 0);

        if ($product_id <= 0) {
            echo json_encode(['success' => false, 'message' => 'Invalid product']);
            exit;
        }

        if (isset($_SESSION['cart'][$product_id])) {
            unset($_SESSION['cart'][$product_id]);
            $totals = $this->calculateCartTotals();
            echo json_encode([
                'success' => true,
                'message' => 'Product removed from cart',
                'cart_count' => count($_SESSION['cart']),
                'totals' => $totals
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Product not in cart']);
        }
        exit;
    }

    // Update cart quantity
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
            exit;
        }

        header('Content-Type: application/json');

        $product_id = intval($_POST['product_id'] ?? 0);
        $quantity = intval($_POST['quantity'] ?? 1);

        if ($product_id <= 0) {
            echo json_encode(['success' => false, 'message' => 'Invalid product']);
            exit;
        }

        if ($quantity <= 0) {
            // If quantity is 0 or negative, remove from cart
            if (isset($_SESSION['cart'][$product_id])) {
                unset($_SESSION['cart'][$product_id]);
            }
        } else {
            // Check stock availability
            $product = $this->productModel->getById($product_id);
            if (!$product) {
                echo json_encode(['success' => false, 'message' => 'Product not found']);
                exit;
            }

            if ($product['stock_quantity'] < $quantity) {
                echo json_encode(['success' => false, 'message' => 'Insufficient stock']);
                exit;
            }

            $_SESSION['cart'][$product_id] = $quantity;
        }

        $item_subtotal_formatted = '';
        if ($quantity > 0 && isset($product)) {
            $price = ($product['discount_price'] > 0) ? $product['discount_price'] : $product['price'];
            $item_subtotal_formatted = CURRENCY . number_format($price * $quantity, 2);
        }

        $totals = $this->calculateCartTotals();

        echo json_encode([
            'success' => true,
            'message' => 'Cart updated',
            'cart_count' => count($_SESSION['cart']),
            'item_subtotal_formatted' => $item_subtotal_formatted,
            'totals' => $totals
        ]);
        exit;
    }

    // Clear entire cart
    public function clear() {
        header('Content-Type: application/json');

        $_SESSION['cart'] = [];
        echo json_encode([
            'success' => true,
            'message' => 'Cart cleared'
        ]);
        exit;
    }
}
