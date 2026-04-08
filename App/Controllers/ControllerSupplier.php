<?php
require_once './App/Models/Supplier.php';

class ControllerSupplier
{
    private $modelSupplier;
   

    public function __construct()
    {
        $this->modelSupplier = new Supplier();
    }

    public function index()
    {
        $supplier = $this->modelSupplier->getAll();
        require './App/Views/Supplier/index.php';
    }

    public function store()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST')
            {
                $this->checkCsrf();

                $data = [
                    'name' => htmlspecialchars($_POST['name']),
                    'phone' => htmlspecialchars($_POST['phone']),
                    'email' => htmlspecialchars($_POST['email']),
                    'address' => htmlspecialchars($_POST['address']),
                    'created_at' => htmlspecialchars($_POST['created_at'])

                ];

                $supplier = $this->modelSupplier->create($data);
                header('Location: index.php?action=supplier');
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
                    'email' => htmlspecialchars($_POST['email']),
                    'address' => htmlspecialchars($_POST['address']),
                    'created_at' => htmlspecialchars($_POST['created_at'])

                ];
                $this->modelSupplier->update($data);
                header('Location: index.php?action=supplier');
                exit();
            }
    }

    public function delete()
    {
        if(isset($_POST['id']))
            {
                $this->checkCsrf();
                $id = $_POST['id'];
                $result = $this->modelSupplier->delete($id);

                if($result)
                    {
                        header("Location: index.php?action=supplier");
                        exit();
                    }else{
                        echo"Échec lors de la suppression";
                    }
                header('Location: index.php?action=supplier');
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