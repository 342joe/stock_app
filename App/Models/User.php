<?php

class User
{
    private $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->getConnection();
    }

    //CRUD//
    
    public function getAll()
    {
        $sql = "SELECT * FROM users ORDER BY id DESC";
        $stmt=$this->pdo-> prepare($sql);
        $stmt->execute();

    }

    public function create($data)
    {
        $sql="INSERT INTO users(id,name,email,password,role,created_at)
                    VALUES (:id,:name,:email,:password,:role,:created_at)";
        $stmt=$this->pdo->prepare($sql);
        
        return $stmt->execute([

                ':name' => $data['name'],
                ':email' => $data['email'],
                ':password'=> $data['password'],
                ':role'=> $data['role'],
                ':created_at' => $data['created_at']


        ]);
        
    }

    public function update($data)
    {
        $sql= "UPDATE users 
                SET name = :name,
                    email = :email,
                    password = :password,
                    role = :role,
                    created_at = :created_at
                WHERE id = :id    
                    ";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':name' => htmlspecialchars($data['name']),
            ':email' => htmlspecialchars($data['email']),
            'password' => htmlspecialchars($data['password']),
            ':role' => htmlspecialchars($data['role']),
            ':created_at' => htmlspecialchars($data['created_at']),
            ':id' => htmlspecialchars($data['id'])
        ]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id'=>$id
        ]);
    }

}

?>