<?php

class Database
{
    private $conn = null;

    public function __construct()
    {
        if ($this->conn === null) {

            
            $config = require __DIR__ . '/../config/database.php';

            $host     = $config['host'];
            $dbname   = $config['dbname'];      
            $username = $config['username'];
            $password = $config['password'];

            try {
                $this->conn = new PDO(
                    "mysql:host=$host;dbname=$dbname;charset=utf8",
                    $username,
                    $password
                );

                // Mode d'erreur : exception
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            } catch (PDOException $e) {
                die("Erreur de connexion à la base de données : " . $e->getMessage());
            }
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }
}
?>