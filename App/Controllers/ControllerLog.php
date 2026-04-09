<?php
require_once './App/Models/ActivityLog.php';

class ControllerLog
{
    private $logModel;

    public function __construct()
    {
        $this->logModel = new ActivityLog();
    }

    public function index()
    {
        if ($_SESSION['user']['role_name'] !== 'admin') {
            http_response_code(403);
            die('Accès interdit');
        }

        $logs = $this->logModel->getAll();
        require './App/Views/Logs/index.php';
    }
}