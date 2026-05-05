<?php
require_once APP_PATH . '/models/User.php';

class AuthController extends Controller {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function login() {
        // If already logged in, redirect to account/home
        if ($this->isLoggedIn()) {
            header('Location: ' . SITE_URL . '/account');
            exit;
        }

        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                $error = 'Email and password are required.';
            } else {
                $user = $this->userModel->login($email, $password);
                if ($user) {
                    // Start session and set user details
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['name'];
                    $_SESSION['user_role'] = $user['role'];
                    
                    header('Location: ' . SITE_URL . '/account');
                    exit;
                } else {
                    $error = 'Invalid email or password.';
                }
            }
        }

        $this->render('auth/login', ['error' => $error]);
    }

    public function register() {
        // If already logged in, redirect
        if ($this->isLoggedIn()) {
            header('Location: ' . SITE_URL . '/account');
            exit;
        }

        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            if (empty($name) || empty($email) || empty($password)) {
                $error = 'All fields are required.';
            } elseif ($password !== $confirm_password) {
                $error = 'Passwords do not match.';
            } elseif ($this->userModel->findByEmail($email)) {
                $error = 'Email is already registered.';
            } else {
                $created = $this->userModel->create([
                    'name' => $name,
                    'email' => $email,
                    'password' => $password
                ]);

                if ($created) {
                    $success = 'Registration successful! You can now login.';
                } else {
                    $error = 'Something went wrong. Please try again.';
                }
            }
        }

        $this->render('auth/register', ['error' => $error, 'success' => $success]);
    }

    public function logout() {
        session_destroy();
        header('Location: ' . SITE_URL);
        exit;
    }
}
