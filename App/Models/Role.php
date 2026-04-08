<?php

class Role
{
    private $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->getConnection();
    }

    public function getAll()
    {
        $sql = "SELECT * FROM roles ORDER BY name ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countAll()
    {
        $sql = "SELECT COUNT(*) AS total FROM roles";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetch()['total'];
    }
}
