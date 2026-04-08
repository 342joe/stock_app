<?php
require_once './App/Models/Customer.php';

class ControllerCustomer
{
    private $modelCustomer;

    public function __construct()
    {
        $this->modelCustomer = new Customer();
    }

    public function index()
    {
        $customer = $this->modelCustomer->getAll();
        require './App/Views/Customer/index.php';
    }

    public function store()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST')
            {
                $this->checkCsrf();

                $data = [
                    'name' => htmlspecialchars($_POST['name']),
                    'phone' => htmlspecialchars($_POST['phone']),
                    'address' => htmlspecialchars($_POST['address']),
                    'created_at' => htmlspecialchars($_POST['created_at'])

                ];

                $customer = $this->modelCustomer->create($data);
                header('Location: index.php?action=customer');
                exit();
            }
    }

    public function update()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST')
            {
                $this->checkCsrf();
                $data = [
                    'id' => htmlspecialchars($_POST['id']),
                    'name' => htmlspecialchars($_POST['name']),
                    'phone' => htmlspecialchars($_POST['phone']),
                    'address' => htmlspecialchars($_POST['address']),
                    'created_at' => htmlspecialchars($_POST['created_at'])

                ];
                $this->modelCustomer->update($data);
                header('Location: index.php?action=customer');
                exit();
            }
    }

    public function delete()
    {
        if(isset($_POST['id']))
            {
                $this->checkCsrf();
                $id = $_POST['id'];
                $result = $this->modelCustomer->delete($id);

                if($result)
                    {
                        header("Location: index.php?action=customer");
                        exit();
                    }else{
                        echo"Échec lors de la suppression";
                    }
                header('Location: index.php?action=customer');
                 exit();
            }
             
    }
        //Verification du token
        
    private function checkCsrf()
    {
        if (
            empty($_POST['csrf_token']) ||
             $_POST['csrf_token'] !== $_SESSION['csrf_token']
            ) {
        die('Action non autorisée (CSRF)');
    }
    }

}








?>