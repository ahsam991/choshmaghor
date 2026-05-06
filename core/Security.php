<?php
/**
 * Security Helper Functions
 * CSRF Protection, Input Validation, and Sanitization
 */

/**
 * Generate a CSRF token and store it in the session
 * @return string The generated CSRF token
 */
function generateCsrfToken() {
    if (empty($_SESSION['csrf_token']) || empty($_SESSION['csrf_token_time'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(CSRF_TOKEN_LENGTH / 2));
        $_SESSION['csrf_token_time'] = time();
    }
    
    // Regenerate token if expired
    if (time() - $_SESSION['csrf_token_time'] > CSRF_TOKEN_EXPIRE) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(CSRF_TOKEN_LENGTH / 2));
        $_SESSION['csrf_token_time'] = time();
    }
    
    return $_SESSION['csrf_token'];
}

/**
 * Verify a CSRF token from POST data
 * @param string|null $token The token to verify
 * @return bool True if valid, false otherwise
 */
function verifyCsrfToken($token = null) {
    if (empty($token) || empty($_SESSION['csrf_token'])) {
        return false;
    }
    
    // Check if token is expired
    if (isset($_SESSION['csrf_token_time']) && 
        time() - $_SESSION['csrf_token_time'] > CSRF_TOKEN_EXPIRE) {
        unset($_SESSION['csrf_token'], $_SESSION['csrf_token_time']);
        return false;
    }
    
    return hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Get CSRF token HTML input field
 * @return string Hidden input field with CSRF token
 */
function csrfField() {
    $token = generateCsrfToken();
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
}

/**
 * Validate and sanitize email address
 * @param string $email The email to validate
 * @return string|false Sanitized email or false if invalid
 */
function validateEmail($email) {
    $email = trim($email);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return $email;
    }
    return false;
}

/**
 * Validate password strength
 * @param string $password The password to validate
 * @return array ['valid' => bool, 'errors' => array]
 */
function validatePassword($password) {
    $errors = [];
    
    if (strlen($password) < 8) {
        $errors[] = 'Password must be at least 8 characters long.';
    }
    
    if (!preg_match('/[A-Z]/', $password)) {
        $errors[] = 'Password must contain at least one uppercase letter.';
    }
    
    if (!preg_match('/[a-z]/', $password)) {
        $errors[] = 'Password must contain at least one lowercase letter.';
    }
    
    if (!preg_match('/[0-9]/', $password)) {
        $errors[] = 'Password must contain at least one number.';
    }
    
    if (!preg_match('/[@$!%*?&#]/', $password)) {
        $errors[] = 'Password must contain at least one special character (@$!%*?&#).';
    }
    
    return [
        'valid' => empty($errors),
        'errors' => $errors
    ];
}

/**
 * Sanitize string input
 * @param string $string The string to sanitize
 * @return string Sanitized string
 */
function sanitizeString($string) {
    $string = trim($string);
    $string = stripslashes($string);
    $string = htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    return $string;
}

/**
 * Sanitize integer input
 * @param mixed $value The value to sanitize
 * @return int Sanitized integer
 */
function sanitizeInt($value) {
    return (int)filter_var($value, FILTER_SANITIZE_NUMBER_INT);
}

/**
 * Validate required fields
 * @param array $data The data array
 * @param array $required Array of required field names
 * @return array ['valid' => bool, 'missing' => array]
 */
function validateRequired($data, $required) {
    $missing = [];
    
    foreach ($required as $field) {
        if (!isset($data[$field]) || trim($data[$field]) === '') {
            $missing[] = $field;
        }
    }
    
    return [
        'valid' => empty($missing),
        'missing' => $missing
    ];
}

/**
 * Validate phone number (Bangladesh format)
 * @param string $phone The phone number to validate
 * @return string|false Sanitized phone or false if invalid
 */
function validatePhone($phone) {
    $phone = preg_replace('/[^0-9+]/', '', $phone);
    
    // Bangladesh phone formats: +8801XXXXXXXXX or 01XXXXXXXXX
    if (preg_match('/^(?:\+8801|01)[3-9]\d{8}$/', $phone)) {
        return $phone;
    }
    
    return false;
}
