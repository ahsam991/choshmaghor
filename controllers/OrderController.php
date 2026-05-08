<?php
require_once APP_PATH . '/models/Order.php';
require_once APP_PATH . '/models/Product.php';
require_once APP_PATH . '/core/Notification.php';

class OrderController extends Controller {
    private $orderModel;
    private $productModel;

    public function __construct() {
        $this->orderModel = new Order();
        $this->productModel = new Product();
    }

    // Checkout - Display checkout form
    public function checkout() {
        if (empty($_SESSION['cart'])) {
            header('Location: ' . SITE_URL . '/cart');
            exit;
        }

        $cart = $_SESSION['cart'];
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

        $this->render('checkout/index', [
            'items' => $items,
            'total' => $total
        ]);
    }

    // Process checkout
    public function process() {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
            exit;
        }

        if (empty($_SESSION['cart'])) {
            echo json_encode(['success' => false, 'message' => 'Cart is empty']);
            exit;
        }

        // Get form data
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $address = trim($_POST['address'] ?? '');
        $city = trim($_POST['city'] ?? '');
        $postal_code = trim($_POST['postal_code'] ?? '');
        $landmark = trim($_POST['landmark'] ?? '');
        $latitude = trim($_POST['latitude'] ?? '');
        $longitude = trim($_POST['longitude'] ?? '');
        $payment_method = trim($_POST['payment_method'] ?? 'cod');

        // Validate inputs
        if (empty($name) || empty($email) || empty($phone) || empty($address) || empty($city)) {
            echo json_encode(['success' => false, 'message' => 'All fields are required']);
            exit;
        }

        // Calculate total
        $cart = $_SESSION['cart'];
        $total = 0;

        foreach ($cart as $product_id => $quantity) {
            $product = $this->productModel->getById($product_id);
            if ($product) {
                $total += $product['price'] * $quantity;
            }
        }

        // Prepare shipping address
        $shipping_array = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'address' => $address,
            'city' => $city,
            'postal_code' => $postal_code,
            'landmark' => $landmark,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'payment_method' => $payment_method
        ];
        $shipping_address = json_encode($shipping_array);

        // Create order
        $user_id = $this->isLoggedIn() ? $_SESSION['user_id'] : null;

        $order_data = [
            'user_id' => $user_id,
            'total_amount' => $total,
            'status' => 'pending',
            'shipping_address' => $shipping_address
        ];

        if ($this->orderModel->create($order_data)) {
            $order_id = $this->orderModel->getLastInsertId();

            // Add order items
            foreach ($cart as $product_id => $quantity) {
                $product = $this->productModel->getById($product_id);
                if ($product) {
                    $this->orderModel->addItem($order_id, $product_id, $quantity, $product['price']);

                    // Reduce stock
                    $this->productModel->updateStock($product_id, $product['stock_quantity'] - $quantity);
                }
            }

            // Fetch order items for notifications
            $items = $this->orderModel->getItems($order_id);
            $order = ['id' => $order_id, 'total_amount' => $total];

            // Send Notifications
            Notification::sendWhatsAppOrderAlert($order, $items, $shipping_array);
            Notification::sendEmailConfirmation($order, $items, $shipping_array);

            // Clear cart
            $_SESSION['cart'] = [];

            echo json_encode([
                'success' => true,
                'message' => 'Order placed successfully',
                'order_id' => $order_id,
                'redirect' => SITE_URL . '/checkout/success/' . $order_id
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to create order']);
        }
        exit;
    }

    // Order success page
    public function success() {
        $order_id = intval($GLOBALS['order_id'] ?? 0);

        if ($order_id <= 0) {
            header('Location: ' . SITE_URL);
            exit;
        }

        $order = $this->orderModel->getById($order_id);
        if (!$order) {
            header('Location: ' . SITE_URL);
            exit;
        }

        $items = $this->orderModel->getItems($order_id);

        $this->render('checkout/success', [
            'order' => $order,
            'items' => $items
        ]);
    }

    // View order (user dashboard)
    public function view() {
        if (!$this->isLoggedIn()) {
            header('Location: ' . SITE_URL . '/auth/login');
            exit;
        }

        $order_id = intval($GLOBALS['order_id'] ?? 0);
        $order = $this->orderModel->getById($order_id);

        // Check if order belongs to user
        if (!$order || $order['user_id'] != $_SESSION['user_id']) {
            http_response_code(403);
            echo "Access denied";
            exit;
        }

        $items = $this->orderModel->getItems($order_id);

        $this->render('account/order', [
            'order' => $order,
            'items' => $items
        ]);
    }
}
