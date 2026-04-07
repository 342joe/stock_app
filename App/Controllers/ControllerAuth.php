<?php
require_once './App/Models/User.php';

class ControllerAuth
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    // Afficher la page login
    public function login()
    {
        require_once './App/Views/Auth/login.php';
    }

    // Traitement du formulaire
   public function authenticate()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = $this->userModel->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {

            //  SESSION CRÉÉE ICI
            $_SESSION['user'] = [
                'id'    => $user['id'],
                'name'  => $user['name'],
                'email' => $user['email'],
                'role_name'  => $user['role_name']
            ];

            //  REDIRECTION APRÈS SESSION
            header('Location: index.php?action=home');
            exit;

        } else {
            header('Location: index.php?action=login&error=invalid');
            exit;
        }
    }
}

    public function logout()
    {
        session_destroy();
        header('Location: index.php?action=login');
        exit;
    }
}
