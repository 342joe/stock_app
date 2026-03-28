<?php

class Database
{
    private $conn;

    public function __construct()
    {
        if($this->conn == null)
            {
                $config = require __DIR__ . '/../config/database.php';

                try{
                    $this->conn = new  PDO(
                            "mysql:host={$config['host']};dbname={$config['stock_app']}",
                            $config['username'],
                            $config['password']
                    );

                    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                }catch(PDOException $e)
                {
                    die("Erreur de connexion : " .$e->getMessage());
                }
            }
   
    }
    public function getConnection()
    {
      return $this->conn;  
    }
}




?>