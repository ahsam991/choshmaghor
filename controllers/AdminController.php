<?php
require_once APP_PATH . '/models/Product.php';
require_once APP_PATH . '/models/Order.php';

class AdminController extends Controller {
    private $productModel;
    private $orderModel;
    private $db;

    public function __construct() {
        if (!$this->isLoggedIn() || !$this->isAdmin()) {
            header('Location: ' . SITE_URL . '/auth/login');
            exit;
        }
        $this->productModel = new Product();
        $this->orderModel   = new Order();
        $this->db           = Database::getInstance();
    }

    /** Helper: fetch all categories for forms */
    private function getCategories() {
        $stmt = $this->db->prepare('SELECT id, name FROM categories ORDER BY name');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ─── Dashboard ───────────────────────────────────────────────
    public function index() {
        try {
            $productCount = $this->db->query('SELECT COUNT(*) FROM products')->fetchColumn();
            $orderCount   = $this->db->query('SELECT COUNT(*) FROM orders')->fetchColumn();
            $userCount    = $this->db->query('SELECT COUNT(*) FROM users')->fetchColumn();
            $revenue      = $this->db->query('SELECT COALESCE(SUM(total_amount),0) FROM orders')->fetchColumn();

            $stmt = $this->db->prepare('
                SELECT o.id, o.total_amount, o.status, o.created_at, u.name
                FROM orders o
                LEFT JOIN users u ON o.user_id = u.id
                ORDER BY o.created_at DESC
                LIMIT 8
            ');
            $stmt->execute();
            $recentOrders = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Fetch Weekly Revenue (Last 7 Days)
            $stmtRevenue = $this->db->prepare("
                SELECT DATE(created_at) as date, SUM(total_amount) as daily_total
                FROM orders 
                WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
                GROUP BY DATE(created_at)
                ORDER BY DATE(created_at) ASC
            ");
            $stmtRevenue->execute();
            $weeklyRevenueData = $stmtRevenue->fetchAll(PDO::FETCH_ASSOC);

            // Fetch Order Status Counts
            $stmtStatus = $this->db->prepare("
                SELECT status, COUNT(*) as count 
                FROM orders 
                GROUP BY status
            ");
            $stmtStatus->execute();
            $orderStatusData = $stmtStatus->fetchAll(PDO::FETCH_ASSOC);

            // Fetch Top Selling Products
            $stmtTopProducts = $this->db->prepare("
                SELECT p.name, SUM(oi.quantity) as total_sold 
                FROM order_items oi
                JOIN products p ON oi.product_id = p.id
                JOIN orders o ON oi.order_id = o.id
                WHERE o.status != 'cancelled'
                GROUP BY oi.product_id
                ORDER BY total_sold DESC
                LIMIT 5
            ");
            $stmtTopProducts->execute();
            $topSellingData = $stmtTopProducts->fetchAll(PDO::FETCH_ASSOC);

            $this->render('admin/index', [
                'page'              => 'dashboard',
                'productCount'      => $productCount,
                'orderCount'        => $orderCount,
                'userCount'         => $userCount,
                'revenue'           => $revenue,
                'recentOrders'      => $recentOrders,
                'weeklyRevenueData' => json_encode($weeklyRevenueData),
                'orderStatusData'   => json_encode($orderStatusData),
                'topSellingData'    => json_encode($topSellingData),
            ]);
        } catch (Exception $e) {
            $this->render('admin/index', [
                'page'  => 'dashboard',
                'error' => 'ড্যাশবোর্ড ডেটা লোড করতে সমস্যা হয়েছে: ' . $e->getMessage(),
            ]);
        }
    }

    // ─── Products List ────────────────────────────────────────────
    public function products() {
        $products = $this->productModel->getAll();
        $this->render('admin/products', [
            'products' => $products,
            'page'     => 'products',
        ]);
    }

    // ─── Add Product ──────────────────────────────────────────────
    public function addProduct() {
        $error      = '';
        $categories = $this->getCategories();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name'           => trim($_POST['name'] ?? ''),
                'description'    => trim($_POST['description'] ?? ''),
                'price'          => floatval($_POST['price'] ?? 0),
                'discount_price' => floatval($_POST['discount_price'] ?? 0),
                'category_id'    => intval($_POST['category_id'] ?? 0) ?: null,
                'stock_quantity' => intval($_POST['stock_quantity'] ?? 0),
                'is_featured'    => isset($_POST['is_featured']) ? 1 : 0,
            ];

            // Image upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $ext      = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                $allowed  = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
                if (in_array($ext, $allowed)) {
                    if (!is_dir(UPLOAD_PATH)) mkdir(UPLOAD_PATH, 0755, true);
                    $fileName = uniqid('product_') . '.' . $ext;
                    if (move_uploaded_file($_FILES['image']['tmp_name'], UPLOAD_PATH . $fileName)) {
                        $data['image_url'] = UPLOAD_URL . $fileName;
                    }
                }
            }

            if (empty($data['name'])) {
                $error = 'পণ্যের নাম আবশ্যক।';
            } elseif ($data['price'] <= 0) {
                $error = 'সঠিক মূল্য দিন।';
            } elseif ($this->productModel->create($data)) {
                header('Location: ' . SITE_URL . '/admin/products?success=1');
                exit;
            } else {
                $error = 'পণ্য যোগ করতে সমস্যা হয়েছে।';
            }
        }

        $this->render('admin/add-product', [
            'error'      => $error,
            'categories' => $categories,
            'page'       => 'products',
        ]);
    }

    // ─── Edit Product ─────────────────────────────────────────────
    public function editProduct() {
        $product_id = intval($GLOBALS['product_id'] ?? 0);
        $categories = $this->getCategories();

        if (!$product_id) {
            header('Location: ' . SITE_URL . '/admin/products');
            exit;
        }

        $product = $this->productModel->getById($product_id);
        if (!$product) {
            header('Location: ' . SITE_URL . '/admin/products');
            exit;
        }

        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name'           => trim($_POST['name'] ?? ''),
                'description'    => trim($_POST['description'] ?? ''),
                'price'          => floatval($_POST['price'] ?? 0),
                'discount_price' => floatval($_POST['discount_price'] ?? 0),
                'category_id'    => intval($_POST['category_id'] ?? 0) ?: null,
                'stock_quantity' => intval($_POST['stock_quantity'] ?? 0),
                'is_featured'    => isset($_POST['is_featured']) ? 1 : 0,
            ];

            // Image upload (optional on edit)
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $ext     = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
                if (in_array($ext, $allowed)) {
                    if (!is_dir(UPLOAD_PATH)) mkdir(UPLOAD_PATH, 0755, true);
                    $fileName = uniqid('product_') . '.' . $ext;
                    if (move_uploaded_file($_FILES['image']['tmp_name'], UPLOAD_PATH . $fileName)) {
                        $data['image_url'] = UPLOAD_URL . $fileName;
                    }
                }
            }

            if (empty($data['name'])) {
                $error = 'পণ্যের নাম আবশ্যক।';
            } elseif ($this->productModel->update($product_id, $data)) {
                header('Location: ' . SITE_URL . '/admin/products?success=1');
                exit;
            } else {
                $error = 'পণ্য আপডেট করতে সমস্যা হয়েছে।';
            }
        }

