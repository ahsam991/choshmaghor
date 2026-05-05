<?php
class Controller {
    public function render($view, $data = []) {
        extract($data);
        
        // Helper functions for views
        if (!function_exists('e')) {
            function e($str) { return htmlspecialchars($str, ENT_QUOTES, 'UTF-8'); }
        }
        
        if (!function_exists('asset')) {
            function asset($path) { return SITE_URL . '/assets/' . $path; }
        }

        ob_start();
        $viewPath = APP_PATH . '/views/' . $view . '.php';
        if (file_exists($viewPath)) {
            include $viewPath;
        } else {
            echo "View not found: $view";
        }
        $content = ob_get_clean();
        
        include APP_PATH . '/views/layout/main.php';
    }

    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    public function isAdmin() {
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
    }
}
