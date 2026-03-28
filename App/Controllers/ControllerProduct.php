<?php
require_once './App/Models/Products.php';

class ControllerProduct
{
    private $productModel;

    public function __construct()
    {
        $this->productModel = new Products();
    }

    public function index()
    {
        $product = $this->productModel->getAll();
        require_once './App/Views/Product/index.php';
    } 

    public function store()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST')
            {
                $name = htmlspecialchars($_POST['name']);
                $description = htmlspecialchars($_POST['description']);
                $price = htmlspecialchars( $_POST['price']);
                $purchase_price = htmlspecialchars($_POST['purchase_price']);
                $quantity = htmlspecialchars($_POST['quantity']);
                $barcode = htmlspecialchars($_POST['barcode']);
                $category_id = htmlspecialchars($_POST['category_id']);
                $created_at = htmlspecialchars($_POST['created_at']);

                $result = $this->productModel->create(
                    $name,$description,$price,$purchase_price,$quantity,$barcode,$category_id,$created_at);
                    if($result)
                        {
                            header("Location: index.php?action=products");
                            exit();
                        }else
                        {
                            echo "Erreur lors de la creation";
                        }
            }
    }

    public function update()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST')
            {
                $id = $_POST['id'];
                $name = $_POST['name'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $purchase_price = $_POST['purchase_price'];
                $quantity = $_POST['quantity'];
                $barcode = $_POST['barcode'];
                $category_id = $_POST['category_id'];
                $created_at = $_POST['created_at'];

                $result = $this->productModel->update(
                    $id,$name,$description,$price,$purchase_price,$quantity,$barcode,$category_id,$created_at);
                    if($result)
                        {
                            echo "utilisateur update avec succes";
                        }else
                        {
                            echo "Erreur lors de la mis a jour";
                        }
            }
    }

    public function Delete()
    {
        if(isset($_GET['id']))
            {
                $id = $_GET['id'];
                $result = $this->productModel->delete($id);

                if($result){
                    echo "Suppression reussi avec succes";
                }else{
                    echo "Echec de lors de la suppression";
                }
            }
    }
}












?>