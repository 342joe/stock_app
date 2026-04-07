<?php
require_once './App/Models/User.php';
require_once './App/Models/Role.php';

class ControllerUser
{
    private $userModel;
    private $roleModel;

    public function __construct()
    {
        $this->userModel = new User();
        $this->roleModel = new Role();
    }

    // ================= LIST USERS =================
    public function index()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role_name'] !== 'admin') {
            http_response_code(403);
            die('Accès interdit');
        }

        $users = $this->userModel->getAll();
        $roles = $this->roleModel->getAll();

        require './App/Views/User/index.php';
    }

    // ================= CREATE USER =================
    public function store()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role_name'] !== 'admin') {
            http_response_code(403);
            die('Accès interdit');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $data = [
                'name'     => $_POST['name'],
                'email'    => $_POST['email'],
                'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                'role_id'  => (int) $_POST['role_id']
            ];

            $this->userModel->create($data);
            header('Location: index.php?action=users&success=created');
            exit;
        }
    }

    // ================= UPDATE USER =================
    public function update()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role_name'] !== 'admin') {
            http_response_code(403);
            die('Accès interdit');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $data = [
                'id'      => $_POST['id'],
                'name'    => $_POST['name'],
                'email'   => $_POST['email'],
                'role_id' => (int) $_POST['role_id']
            ];

            $this->userModel->update($data);

            if (!empty($_POST['password'])) {
                $this->userModel->updatePassword(
                    $_POST['id'],
                    password_hash($_POST['password'], PASSWORD_DEFAULT)
                );
            }

            header('Location: index.php?action=users&success=updated');
            exit;
        }
    }

    // ================= DELETE USER =================
    public function delete()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role_name'] !== 'admin') {
            http_response_code(403);
            die('Accès interdit');
        }

        if (isset($_GET['id'])) {
            $this->userModel->delete($_GET['id']);
            header('Location: index.php?action=users&success=deleted');
            exit;
        }
    }

    // ================= DESACTIVER =================
    public function deactivate()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role_name'] !== 'admin') {
            http_response_code(403);
            die('Accès interdit');
        }

        if (isset($_GET['id'])) {
            $this->userModel->deactivate($_GET['id']);
            header('Location: index.php?action=users');
            exit;
        }
    }

    // ================= ACTIVER =================
    public function activate()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role_name'] !== 'admin') {
            http_response_code(403);
            die('Accès interdit');
        }

        if (isset($_GET['id'])) {
            $this->userModel->activate($_GET['id']);
            header('Location: index.php?action=users');
            exit;
        }
    }
}
