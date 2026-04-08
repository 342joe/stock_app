<?php

class Category
{
    private $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->getConnection();
    }

    public function getAll()
    {
        $sql = "SELECT * FROM categories ORDER BY id DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function create($data)
    {
        $sql= "INSERT INTO categories(name,description,created_at) VALUES (:name,:description,:created_at)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt ->execute([
            ':name' => htmlspecialchars($data['name']),
            ':description' => htmlspecialchars($data['description']),
            ':created_at' => htmlspecialchars($data['created_at'])

        ]);
    }

    public function update($data)
    {
        $sql = "UPDATE categories
                SET name = :name,
                    description = :description
                    created_at = :created_at,
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt -> execute([
            ':id' => $data['id'],
            ':name' => $data['name'],
            ':description' => $data['description']

        ]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM categories WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id'=>$id]);
    }

    public function countAll()
    {
        $sql = "SELECT COUNT(*) AS total FROM categories";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetch()['total'];
    }

}














?>