<?php
require_once APP_PATH . '/models/Product.php';

class Order {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function create($data) {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO orders (user_id, total_amount, status, shipping_address)
                VALUES (:user_id, :total_amount, :status, :shipping_address)
            ");

            return $stmt->execute([
                'user_id' => $data['user_id'] ?? null,
                'total_amount' => $data['total_amount'],
                'status' => $data['status'] ?? 'pending',
                'shipping_address' => $data['shipping_address']
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getLastInsertId() {
        return $this->db->lastInsertId();
    }

    public function addItem($order_id, $product_id, $quantity, $price) {
        $stmt = $this->db->prepare("
            INSERT INTO order_items (order_id, product_id, quantity, price)
            VALUES (:order_id, :product_id, :quantity, :price)
        ");

        return $stmt->execute([
            'order_id' => $order_id,
            'product_id' => $product_id,
            'quantity' => $quantity,
            'price' => $price
        ]);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("
            SELECT o.*, u.name, u.email FROM orders o
            LEFT JOIN users u ON o.user_id = u.id
            WHERE o.id = :id
        ");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getItems($order_id) {
        $stmt = $this->db->prepare("
            SELECT oi.*, p.name, p.image_url FROM order_items oi
            LEFT JOIN products p ON oi.product_id = p.id
            WHERE oi.order_id = :order_id
        ");
        $stmt->execute(['order_id' => $order_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByUser($user_id) {
        $stmt = $this->db->prepare("
            SELECT * FROM orders
            WHERE user_id = :user_id
            ORDER BY created_at DESC
        ");
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStatus($order_id, $status) {
        $stmt = $this->db->prepare("UPDATE orders SET status = :status WHERE id = :id");
        return $stmt->execute(['status' => $status, 'id' => $order_id]);
    }
}
