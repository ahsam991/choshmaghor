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
    static $translations = null;
    if ($translations === null) {
        $lang = $_SESSION['lang'] ?? 'bn';
        $file = __DIR__ . '/lang/' . $lang . '.php';
        if (file_exists($file)) {
            $translations = require $file;
        } else {
            $translations = [];
        }
    }
    return $translations[$key] ?? $key; 
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
    // Handle subdirectory paths
    if ($base_path !== '' && strpos($current, $base_path) === 0) {
        $current = substr($current, strlen($base_path));
    }
    $current = trim($current, '/');
    return strpos($current, $path) === 0 ? 'active' : '';
}

function flashMessage() { return ''; }

// Parse request URI and handle subdirectory hosting
$_rtr_dir = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
$base_path = ($_rtr_dir === '' || $_rtr_dir === '.' || $_rtr_dir === '/') ? '' : $_rtr_dir;
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if ($base_path !== '' && strpos($request_uri, $base_path) === 0) {
    $request_uri = substr($request_uri, strlen($base_path));
}
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
    } elseif ($controller_name === 'admin' && ($action === 'edit-product' || $action === 'editProduct')) {
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

// About page route
if ($controller_name === 'about' || ($controller_name === 'home' && $action === 'about')) {
    // SEO optimization for about page
    $title = 'About ChoshmaZone - Premium Sunglasses Store in Bangladesh';
    $meta_description = 'Learn about ChoshmaZone, Bangladesh\'s leading online sunglasses store. We offer 100% original UV400 protection eyewear with fast delivery and cash on delivery options.';
    $og_title = 'About ChoshmaZone - Your Trusted Eyewear Partner';
    $og_type = 'website';
    
    $controller = new Controller();
    $controller->render('home/about', [
        'title' => $title,
        'meta_description' => $meta_description,
        'og_title' => $og_title,
        'og_type' => $og_type
    ]);
    exit;
}

// Contact page route
if ($controller_name === 'contact' || ($controller_name === 'home' && $action === 'contact')) {
    // SEO optimization for contact page
    $title = 'Contact ChoshmaZone - Get in Touch';
    $meta_description = 'Contact ChoshmaZone for any inquiries about our premium sunglasses. Call, WhatsApp, or email us. Fast response guaranteed.';
    $og_title = 'Contact ChoshmaZone';
    $og_type = 'website';
    
    $controller = new Controller();
    $controller->render('home/contact', [
        'title' => $title,
        'meta_description' => $meta_description,
        'og_title' => $og_title,
        'og_type' => $og_type
    ]);
    exit;
}

// Router
switch ($controller_name) {
    case '':
    case 'home':
        // Check if it's the about or contact action from home controller
        if ($action === 'about') {
            $title = 'About ChoshmaZone - Premium Sunglasses Store in Bangladesh';
            $meta_description = 'Learn about ChoshmaZone, Bangladesh\'s leading online sunglasses store. We offer 100% original UV400 protection eyewear with fast delivery and cash on delivery options.';
            $og_title = 'About ChoshmaZone - Your Trusted Eyewear Partner';
            $og_type = 'website';
            
            $controller = new Controller();
            $controller->render('home/about', [
                'title' => $title,
                'meta_description' => $meta_description,
                'og_title' => $og_title,
                'og_type' => $og_type
            ]);
            break;
        }
        
        if ($action === 'contact') {
            $title = 'Contact ChoshmaZone - Get in Touch';
            $meta_description = 'Contact ChoshmaZone for any inquiries about our premium sunglasses. Call, WhatsApp, or email us. Fast response guaranteed.';
            $og_title = 'Contact ChoshmaZone';
            $og_type = 'website';
            
            $controller = new Controller();
            $controller->render('home/contact', [
                'title' => $title,
                'meta_description' => $meta_description,
                'og_title' => $og_title,
                'og_type' => $og_type
            ]);
            break;
        }
        
        require_once APP_PATH . '/models/Product.php';
        $productModel = new Product();
        $featured = $productModel->getFeatured();
        
        // Load real categories from DB
        $catStmt = Database::getInstance()->prepare(
            'SELECT c.*, COUNT(p.id) as product_count FROM categories c LEFT JOIN products p ON c.id = p.category_id GROUP BY c.id'
        );
        $catStmt->execute();
        $dbCategories = $catStmt->fetchAll(PDO::FETCH_ASSOC);
        
        // SEO optimization for home page
        $title = 'Buy Premium Sunglasses Online in Bangladesh | ChoshmaZone';
        $meta_description = 'Shop premium sunglasses online in Bangladesh at ChoshmaZone. 100% original UV400 protection eyewear for men & women. Best price, free shipping, cash on delivery. Explore Ray-Ban, Oakley style sunglasses in Dhaka.';
        $og_title = 'ChoshmaZone - Premium Sunglasses Store in Bangladesh';
        $og_type = 'website';
        
        // Fetch settings
        $settingsFile = APP_PATH . '/config/settings.json';
        $settings = [];
        if (file_exists($settingsFile)) {
            $settings = json_decode(file_get_contents($settingsFile), true) ?: [];
        }

        $controller = new Controller();
        $controller->render('home/index', [
            'categories' => $dbCategories,
            'featured' => $featured,
            'new_arrivals' => $featured,
            'title' => $title,
            'meta_description' => $meta_description,
            'og_title' => $og_title,
            'og_type' => $og_type,
            'settings' => $settings
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
            case 'orders':
                $controller->index(); // orders tab shown from dashboard
                break;
            case 'profile':
                $controller->index(); // profile tab shown from dashboard
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
            case 'settings':
                $controller->settings();
                break;
            case 'invoice':
                if (!empty($id)) {
                    $controller->invoice(intval($id));
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

