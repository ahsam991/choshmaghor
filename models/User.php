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

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)");
        
        $password_hashed = password_hash($data['password'], PASSWORD_DEFAULT);
        
        return $stmt->execute([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $password_hashed,
            'role' => $data['role'] ?? 'customer'
        ]);
    }

    public function login($email, $password) {
        $user = $this->findByEmail($email);
        
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
}
