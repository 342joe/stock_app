<?php

class User
{
    private $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->getConnection();
    }

    // ================= GET USER BY ID =================
    public function findById($id)
    {
    $sql = "
        SELECT u.*, r.name AS role_name
        FROM users u
        LEFT JOIN roles r ON u.role_id = r.id
        WHERE u.id = :id
        LIMIT 1
    ";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([':id' => $id]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    // ================= GET ALL USERS =================
    public function getAll()
    {
    $sql = "
        SELECT u.*, r.name AS role_name
        FROM users u
        LEFT JOIN roles r ON u.role_id = r.id
        ORDER BY u.id DESC
    ";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ================= CREATE USER =================
    public function create($data)
    {
        $sql = "
            INSERT INTO users (name, email, password, role_id, created_at)
            VALUES (:name, :email, :password, :role_id, NOW())
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':name'     => $data['name'],
            ':email'    => $data['email'],
            ':password' => $data['password'], // déjà hashé
            ':role_id'  => $data['role_id']
        ]);
    }

    // ================= UPDATE USER =================
    public function update($data)
    {
        $sql = "
            UPDATE users
            SET name = :name,
                email = :email,
                role_id = :role_id
            WHERE id = :id
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':name'    => $data['name'],
            ':email'   => $data['email'],
            ':role_id' => $data['role_id'],
            ':id'      => $data['id']
        ]);
    }
    // ================= UPDATE PROFILE (USER SETTINGS) =================
    public function updateProfile($id, $data)
    {
    $sql = "
        UPDATE users
        SET name = :name,
            email = :email
        WHERE id = :id
    ";

    $stmt = $this->pdo->prepare($sql);

    return $stmt->execute([
        ':name'  => $data['name'],
        ':email' => $data['email'],
        ':id'    => $id
    ]);
    }


    // ================= UPDATE PASSWORD =================
    public function updatePassword($id, $password)
    {
        $sql = "UPDATE users SET password = :password WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':password' => $password,
            ':id' => $id
        ]);
    }

    // ================= DELETE =================
    public function delete($id)
    {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':id' => $id
        ]);
    }

    // ================= AUTH =================
    public function findByEmail($email)
    {
    $sql = "
        SELECT u.*, r.name AS role_name
        FROM users u
        LEFT JOIN roles r ON u.role_id = r.id
        WHERE u.email = :email
          AND u.is_active = 1
        LIMIT 1
    ";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([':email' => $email]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

    // ================= ACTIVER =================
public function activate($id)
{
    $sql = "UPDATE users SET is_active = 1 WHERE id = :id";
    $stmt = $this->pdo->prepare($sql);
    return $stmt->execute([':id' => $id]);
}

// ================= DESACTIVER =================
public function deactivate($id)
{
    $sql = "UPDATE users SET is_active = 0 WHERE id = :id";
    $stmt = $this->pdo->prepare($sql);
    return $stmt->execute([':id' => $id]);
}

public function countAll()
{
        $sql = "SELECT COUNT(*) AS total FROM users";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetch()['total'];
}

}
