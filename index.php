<?php
session_start();

// Load Configuration and Core files
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/core/Database.php';
require_once __DIR__ . '/core/Controller.php';
require_once __DIR__ . '/core/Security.php';
require_once __DIR__ . '/core/Logger.php';

// Helper functions
function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

function asset($path) {
    return SITE_URL . '/assets/' . $path;
}

function __($key) {
    // Translation logic could be expanded here
    return $key; 
}

function formatPrice($price) {
    return CURRENCY . number_format($price, 2);
}

function cartCount() {
    return isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
}

function cartTotal() {
    $total = 0;
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        require_once APP_PATH . '/models/Product.php';
        $productModel = new Product();
        
        foreach ($_SESSION['cart'] as $product_id => $quantity) {
            $product = $productModel->getById($product_id);
            if ($product) {
                $price = $product['discount_price'] > 0 ? $product['discount_price'] : $product['price'];
                $total += $price * $quantity;
            }
        }
    }
    return $total;
}

function isActive($path) {
    $current = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    return strpos($current, $path) === 0 ? 'active' : '';
}

function flashMessage() { return ''; }

// Parse request URI
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = trim($request_uri, '/');

// Split path into segments for dynamic routing
$segments = explode('/', $path);
$controller_name = $segments[0] ?? '';
$action = $segments[1] ?? '';
$id = $segments[2] ?? '';

// Store ID in global scope for easy access
if (!empty($id)) {
    // Determine what ID this is based on controller/action
    if ($controller_name === 'product' || ($controller_name === 'shop' && $action === 'product')) {
        $GLOBALS['product_id'] = intval($id);
    } elseif ($controller_name === 'checkout' && $action === 'success') {
        $GLOBALS['order_id'] = intval($id);
    } elseif ($controller_name === 'account' && $action === 'order') {
        $GLOBALS['order_id'] = intval($id);
    } elseif ($controller_name === 'admin' && $action === 'edit-product') {
        $GLOBALS['product_id'] = intval($id);
    }
}

// Language switching
if ($controller_name === 'home' && $action === 'setLang') {
    $lang = $id ?: 'bn';
    $_SESSION['lang'] = in_array($lang, ['en', 'bn']) ? $lang : 'bn';
    header('Location: ' . SITE_URL . '/' . ($_GET['redirect'] ?? ''));
    exit;
}

// Router
switch ($controller_name) {
    case '':
    case 'home':
        require_once APP_PATH . '/models/Product.php';
        $productModel = new Product();
        $featured = $productModel->getFeatured();
        $controller = new Controller();
        $controller->render('home/index', [
            'categories' => [['id'=>1, 'name'=>'Sunglasses', 'product_count'=>10]],
            'featured' => $featured,
            'new_arrivals' => $featured
        ]);
        break;

    case 'shop':
        require_once APP_PATH . '/controllers/ShopController.php';
        $controller = new ShopController();
        
        if ($action === 'product' && !empty($id)) {
            require_once APP_PATH . '/controllers/ProductController.php';
            $productController = new ProductController();
            $productController->view();
        } else {
            $controller->index();
        }
        break;

    case 'product':
        require_once APP_PATH . '/controllers/ProductController.php';
        $controller = new ProductController();
        $controller->view();
        break;

    case 'cart':
        require_once APP_PATH . '/controllers/CartController.php';
        $controller = new CartController();
        
        switch ($action) {
            case 'add':
                $controller->add();
                break;
            case 'remove':
                $controller->remove();
                break;
            case 'update':
                $controller->update();
                break;
            case 'clear':
                $controller->clear();
                break;
            default:
                $controller->index();
        }
        break;

    case 'checkout':
        require_once APP_PATH . '/controllers/OrderController.php';
        $controller = new OrderController();
        
        switch ($action) {
            case 'index':
                $controller->checkout();
                break;
            case 'process':
                $controller->process();
                break;
            case 'success':
                $controller->success();
                break;
            default:
                $controller->checkout();
        }
        break;

    case 'account':
        require_once APP_PATH . '/controllers/AccountController.php';
        $controller = new AccountController();
        
        switch ($action) {
            case 'order':
                $controller->order();
                break;
            case 'update-profile':
                $controller->updateProfile();
                break;
            case 'change-password':
                $controller->changePassword();
                break;
            default:
                $controller->index();
        }
        break;

    case 'admin':
        require_once APP_PATH . '/controllers/AdminController.php';
        $controller = new AdminController();
        
        switch ($action) {
            case '':
            case 'index':
                $controller->index();
                break;
            case 'products':
                $controller->products();
                break;
            case 'addProduct':
            case 'add-product':
                $controller->addProduct();
                break;
            case 'editProduct':
            case 'edit-product':
                $controller->editProduct();
                break;
            case 'deleteProduct':
            case 'delete-product':
                $controller->deleteProduct();
                break;
            case 'orders':
                $controller->orders();
                break;
            case 'updateOrderStatus':
            case 'update-order-status':
                $controller->updateOrderStatus();
                break;
            case 'users':
                $controller->users();
                break;
            case 'order':
                // View single order details
                if (!empty($id)) {
                    $orderId = intval($id);
                    require_once APP_PATH . '/models/Order.php';
                    $orderModel = new Order();
                    $order = $orderModel->getById($orderId);
                    $items = $orderModel->getItems($orderId);
                    $controller->render('admin/order-detail', [
                        'order' => $order,
                        'items' => $items,
                        'page' => 'orders'
                    ]);
                } else {
                    $controller->orders();
                }
                break;
            default:
                $controller->index();
        }
        break;

    case 'auth':
        require_once APP_PATH . '/controllers/AuthController.php';
        $controller = new AuthController();
        
        switch ($action) {
            case 'login':
                $controller->login();
                break;
            case 'register':
                $controller->register();
                break;
            case 'logout':
                $controller->logout();
                break;
            case 'forgot-password':
                $controller->forgotPassword();
                break;
            case 'reset-password':
                $controller->resetPassword();
                break;
            case 'verify-email':
                $controller->verifyEmail();
                break;
            default:
                http_response_code(404);
                echo "404 Not Found";
        }
        break;

    case 'login':
    case 'register':
    case 'logout':
        // Legacy routes
        require_once APP_PATH . '/controllers/AuthController.php';
        $controller = new AuthController();
        
        if ($path === 'login') {
            $controller->login();
        } elseif ($path === 'register') {
            $controller->register();
        } else {
            $controller->logout();
        }
        break;

    default:
        // Static file serving for local testing
        if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js|json|svg|webp)$/', $_SERVER["REQUEST_URI"])) {
            return false;
        }
        http_response_code(404);
        echo "404 Not Found";
        break;
}

