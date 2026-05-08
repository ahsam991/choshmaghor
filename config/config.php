<?php
// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'choshmazone_db');
define('DB_USER', 'root');
define('DB_PASS', '');

// Site Configuration
define('SITE_NAME', 'ChoshmaZone');
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
// Only append subdirectory path if the entry script is in a subdirectory
$_script_dir = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? '/index.php'), '/\\');
$base_path = ($_script_dir === '' || $_script_dir === '.' || $_script_dir === '/') ? '' : $_script_dir;
define('SITE_URL', $protocol . '://' . $host . $base_path);
define('APP_PATH', dirname(__DIR__));

// Currency & Localization
define('CURRENCY', '৳ '); // Bangladeshi Taka
define('CURRENCY_CODE', 'BDT');

// Security
define('AUTH_SALT', 'choshma_secret_key_2024');
define('CSRF_TOKEN_LENGTH', 32);
define('CSRF_TOKEN_EXPIRE', 3600); // 1 hour

// Error Logging
define('LOG_PATH', APP_PATH . '/logs');
define('LOG_ERRORS', true);
define('LOG_LEVEL', 'all'); // all, error, warning, info

// Pagination
define('ITEMS_PER_PAGE', 12);

// File Uploads
define('UPLOAD_PATH', APP_PATH . '/assets/images/products/');
define('UPLOAD_URL', SITE_URL . '/assets/images/products/');
define('MAX_UPLOAD_SIZE', 5 * 1024 * 1024); // 5MB
