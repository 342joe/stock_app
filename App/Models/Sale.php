<?php

class Sale
{
    private $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->getConnection();
    }

    // ================= CREATE SALE =================
    /**
     * Enregistre une vente ET met à jour le stock
     * Utilise une transaction pour éviter les incohérences
     */
    public function create($data)
    {
        try {
            // Démarrage transaction
            $this->pdo->beginTransaction();

            //  Vérifier le stock actuel
            $sqlStock = "SELECT quantity, price FROM products WHERE id = :product_id FOR UPDATE";
            $stmtStock = $this->pdo->prepare($sqlStock);
            $stmtStock->execute([
                ':product_id' => $data['product_id']
            ]);

            $product = $stmtStock->fetch(PDO::FETCH_ASSOC);

            if (!$product) {
                throw new Exception('Produit introuvable');
            }

            if ($product['quantity'] < $data['quantity']) {
                throw new Exception('Stock insuffisant');
            }

            //  Calcul du prix
            $unitPrice  = $product['price'];
            $totalPrice = $unitPrice * $data['quantity'];

            //  Enregistrer la vente
            $sqlSale = "
                INSERT INTO sales (product_id, user_id, quantity, unit_price, total_price)
                VALUES (:product_id, :user_id, :quantity, :unit_price, :total_price)
            ";

            $stmtSale = $this->pdo->prepare($sqlSale);
            $stmtSale->execute([
                ':product_id'  => $data['product_id'],
                ':user_id'     => $data['user_id'],
                ':quantity'    => $data['quantity'],
                ':unit_price'  => $unitPrice,
                ':total_price' => $totalPrice
            ]);

            // 4 Mettre à jour le stock
            $sqlUpdateStock = "
                UPDATE products
                SET quantity = quantity - :quantity
                WHERE id = :product_id
            ";

            $stmtUpdate = $this->pdo->prepare($sqlUpdateStock);
            $stmtUpdate->execute([
                ':quantity'   => $data['quantity'],
                ':product_id' => $data['product_id']
            ]);

            //  Validation transaction
            $this->pdo->commit();

            return true;

        } catch (Exception $e) {
            //  Annulation transaction en cas d’erreur
            $this->pdo->rollBack();
            throw $e;
        }
    }

    // ================= GET ALL SALES =================
    public function getAll()
    {
        $sql = "
            SELECT s.*, 
                   p.name AS product_name,
                   u.name AS seller_name
            FROM sales s
            JOIN products p ON s.product_id = p.id
            JOIN users u ON s.user_id = u.id
            ORDER BY s.created_at DESC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ================= GET SALES BY USER =================
    public function getByUser($userId)
    {
        $sql = "
            SELECT s.*, p.name AS product_name
            FROM sales s
            JOIN products p ON s.product_id = p.id
            WHERE s.user_id = :user_id
            ORDER BY s.created_at DESC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':user_id' => $userId
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ================= GET SALES BY PRODUCT =================
    public function getByProduct($productId)
    {
        $sql = "
            SELECT s.*, u.name AS seller_name
            FROM sales s
            JOIN users u ON s.user_id = u.id
            WHERE s.product_id = :product_id
            ORDER BY s.created_at DESC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':product_id' => $productId
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}