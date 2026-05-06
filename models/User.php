<?php
class User {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT id, name, email, role, email_verified, created_at FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO users (name, email, password, role, verification_token) VALUES (:name, :email, :password, :role, :verification_token)");

        $password_hashed = password_hash($data['password'], PASSWORD_DEFAULT);
        $verification_token = bin2hex(random_bytes(32));

        return $stmt->execute([
            'name' => sanitizeString($data['name']),
            'email' => validateEmail($data['email']),
            'password' => $password_hashed,
            'role' => $data['role'] ?? 'customer',
            'verification_token' => $verification_token
        ]);
    }

    public function login($email, $password) {
        $user = $this->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    /**
     * Verify user's email using verification token
     * @param string $token The verification token
     * @return bool True if verification successful
     */
    public function verifyEmail($token) {
        $stmt = $this->db->prepare("UPDATE users SET email_verified = 1, verification_token = NULL WHERE verification_token = :token AND email_verified = 0");
        $result = $stmt->execute(['token' => $token]);
        return $result && $stmt->rowCount() > 0;
    }

    /**
     * Generate password reset token
     * @param string $email User email
     * @return string|false Reset token or false if email not found
     */
    public function generateResetToken($email) {
        $user = $this->findByEmail($email);

        if (!$user) {
            return false;
        }

        $reset_token = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $stmt = $this->db->prepare("UPDATE users SET reset_token = :token, reset_token_expires = :expires WHERE email = :email");
        $stmt->execute([
            'token' => $reset_token,
            'expires' => $expires,
            'email' => $email
        ]);

        return $reset_token;
    }

    /**
     * Reset password using reset token
     * @param string $token The reset token
     * @param string $newPassword New password
     * @return bool True if password reset successful
     */
    public function resetPassword($token, $newPassword) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE reset_token = :token AND reset_token_expires > NOW()");
        $stmt->execute(['token' => $token]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return false;
        }

        $password_hashed = password_hash($newPassword, PASSWORD_DEFAULT);

        $stmt = $this->db->prepare("UPDATE users SET password = :password, reset_token = NULL, reset_token_expires = NULL WHERE id = :id");
        return $stmt->execute([
            'password' => $password_hashed,
            'id' => $user['id']
        ]);
    }

    /**
     * Update user profile
     * @param int $userId User ID
     * @param array $data Data to update
     * @return bool True if update successful
     */
    public function updateProfile($userId, $data) {
        $fields = [];
        $params = ['id' => $userId];

        if (isset($data['name'])) {
            $fields[] = "name = :name";
            $params['name'] = sanitizeString($data['name']);
        }

        if (isset($data['email'])) {
            $fields[] = "email = :email";
            $params['email'] = validateEmail($data['email']);
        }

        if (empty($fields)) {
            return false;
        }

        $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * Change user password
     * @param int $userId User ID
     * @param string $newPassword New password
     * @return bool True if password changed successfully
     */
    public function changePassword($userId, $newPassword) {
        $password_hashed = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("UPDATE users SET password = :password WHERE id = :id");
        return $stmt->execute([
            'password' => $password_hashed,
            'id' => $userId
        ]);
    }
}
