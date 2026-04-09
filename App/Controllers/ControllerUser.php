<?php
require_once './App/Models/User.php';
require_once './App/Models/Role.php';
require_once './App/Models/ActivityLog.php';

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

            //  LOG AVANT REDIRECTION
            $log = new ActivityLog();
            $log->log([
                'user_id' => $_SESSION['user']['id'],
                'action'  => 'Création',
                'module'  => 'Utilisateur',
                'description' => 'Création du compte : ' . $_POST['email']
            ]);

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

            //  LOG
            $log = new ActivityLog();
            $log->log([
                'user_id' => $_SESSION['user']['id'],
                'action'  => 'Modification',
                'module'  => 'Utilisateur',
                'description' => 'Modification du compte ID : ' . $_POST['id']
            ]);

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

            $log = new ActivityLog();
            $log->log([
                'user_id' => $_SESSION['user']['id'],
                'action'  => 'Suppression',
                'module'  => 'Utilisateur',
                'description' => 'Suppression du compte ID : ' . $_GET['id']
            ]);

            header('Location: index.php?action=users&success=deleted');
            exit;
        }
    }

    // ================= MY PROFILE =================
    public function profile()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $user = $this->userModel->findById($userId);

        require './App/Views/User/profile.php';
    }

    // ================= UPDATE MY PROFILE =================
    public function updateProfile()
    {
        if (!isset($_SESSION['user'])) {
            http_response_code(403);
            die('Accès interdit');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $userId = $_SESSION['user']['id'];

            $data = [
                'name'  => trim($_POST['name']),
                'email' => trim($_POST['email'])
            ];

            $this->userModel->updateProfile($userId, $data);

            $_SESSION['user']['name']  = $data['name'];
            $_SESSION['user']['email'] = $data['email'];

            //  LOG AVANT REDIRECTION
            $log = new ActivityLog();
            $log->log([
                'user_id' => $userId,
                'action'  => 'Modification',
                'module'  => 'Profil',
                'description' => 'Modification des informations personnelles'
            ]);

            header('Location: index.php?action=profile&success=updated');
            exit;
        }
    }

    // ================= UPDATE MY PASSWORD =================
    public function updateMyPassword()
    {
        if (!isset($_SESSION['user'])) {
            http_response_code(403);
            die('Accès interdit');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $userId = $_SESSION['user']['id'];
            $user   = $this->userModel->findById($userId);

            if (!password_verify($_POST['current_password'], $user['password'])) {
                header('Location: index.php?action=profile&error=password');
                exit;
            }

            $newPassword = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
            $this->userModel->updatePassword($userId, $newPassword);

            $log = new ActivityLog();
            $log->log([
                'user_id' => $userId,
                'action'  => 'Modification',
                'module'  => 'Sécurité',
                'description' => 'Changement du mot de passe'
            ]);

            header('Location: index.php?action=profile&success=password');
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

        $log = new ActivityLog();
        $log->log([
            'user_id' => $_SESSION['user']['id'],
            'action'  => 'Désactivation',
            'module'  => 'Utilisateur',
            'description' => 'Désactivation du compte ID : ' . $_GET['id']
        ]);

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

        $log = new ActivityLog();
        $log->log([
            'user_id' => $_SESSION['user']['id'],
            'action'  => 'Activation',
            'module'  => 'Utilisateur',
            'description' => 'Activation du compte ID : ' . $_GET['id']
        ]);

        header('Location: index.php?action=users');
        exit;
    }
}
}