<?php
// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'choshmazone_db');
define('DB_USER', 'root');
define('DB_PASS', '');

// Site Configuration
define('SITE_NAME', 'ChoshmaZone');
define('SITE_URL', 'http://localhost:8000');
define('APP_PATH', dirname(__DIR__));

// Currency & Localization
define('CURRENCY', '৳ '); // Bangladeshi Taka
define('CURRENCY_CODE', 'BDT');

// Security
define('AUTH_SALT', 'choshma_secret_key_2024');

// Pagination
define('ITEMS_PER_PAGE', 12);

// File Uploads
define('UPLOAD_PATH', APP_PATH . '/assets/images/products/');
define('UPLOAD_URL', SITE_URL . '/assets/images/products/');
define('MAX_UPLOAD_SIZE', 5 * 1024 * 1024); // 5MB
