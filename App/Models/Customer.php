<?php

class Customer
{
    private $pdo;
    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->getConnection();
    }

    public function getAll()
    {
        $sql = "SELECT * FROM customers ORDER BY id DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $sql = "INSERT INTO customers(name,phone,address,created_at)
                    VALUES(:name,:phone,:address,:created_at)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':name' => htmlspecialchars($data['name']),
            ':phone' => htmlspecialchars($data['phone']),
            ':address' => htmlspecialchars($data['address']),
            ':created_at' => htmlspecialchars($data['created_at'])
        ]);
    }

    public function update($data)
    {
        $sql = "UPDATE customers 
                    SET 
                        name = :name,
                        phone = :phone,
                        address = :address,
                        created_at = :created_at
                    WHERE id = :id
        
            ";
    }

    public function delete($id)
    {
        $sql = "DELETE FROM customers WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    public function countAll()
    {
        $sql = "SELECT COUNT(*) AS total FROM customers";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetch()['total'];
    }
}



?>