        $this->render('admin/edit-product', [
            'product'    => $product,
            'error'      => $error,
            'categories' => $categories,
            'page'       => 'products',
        ]);
    }

    // ─── Delete Product (AJAX) ────────────────────────────────────
    public function deleteProduct() {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid method']);
            exit;
        }
        $product_id = intval($_POST['product_id'] ?? 0);
        $ok = $product_id && $this->productModel->delete($product_id);
        echo json_encode(['success' => $ok]);
        exit;
    }

    // ─── Orders List ──────────────────────────────────────────────
    public function orders() {
        $stmt = $this->db->prepare('
            SELECT o.*, u.name, u.email
            FROM orders o
            LEFT JOIN users u ON o.user_id = u.id
            ORDER BY o.created_at DESC
        ');
        $stmt->execute();
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->render('admin/orders', [
            'orders' => $orders,
            'page'   => 'orders',
        ]);
    }

    // ─── Update Order Status (AJAX) ───────────────────────────────
    public function updateOrderStatus() {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false]);
            exit;
        }
        $order_id = intval($_POST['order_id'] ?? 0);
        $status   = trim($_POST['status'] ?? '');
        $allowed  = ['pending', 'processing', 'confirmed', 'shipped', 'delivered', 'cancelled'];

        if (!in_array($status, $allowed)) {
            echo json_encode(['success' => false, 'message' => 'Invalid status']);
            exit;
        }

        $ok = $this->orderModel->updateStatus($order_id, $status);
        echo json_encode(['success' => $ok]);
        exit;
    }

    // ─── Users List ───────────────────────────────────────────────
    public function users() {
        $stmt = $this->db->prepare('SELECT id, name, email, role, created_at FROM users ORDER BY created_at DESC');
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->render('admin/users', [
            'users' => $users,
            'page'  => 'users',
        ]);
    }

    // ─── Settings ──────────────────────────────────────────────────
    public function settings() {
        $settingsFile = APP_PATH . '/config/settings.json';
        $settings = ['promo_end_time' => ''];
        if (file_exists($settingsFile)) {
            $settings = json_decode(file_get_contents($settingsFile), true) ?: $settings;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $settings['promo_end_time'] = trim($_POST['promo_end_time'] ?? '');
            file_put_contents($settingsFile, json_encode($settings));
            $success = "Settings updated successfully.";
            $this->render('admin/settings', ['page' => 'settings', 'settings' => $settings, 'success' => $success]);
            return;
        }

        $this->render('admin/settings', ['page' => 'settings', 'settings' => $settings]);
    }

    // ─── Invoice ───────────────────────────────────────────────────
    public function invoice($orderId) {
        $stmt = $this->db->prepare('SELECT o.*, u.name as user_name FROM orders o LEFT JOIN users u ON o.user_id = u.id WHERE o.id = ?');
        $stmt->execute([$orderId]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$order) {
            header('Location: ' . SITE_URL . '/admin/orders');
            exit;
        }

        $stmtItems = $this->db->prepare('
            SELECT oi.*, p.name 
            FROM order_items oi 
            JOIN products p ON oi.product_id = p.id 
            WHERE oi.order_id = ?
        ');
        $stmtItems->execute([$orderId]);
        $items = $stmtItems->fetchAll(PDO::FETCH_ASSOC);

        // Extract variables for the view
        extract([
            'order' => $order,
            'items' => $items,
            'page'  => 'orders'
        ]);
        
        include APP_PATH . '/views/admin/invoice.php';
    }
}
