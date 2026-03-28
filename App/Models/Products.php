<?php

class Products
{
    private $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->getConnection();
    }

    // CRUD //
    
    public function getAll()
    {
        $sql = "SELECT * FROM products ORDER BY id DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $sql = "INSERT INTO products(
                        id,name,
                        description,
                        price,
                        purchase_price,
                        quantity,
                        barcode,
                        category_id,
                        created_at)
                    VALUES(
                        :id,:name,
                        :description,
                        :price,:purchase_price,
                        :quantity,:barcode,
                        :category_id,
                        :created_at

                    )";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id' => $data['id'],
            ':name' => $data['name'],
            ':description' => $data['description'],
            ':price'=> $data['price'],
            ':purchase_price' => $data['purchase_price'],
            ':quatity' => $data['quatity'],
            ':barcode' => $data['barcode'],
            ':category_id' => $data['category_id'],
            ':created_at' => $data['created_at']
        ]);
                 
                    
    }

    public function update($data)
    {
        $sql= "UPDATE products
                SET name = :name,
                    description = :description,
                    price = :price,
                    purchase_price = :purchase_price,
                    quantity = :quantity,
                    barcode = :barcode,
                    category_id = :category_id,
                    created_at = created_at
                WHERE id = :id
        ";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
                    ':name' => $data['name'],
                    ':description' => $data['description'],
                    ':price' => $data['price'],
                    ':purchase_price' =>$data['purchase_price'],
                    ':quantity' => $data['quantity'],
                    ':barcode' => $data['barcode'],
                    ':category_id' => $data['category_id'],
                    ':created_at' => $data['created_at'],
                    ':id' => $data['id']


        ]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM products WHERE id= :id ";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':id' => $id
        ]);
    }
}







?>