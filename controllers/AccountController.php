<?php
require_once APP_PATH . '/models/Order.php';

class AccountController extends Controller {
    private $orderModel;

    public function __construct() {
        if (!$this->isLoggedIn()) {
            header('Location: ' . SITE_URL . '/auth/login');
            exit;
        }
        $this->orderModel = new Order();
    }

    // User Account Dashboard
    public function index() {
        $user_id = $_SESSION['user_id'];

        // Get user orders
        $orders = $this->orderModel->getByUser($user_id);

        // Get user info
        $stmt = Database::getInstance()->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->render('account/index', [
            'user' => $user,
            'orders' => $orders
        ]);
    }

    // View single order
    public function order() {
        $user_id = $_SESSION['user_id'];
        $order_id = intval($GLOBALS['order_id'] ?? 0);

        $order = $this->orderModel->getById($order_id);

        // Verify order belongs to user
        if (!$order || ($order['user_id'] != $user_id && !$this->isAdmin())) {
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

    // Update Profile
    public function updateProfile() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(400);
            exit;
        }

        header('Content-Type: application/json');

        $user_id = $_SESSION['user_id'];
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');

        if (empty($name) || empty($email)) {
            echo json_encode(['success' => false, 'message' => 'Name and email are required']);
            exit;
        }

        $stmt = Database::getInstance()->prepare("UPDATE users SET name = :name, email = :email WHERE id = :id");
        $result = $stmt->execute([
            'name' => $name,
            'email' => $email,
            'id' => $user_id
        ]);

        if ($result) {
            $_SESSION['user_name'] = $name;
            echo json_encode(['success' => true, 'message' => 'Profile updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update profile']);
        }
        exit;
    }

    // Change Password
    public function changePassword() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(400);
            exit;
        }

        header('Content-Type: application/json');

        $user_id = $_SESSION['user_id'];
        $current_password = $_POST['current_password'] ?? '';
        $new_password = $_POST['new_password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
            echo json_encode(['success' => false, 'message' => 'All fields are required']);
            exit;
        }

        if ($new_password !== $confirm_password) {
            echo json_encode(['success' => false, 'message' => 'Passwords do not match']);
            exit;
        }

        // Verify current password
        $stmt = Database::getInstance()->prepare("SELECT password FROM users WHERE id = :id");
        $stmt->execute(['id' => $user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!password_verify($current_password, $user['password'])) {
            echo json_encode(['success' => false, 'message' => 'Current password is incorrect']);
            exit;
        }

        // Update password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = Database::getInstance()->prepare("UPDATE users SET password = :password WHERE id = :id");
        $result = $stmt->execute([
            'password' => $hashed_password,
            'id' => $user_id
        ]);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Password changed successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to change password']);
        }
        exit;
    }

    // Wishlist view
    public function wishlist() {
        $wishlist_ids = [];
        if (isset($_COOKIE['choshmazone_wishlist'])) {
            $wishlist_ids = json_decode($_COOKIE['choshmazone_wishlist'], true);
        }
        
        $products = [];
        if (!empty($wishlist_ids) && is_array($wishlist_ids)) {
            require_once APP_PATH . '/models/Product.php';
            $productModel = new Product();
            
            // Fetch products by id
            foreach ($wishlist_ids as $id) {
                $product = $productModel->getById($id);
                if ($product) {
                    $products[] = $product;
                }
            }
        }
        
        $this->render('account/wishlist', [
            'products' => $products
        ]);
    }
}
