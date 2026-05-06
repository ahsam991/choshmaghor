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
            // Verify CSRF token
            if (!verifyCsrfToken($_POST['csrf_token'] ?? null)) {
                $error = 'Invalid security token. Please try again.';
                logWarning('CSRF token validation failed on login', ['ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown']);
            } else {
                $email = trim($_POST['email'] ?? '');
                $password = $_POST['password'] ?? '';

                // Validate email format
                $email = validateEmail($email);
                if (!$email) {
                    $error = 'Invalid email format.';
                } elseif (empty($password)) {
                    $error = 'Password is required.';
                } else {
                    $user = $this->userModel->login($email, $password);
                    if ($user) {
                        // Start session and set user details
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['user_name'] = $user['name'];
                        $_SESSION['user_role'] = $user['role'];
                        
                        logInfo('User login successful', ['user_id' => $user['id'], 'email' => $email]);
                        
                        header('Location: ' . SITE_URL . '/account');
                        exit;
                    } else {
                        $error = 'Invalid email or password.';
                        logWarning('Failed login attempt', ['email' => $email, 'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown']);
                    }
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
            // Verify CSRF token
            if (!verifyCsrfToken($_POST['csrf_token'] ?? null)) {
                $error = 'Invalid security token. Please try again.';
                logWarning('CSRF token validation failed on registration', ['ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown']);
            } else {
                $name = trim($_POST['name'] ?? '');
                $email = trim($_POST['email'] ?? '');
                $password = $_POST['password'] ?? '';
                $confirm_password = $_POST['confirm_password'] ?? '';

                // Validate required fields
                $required = validateRequired($_POST, ['name', 'email', 'password', 'confirm_password']);
                if (!$required['valid']) {
                    $error = 'All fields are required.';
                } elseif (!validateEmail($email)) {
                    $error = 'Invalid email format.';
                } elseif ($password !== $confirm_password) {
                    $error = 'Passwords do not match.';
                } else {
                    // Validate password strength
                    $passwordValidation = validatePassword($password);
                    if (!$passwordValidation['valid']) {
                        $error = implode(' ', $passwordValidation['errors']);
                    } elseif ($this->userModel->findByEmail($email)) {
                        $error = 'Email is already registered.';
                    } else {
                        $created = $this->userModel->create([
                            'name' => sanitizeString($name),
                            'email' => $email,
                            'password' => $password
                        ]);

                        if ($created) {
                            $success = 'Registration successful! You can now login.';
                            logInfo('New user registered', ['email' => $email, 'name' => $name]);
                        } else {
                            $error = 'Something went wrong. Please try again.';
                            logError('User registration failed', ['email' => $email]);
                        }
                    }
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

    /**
     * Show forgot password form
     */
    public function forgotPassword() {
        if ($this->isLoggedIn()) {
            header('Location: ' . SITE_URL . '/account');
            exit;
        }

        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verifyCsrfToken($_POST['csrf_token'] ?? null)) {
                $error = 'Invalid security token. Please try again.';
            } else {
                $email = validateEmail($_POST['email'] ?? '');
                
                if (!$email) {
                    $error = 'Please enter a valid email address.';
                } else {
                    $resetToken = $this->userModel->generateResetToken($email);
                    
                    if ($resetToken) {
                        // In production, send email with reset link
                        // For now, we'll show the token (REMOVE IN PRODUCTION!)
                        $resetLink = SITE_URL . "/auth/reset-password?token=$resetToken";
                        $success = "Password reset link generated. For demo purposes: <br><a href='$resetLink'>$resetLink</a><br><strong>NOTE:</strong> In production, this would be sent via email.";
                        logInfo('Password reset requested', ['email' => $email]);
                    } else {
                        // Don't reveal if email exists or not for security
                        $success = "If an account exists with that email, a password reset link has been sent.";
                    }
                }
            }
        }

        $this->render('auth/forgot-password', ['error' => $error, 'success' => $success]);
    }

    /**
     * Show reset password form
     */
    public function resetPassword() {
        if ($this->isLoggedIn()) {
            header('Location: ' . SITE_URL . '/account');
            exit;
        }

        $token = $_GET['token'] ?? '';
        $error = '';
        $success = '';

        // Verify token is valid
        if (empty($token)) {
            $error = 'Invalid reset token.';
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verifyCsrfToken($_POST['csrf_token'] ?? null)) {
                $error = 'Invalid security token. Please try again.';
            } else {
                $password = $_POST['password'] ?? '';
                $confirm_password = $_POST['confirm_password'] ?? '';

                if (empty($password)) {
                    $error = 'Password is required.';
                } elseif ($password !== $confirm_password) {
                    $error = 'Passwords do not match.';
                } else {
                    $passwordValidation = validatePassword($password);
                    if (!$passwordValidation['valid']) {
                        $error = implode(' ', $passwordValidation['errors']);
                    } else {
                        if ($this->userModel->resetPassword($token, $password)) {
                            $success = 'Password reset successful! You can now login with your new password.';
                            logInfo('Password reset completed', ['token' => substr($token, 0, 8) . '...']);
                        } else {
                            $error = 'Invalid or expired reset token. Please request a new one.';
                        }
                    }
                }
            }
        }

        $this->render('auth/reset-password', ['error' => $error, 'success' => $success, 'token' => $token]);
    }

    /**
     * Verify user email
     */
    public function verifyEmail() {
        $token = $_GET['token'] ?? '';
        $error = '';
        $success = '';

        if (empty($token)) {
            $error = 'Invalid verification token.';
        } elseif ($this->userModel->verifyEmail($token)) {
            $success = 'Email verified successfully! You can now login.';
            logInfo('Email verified', ['token' => substr($token, 0, 8) . '...']);
        } else {
            $error = 'Invalid or already used verification token.';
        }

        $this->render('auth/verify-email', ['error' => $error, 'success' => $success]);
    }
}
