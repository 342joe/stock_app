<?php

class ActivityLog
{
    private $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->getConnection();
    }

    // ================= CREATE LOG =================
    public function log($data)
    {
        $sql = "
            INSERT INTO activity_logs
            (user_id, action, module, description, ip_address)
            VALUES (:user_id, :action, :module, :description, :ip_address)
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':user_id'    => $data['user_id'],
            ':action'     => $data['action'],
            ':module'     => $data['module'],
            ':description'=> $data['description'] ?? null,
            ':ip_address' => $_SERVER['REMOTE_ADDR'] ?? null
        ]);
    }

    // ================= GET ALL (ADMIN) =================
    public function getAll()
    {
        $sql = "
            SELECT l.*, u.name
            FROM activity_logs l
            LEFT JOIN users u ON u.id = l.user_id
            ORDER BY l.created_at DESC
        ";

        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}
