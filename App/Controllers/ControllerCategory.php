<?php

require_once './App/Models/Category.php';



class ControllerCategory
{
    private $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new Category();
    }

    public function index()
    {
        $category = $this->categoryModel->getAll();
        require_once './App/Views/Category/index.php';
    }

    public function store()
    {
       if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $data=[
                'name' => htmlspecialchars($_POST['name']),
                'description' => htmlspecialchars($_POST['description']),
                'created_at' => htmlspecialchars($_POST['created_at'])
            ];

            $this->categoryModel->create($data);
        } 
    }

    public function update()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST')
            {
                $data = [
                    'id' => htmlspecialchars($_POST['id']),
                    'name' => htmlspecialchars($_POST['name']),
                    'description' => htmlspecialchars($_POST['description']),
                    'created_at' => htmlspecialchars($_POST['created_at'])
                ];

                $this->categoryModel->update($data);
            }
    }

    public function delete()
    {
        if(isset($_POST['id']))
            {
                $id = $_POST['id'];
                $result = $this->categoryModel->delete($id);
            }
            if($result)
                {
                    header("Location: index.php?action=category");
                    exit();
                }else{
                    echo "Échec lors de la suppression";
                }
    }
}











?>