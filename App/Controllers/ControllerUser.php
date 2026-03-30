<?php
require_once './App/Models/User.php';

class ControllerUser
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function index()
    {
        $user =$this->userModel->getAll();
         require_once './App/Views/User/index.php';
    }

    public function store($data)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
            {
                
            }
    }
}





?>