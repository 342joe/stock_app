<?php

require_once './App/Models/Products.php';
require_once './App/Models/Category.php';
require_once './App/Models/ActivityLog.php';


class ControllerProduct
{
    private $productModel;

    public function __construct()
    {
        $this->productModel = new Products();
    }

    
        // LISTE + STATISTIQUES
    

    public function index()
    {
        $product = $this->productModel->getAll();
        $view = 'list';

        $categoryModel = new Category();
        $categories = $categoryModel->getAll();

        //  STATISTIQUES
        $totalProducts = $this->productModel->countProducts();
        $stockValue = $this->productModel->stockValue();
        $productsByCategory = $this->productModel->productsByCategory();
        $lowStock = $this->productModel->lowStock();+

        require './App/Views/Product/index.php';
    }

  
        // AJOUT PRODUIT
    

    public function store()
    {
        $view = 'create';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => htmlspecialchars($_POST['name']),
                'description' => htmlspecialchars($_POST['description']),
                'price' => htmlspecialchars($_POST['price']),
                'purchase_price' => htmlspecialchars($_POST['purchase_price']),
                'quantity' => htmlspecialchars($_POST['quantity']),
                'barcode' => htmlspecialchars($_POST['barcode']),
                'category_id' => htmlspecialchars($_POST['category_id']),
                'created_at' => htmlspecialchars($_POST['created_at']),
            ];

            $result = $this->productModel->create($data);
            $log = new ActivityLog();
            $log->log([
                'user_id' => $_SESSION['user']['id'],
                'action'  => 'creation',
                'module'  => 'Produit',
                'description' =>'Nouvelle produit enregistrée (ID : ' . $result . ')'

            ]);

            if ($result) {
                header("Location: index.php?action=products");
                exit();
            } else {
                echo "Erreur lors de la création";
            }
        }
    }

        // MODIFICATION PRODUIT
    

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'id' => $_POST['id'],
                'name' => $_POST['name'],
                'description' => $_POST['description'],
                'price' => $_POST['price'],
                'purchase_price' => $_POST['purchase_price'],
                'quantity' => $_POST['quantity'],
                'barcode' => $_POST['barcode'],
                'category_id' => $_POST['category_id'],
                'created_at' => $_POST['created_at'],
            ];

            $result = $this->productModel->update($data);
            $log = new ActivityLog();
            $log->log([
                'user_id' => $_SESSION['user']['id'],
                'action'  => 'Création',
                'module'  => 'Produit_UPDATE',
                'description' => 'Modification du produit ID : ' .$_POST['id']
            ]);

            if ($result) {
                 header('Location: index.php?action=products');
            } else {
                echo "Erreur lors de la mise à jour";
            }
        }

        $view = 'edit';
    }

    
        // SUPPRESSION PRODUIT
    

    public function delete()
    {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];

            $result = $this->productModel->delete($id);
            $log = new ActivityLog();
            $log->log([
                'user_id' => $_SESSION['user']['id'],
                'action'  => 'PRODUIT_DELETE',
                'module'  => 'PRODUCT',
                'description' => 'Suppression du produit ID : ' . $id
            ]);

            if ($result) {
                header("Location: index.php?action=products");
                exit();
            } else {
                echo "Échec lors de la suppression";
            }
        }
    }

  
        // RECHERCHE + FILTRE
  

   public function search()
   {
        $q = $_GET['q'] ?? '';
        $category = $_GET['category'] ?? '';

        $product = $this->productModel->search($q, $category);
        $view = 'list';

        $categoryModel = new Category();
        $categories = $categoryModel->getAll();

    //  AJOUT DES STATISTIQUES 
        $totalProducts = $this->productModel->countProducts();
        $stockValue = $this->productModel->stockValue();
        $productsByCategory = $this->productModel->productsByCategory();
        $lowStock = $this->productModel->lowStock();

        require './App/Views/Product/index.php';
 }

 public function scan()
{
    header('Content-Type: application/json');

    $barcode = $_GET['barcode'] ?? '';
    if (!$barcode) {
        echo json_encode(['success' => false]);
        return;
    }

    $product = $this->productModel->findByBarcode($barcode);

    if ($product) {
        echo json_encode([
            'success' => true,
            'product' => $product
        ]);
    } else {
        echo json_encode(['success' => false]);
    }
}

    // ================= HISTORIQUE GLOBAL =================
    public function history()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $role = $_SESSION['user']['role_name'];
        if (!in_array($role, ['admin', 'responsable_stock'])) {
            http_response_code(403);
            die('Accès interdit');
        }

        $sales = $this->productModel->getAll();
        require './App/Views/Sales/history.php';
    }

}