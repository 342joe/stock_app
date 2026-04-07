<?php

class Sale
{
    private $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->getConnection();
    }

    /**
     * Créer une FACTURE avec plusieurs produits (panier)
     * $cart = [
     *   ['product_id' => 1, 'quantity' => 2],
     *   ['product_id' => 5, 'quantity' => 1],
     * ]
     */
    public function createInvoice(array $cart, int $userId, string $paymentMethod): int
    {
        try {
            $this->pdo->beginTransaction();

            // 1️⃣ Créer la facture vide AVEC moyen de paiement ✅
            $stmtSale = $this->pdo->prepare(
                "INSERT INTO sales (user_id, total_amount, payment_method)
                 VALUES (:user_id, 0, :payment_method)"
            );
            $stmtSale->execute([
                ':user_id'         => $userId,
                ':payment_method'  => $paymentMethod
            ]);

            $saleId = $this->pdo->lastInsertId();
            $totalAmount = 0;

            // 2️⃣ Traiter chaque produit du panier
            foreach ($cart as $item) {

                // Verrouillage du produit
                $stmtProduct = $this->pdo->prepare(
                    "SELECT price, quantity FROM products WHERE id = :id FOR UPDATE"
                );
                $stmtProduct->execute([':id' => $item['product_id']]);
                $product = $stmtProduct->fetch(PDO::FETCH_ASSOC);

                if (!$product) {
                    throw new Exception("Produit introuvable");
                }

                if ($product['quantity'] < $item['quantity']) {
                    throw new Exception("Stock insuffisant pour un produit");
                }

                $unitPrice   = $product['price'];
                $lineTotal   = $unitPrice * $item['quantity'];
                $totalAmount += $lineTotal;

                // 3️⃣ Insérer ligne de facture
                $stmtItem = $this->pdo->prepare(
                    "INSERT INTO sale_items
                     (sale_id, product_id, quantity, unit_price, total_price)
                     VALUES (:sale_id, :product_id, :quantity, :unit_price, :total_price)"
                );
                $stmtItem->execute([
                    ':sale_id'     => $saleId,
                    ':product_id'  => $item['product_id'],
                    ':quantity'    => $item['quantity'],
                    ':unit_price'  => $unitPrice,
                    ':total_price' => $lineTotal
                ]);

                // 4️⃣ Mise à jour du stock
                $stmtUpdate = $this->pdo->prepare(
                    "UPDATE products
                     SET quantity = quantity - :qty
                     WHERE id = :id"
                );
                $stmtUpdate->execute([
                    ':qty' => $item['quantity'],
                    ':id'  => $item['product_id']
                ]);
            }

            // 5️⃣ Mettre à jour le total de la facture
            $stmtTotal = $this->pdo->prepare(
                "UPDATE sales SET total_amount = :total WHERE id = :id"
            );
            $stmtTotal->execute([
                ':total' => $totalAmount,
                ':id'    => $saleId
            ]);

            $this->pdo->commit();
            return $saleId;

        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    // ================= FACTURE COMPLETE =================
    public function getInvoice(int $saleId): array
    {
        $stmtSale = $this->pdo->prepare(
            "SELECT s.*, u.name AS seller
             FROM sales s
             JOIN users u ON u.id = s.user_id
             WHERE s.id = :id"
        );
        $stmtSale->execute([':id' => $saleId]);
        $sale = $stmtSale->fetch(PDO::FETCH_ASSOC);

        $stmtItems = $this->pdo->prepare(
            "SELECT si.*, p.name AS product_name
             FROM sale_items si
             JOIN products p ON p.id = si.product_id
             WHERE si.sale_id = :id"
        );
        $stmtItems->execute([':id' => $saleId]);

        return [
            'sale'  => $sale,
            'items' => $stmtItems->fetchAll(PDO::FETCH_ASSOC),
        ];
    }

    // ================= MES FACTURES (PAR VENDEUR) =================
    public function getByUser(int $userId): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT s.*
             FROM sales s
             WHERE s.user_id = :user_id
             ORDER BY s.created_at DESC"
        );
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ================= HISTORIQUE GLOBAL =================
    public function getAll(): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT s.*, u.name AS seller_name
             FROM sales s
             JOIN users u ON u.id = s.user_id
             ORDER BY s.created_at DESC"
        );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
