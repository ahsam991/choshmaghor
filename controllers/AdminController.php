<?php
require_once APP_PATH . '/models/Product.php';
require_once APP_PATH . '/models/Order.php';

class AdminController extends Controller {
    private $productModel;
    private $orderModel;

    public function __construct() {
        if (!$this->isLoggedIn() || !$this->isAdmin()) {
            header('Location: ' . SITE_URL . '/auth/login');
            exit;
        }
        $this->productModel = new Product();
        $this->orderModel = new Order();
    }

    // Admin Dashboard
    public function index() {
        try {
            $db = Database::getInstance();
            
            // Get product count
            $stmt = $db->prepare('SELECT COUNT(*) as total FROM products');
            $stmt->execute();
            $productCount = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
            
            // Get order count
            $stmt = $db->prepare('SELECT COUNT(*) as total FROM orders');
            $stmt->execute();
            $orderCount = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
            
            // Get user count
            $stmt = $db->prepare('SELECT COUNT(*) as total FROM users');
            $stmt->execute();
            $userCount = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
            
            // Get total revenue
            $stmt = $db->prepare('SELECT SUM(total_amount) as revenue FROM orders');
            $stmt->execute();
            $revenueData = $stmt->fetch(PDO::FETCH_ASSOC);
            $revenue = $revenueData['revenue'] ?? 0;
            
            // Get recent orders
            $stmt = $db->prepare('
                SELECT o.id, o.total_amount, o.status, o.created_at, u.name 
                FROM orders o 
                LEFT JOIN users u ON o.user_id = u.id 
                ORDER BY o.created_at DESC 
                LIMIT 5
            ');
            $stmt->execute();
            $recentOrders = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $this->render('admin/index', [
                'page' => 'dashboard',
                'productCount' => $productCount,
                'orderCount' => $orderCount,
                'userCount' => $userCount,
                'revenue' => $revenue,
                'recentOrders' => $recentOrders
            ]);
        } catch (Exception $e) {
            $this->render('admin/index', [
                'page' => 'dashboard',
                'error' => 'Failed to load dashboard data'
            ]);
        }
    }

    // Manage Products
    public function products() {
        $products = $this->productModel->getAll();

        $this->render('admin/products', [
            'products' => $products,
            'page' => 'products'
        ]);
    }

    // Add Product Form
    public function addProduct() {
        $error = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => trim($_POST['name'] ?? ''),
                'description' => trim($_POST['description'] ?? ''),
                'price' => floatval($_POST['price'] ?? 0),
                'discount_price' => floatval($_POST['discount_price'] ?? 0),
                'category_id' => intval($_POST['category_id'] ?? 0),
                'stock_quantity' => intval($_POST['stock_quantity'] ?? 0),
                'is_featured' => isset($_POST['is_featured']) ? 1 : 0
            ];

            // Handle image upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = UPLOAD_PATH;
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                
                $fileExtension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
                
                if (in_array($fileExtension, $allowedExtensions)) {
                    $fileName = uniqid('product_') . '.' . $fileExtension;
                    $uploadPath = $uploadDir . $fileName;
                    
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                        $data['image_url'] = UPLOAD_URL . $fileName;
                    }
                }
            }

            if (empty($data['name']) || $data['price'] <= 0) {
                $error = 'Product name and price are required';
            } elseif ($this->productModel->create($data)) {
                header('Location: ' . SITE_URL . '/admin/products?success=1');
                exit;
            } else {
                $error = 'Failed to add product';
            }
        }

        $this->render('admin/add-product', [
            'error' => $error,
            'page' => 'add-product'
        ]);
    }

    // Edit Product
    public function editProduct() {
        $product_id = intval($GLOBALS['product_id'] ?? 0);
        
        if (!$product_id) {
            header('Location: ' . SITE_URL . '/admin/products');
            exit;
        }
        
        $product = $this->productModel->getById($product_id);

        if (!$product) {
            header('Location: ' . SITE_URL . '/admin/products');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => trim($_POST['name'] ?? ''),
                'description' => trim($_POST['description'] ?? ''),
                'price' => floatval($_POST['price'] ?? 0),
                'discount_price' => floatval($_POST['discount_price'] ?? 0),
                'category_id' => intval($_POST['category_id'] ?? 0),
                'stock_quantity' => intval($_POST['stock_quantity'] ?? 0),
                'is_featured' => isset($_POST['is_featured']) ? 1 : 0
            ];

            // Handle image upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = UPLOAD_PATH;
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                
                $fileExtension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
                
                if (in_array($fileExtension, $allowedExtensions)) {
                    $fileName = uniqid('product_') . '.' . $fileExtension;
                    $uploadPath = $uploadDir . $fileName;
                    
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                        $data['image_url'] = UPLOAD_URL . $fileName;
                    }
                }
            }

            if (empty($data['name'])) {
                $error = 'Product name is required';
            } elseif ($this->productModel->update($product_id, $data)) {
                header('Location: ' . SITE_URL . '/admin/products?success=1');
                exit;
            } else {
                $error = 'Failed to update product';
            }
        }

        $this->render('admin/edit-product', [
            'product' => $product,
            'error' => $error ?? '',
            'page' => 'products'
        ]);
    }

    // Delete Product
    public function deleteProduct() {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false]);
            exit;
        }

        $product_id = intval($_POST['product_id'] ?? 0);

        if ($this->productModel->delete($product_id)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
        exit;
    }

    // View Orders
    public function orders() {
        // Get all orders
        $stmt = Database::getInstance()->prepare("
            SELECT o.*, u.name, u.email FROM orders o
            LEFT JOIN users u ON o.user_id = u.id
            ORDER BY o.created_at DESC
        ");
        $stmt->execute();
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->render('admin/orders', [
            'orders' => $orders,
            'page' => 'orders'
        ]);
    }

    // Update Order Status
    public function updateOrderStatus() {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false]);
            exit;
        }

        $order_id = intval($_POST['order_id'] ?? 0);
        $status = trim($_POST['status'] ?? '');

        if ($this->orderModel->updateStatus($order_id, $status)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
        exit;
    }

    // Manage Users
    public function users() {
        $stmt = Database::getInstance()->prepare("SELECT id, name, email, role, created_at FROM users ORDER BY created_at DESC");
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->render('admin/users', [
            'users' => $users,
            'page' => 'users'
        ]);
    }
}
