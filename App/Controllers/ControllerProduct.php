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
        $view = 'list';
        require_once './App/Views/Product/index.php';
    } 

    public function store()
    {
        $view = 'create';
        if($_SERVER['REQUEST_METHOD'] === 'POST')
            {
            
            $data =[
                'name' => htmlspecialchars($_POST['name']),
                'description' => htmlspecialchars($_POST['description']),
                'price' => htmlspecialchars( $_POST['price']),
                'purchase_price' => htmlspecialchars($_POST['purchase_price']),
                'quantity' => htmlspecialchars($_POST['quantity']),
                'barcode' => htmlspecialchars($_POST['barcode']),
                'category_id' => htmlspecialchars($_POST['category_id']),
                'created_at' => htmlspecialchars($_POST['created_at']),
            ];
                $result = $this->productModel->create($data);
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
              $data=[
                  'id' => $_POST['id'],
                'name' => $_POST['name'],
                'description' =>$_POST['description'],
                'price' => $_POST['price'],
                'purchase_price' => $_POST['purchase_price'],
                'quantity' => $_POST['quantity'],
                'barcode' => $_POST['barcode'],
                'category_id' => $_POST['category_id'],
                'created_at' => $_POST['created_at'],
              ];
                $result = $this->productModel->update($data);
                    if($result)
                        {
                            echo "Produit mis à jour avec succès";
                        }else
                        {
                            echo "Erreur lors de la mise à jour";
                        }
            }
            $view = 'edit';
    }

    public function Delete()
    {
        if(isset($_GET['id']))
            {
                $id = $_GET['id'];
                $result = $this->productModel->delete($id);

                if($result){
                    echo "Suppression réussie";
                }else{
                    echo "chec lors de la suppression";
                }
            }
    }
}












?>