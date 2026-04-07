<?php

require_once __DIR__ . '/database.php';

class Products
{
    private $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->getConnection();
    }

   
        // CRUD PRODUITS
    

    public function getAll()
    {
        $sql = "
            SELECT p.*, c.name AS category_name
            FROM products p
            JOIN categories c ON p.category_id = c.id
            ORDER BY p.id DESC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $sql = "
            INSERT INTO products (
                name,
                description,
                price,
                purchase_price,
                quantity,
                barcode,
                category_id,
                created_at
            ) VALUES (
                :name,
                :description,
                :price,
                :purchase_price,
                :quantity,
                :barcode,
                :category_id,
                :created_at
            )
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':name' => $data['name'],
            ':description' => $data['description'],
            ':price' => $data['price'],
            ':purchase_price' => $data['purchase_price'],
            ':quantity' => $data['quantity'],
            ':barcode' => $data['barcode'],
            ':category_id' => $data['category_id'],
            ':created_at' => $data['created_at']
        ]);
    }

    public function update($data)
    {
        $sql = "
            UPDATE products
            SET
                name = :name,
                description = :description,
                price = :price,
                purchase_price = :purchase_price,
                quantity = :quantity,
                barcode = :barcode,
                category_id = :category_id,
                created_at = :created_at
            WHERE id = :id
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':name' => $data['name'],
            ':description' => $data['description'],
            ':price' => $data['price'],
            ':purchase_price' => $data['purchase_price'],
            ':quantity' => $data['quantity'],
            ':barcode' => $data['barcode'],
            ':category_id' => $data['category_id'],
            ':created_at' => $data['created_at'],
            ':id' => $data['id']
        ]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM products WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    /* =======================
        RECHERCHE + FILTRE
    ======================== */

    public function search($q = '', $category = '')
    {
        $sql = "
            SELECT p.*, c.name AS category_name
            FROM products p
            JOIN categories c ON p.category_id = c.id
            WHERE 1 = 1
        ";

        $params = [];

        if (!empty($q)) {
            $sql .= "
                AND (
                    p.name LIKE :q
                    OR p.description LIKE :q
                    OR c.name LIKE :q
                )
            ";
            $params[':q'] = '%' . $q . '%';
        }

        if (!empty($category)) {
            $sql .= " AND p.category_id = :category";
            $params[':category'] = $category;
        }

        $sql .= " ORDER BY p.id DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* =======================
        STATISTIQUES
    ======================== */

    public function countProducts()
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM products");
        return $stmt->fetchColumn();
    }

    public function stockValue()
    {
        $stmt = $this->pdo->query("
            SELECT SUM(price * quantity)
            FROM products
        ");
        return $stmt->fetchColumn();
    }

    public function productsByCategory()
    {
        $stmt = $this->pdo->query("
            SELECT c.name, COUNT(p.id) AS total
            FROM categories c
            LEFT JOIN products p ON p.category_id = c.id
            GROUP BY c.id
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function lowStock($limit = 5)
    {
        $stmt = $this->pdo->prepare("
            SELECT name, quantity
            FROM products
            WHERE quantity <= :limit
            ORDER BY quantity ASC
        ");

        $stmt->execute([':limit' => $limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAvailableProducts()
    {
        $sql = "SELECT * FROM products WHERE quantity > 0 ORDER BY name";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByBarcode(string $barcode)
    {
    $stmt = $this->pdo->prepare(
        "SELECT * FROM products WHERE barcode = :barcode LIMIT 1"
    );
    $stmt->execute([':barcode' => $barcode]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}