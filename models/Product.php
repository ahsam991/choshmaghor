<?php
class Product {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAll($filters = []) {
        $query = "SELECT p.*, c.name as category_name 
                  FROM products p 
                  LEFT JOIN categories c ON p.category_id = c.id 
                  WHERE 1=1";
        
        $params = [];

        if (!empty($filters['category_id'])) {
            $query .= " AND p.category_id = :cat_id";
            $params['cat_id'] = $filters['category_id'];
        }

        if (!empty($filters['search'])) {
            $query .= " AND p.name LIKE :search";
            $params['search'] = "%" . $filters['search'] . "%";
        }

        // Sorting
        if (!empty($filters['sort'])) {
            switch ($filters['sort']) {
                case 'price_asc': $query .= " ORDER BY p.price ASC"; break;
                case 'price_desc': $query .= " ORDER BY p.price DESC"; break;
                default: $query .= " ORDER BY p.created_at DESC";
            }
        }

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFeatured() {
        $stmt = $this->db->prepare("SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.is_featured = 1 LIMIT 8");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("
            SELECT p.*, c.name as category_name 
            FROM products p 
            LEFT JOIN categories c ON p.category_id = c.id 
            WHERE p.id = :id
        ");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO products (name, description, price, discount_price, category_id, stock_quantity, is_featured, image_url)
            VALUES (:name, :description, :price, :discount_price, :category_id, :stock_quantity, :is_featured, :image_url)
        ");

        return $stmt->execute([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'price' => $data['price'],
            'discount_price' => $data['discount_price'] ?? 0,
            'category_id' => $data['category_id'] ?? null,
            'stock_quantity' => $data['stock_quantity'] ?? 0,
            'is_featured' => $data['is_featured'] ?? 0,
            'image_url' => $data['image_url'] ?? null
        ]);
    }

    public function update($id, $data) {
        $updates = [];
        $params = ['id' => $id];

        if (isset($data['name'])) {
            $updates[] = "name = :name";
            $params['name'] = $data['name'];
        }
        if (isset($data['description'])) {
            $updates[] = "description = :description";
            $params['description'] = $data['description'];
        }
        if (isset($data['price'])) {
            $updates[] = "price = :price";
            $params['price'] = $data['price'];
        }
        if (isset($data['discount_price'])) {
            $updates[] = "discount_price = :discount_price";
            $params['discount_price'] = $data['discount_price'];
        }
        if (isset($data['category_id'])) {
            $updates[] = "category_id = :category_id";
            $params['category_id'] = $data['category_id'];
        }
        if (isset($data['stock_quantity'])) {
            $updates[] = "stock_quantity = :stock_quantity";
            $params['stock_quantity'] = $data['stock_quantity'];
        }
        if (isset($data['is_featured'])) {
            $updates[] = "is_featured = :is_featured";
            $params['is_featured'] = $data['is_featured'];
        }
        if (isset($data['image_url'])) {
            $updates[] = "image_url = :image_url";
            $params['image_url'] = $data['image_url'];
        }

        if (empty($updates)) {
            return false;
        }

        $query = "UPDATE products SET " . implode(", ", $updates) . " WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute($params);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM products WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function updateStock($id, $quantity) {
        $stmt = $this->db->prepare("UPDATE products SET stock_quantity = :quantity WHERE id = :id");
        return $stmt->execute(['quantity' => $quantity, 'id' => $id]);
    }
}
