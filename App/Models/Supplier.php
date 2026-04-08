<?php

class Supplier
{
    private $pdo;
    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->getConnection();
    }

    public function getAll()
    {
        $sql = "SELECT * FROM suppliers ORDER BY id DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $sql = "INSERT INTO suppliers(name,phone,email,address,created_at)
                    VALUES(:name,:phone,:email,:address,:created_at)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':name' => htmlspecialchars($data['name']),
            ':phone' => htmlspecialchars($data['phone']),
            ':email' => htmlspecialchars($data['email']),
            ':address' => htmlspecialchars($data['address']),
            ':created_at' => htmlspecialchars($data['created_at'])
        ]);
    }

    public function update($data)
    {
        $sql = "UPDATE suppliers 
                    SET 
                        name = :name,
                        phone = :phone,
                        email = :email,
                        address = :address,
                        created_at = :created_at
                    WHERE id = :id
        
            ";
    }

    public function delete($id)
    {
        $sql = "DELETE FROM suppliers WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    public function countAll()
    {
        $sql = "SELECT COUNT(*) AS total FROM suppliers";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetch()['total'];
    }
}



?>