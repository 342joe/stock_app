<?php
require_once './App/Models/Sale.php';
require_once './App/Models/Products.php';

class ControllerSale
{
    private $saleModel;
    private $productModel;

    public function __construct()
    {
        $this->saleModel    = new Sale();
        $this->productModel = new Products();
    }

    // ================= PAGE VENTE =================
    // Accessible aux vendeurs / caissiers / admin
    public function index()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $role = $_SESSION['user']['role_name'];

        if (!in_array($role, ['admin', 'vendeur', 'caissier'])) {
            http_response_code(403);
            die('Accès interdit');
        }

        // Produits disponibles uniquement
        $products = $this->productModel->getAvailableProducts();

        require './App/Views/Sales/index.php';
    }

    // ================= ENREGISTRER VENTE =================
    public function store()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $role = $_SESSION['user']['role_name'];

        if (!in_array($role, ['admin', 'vendeur', 'caissier'])) {
            http_response_code(403);
            die('Accès interdit');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            try {
                $this->saleModel->create([
                    'product_id' => (int) $_POST['product_id'],
                    'user_id'    => $_SESSION['user']['id'],
                    'quantity'   => (int) $_POST['quantity']
                ]);

                header('Location: index.php?action=sales&success=completed');
                exit;

            } catch (Exception $e) {

                header('Location: index.php?action=sales&error=' . urlencode($e->getMessage()));
                exit;
            }
        }
    }

    // ================= HISTORIQUE DES VENTES =================
    // Admin / Responsable seulement
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

        $sales = $this->saleModel->getAll();

        require './App/Views/Sales/history.php';
    }

    // ================= MES VENTES =================
    // Pour les vendeurs
    public function mySales()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $sales = $this->saleModel->getByUser($_SESSION['user']['id']);

        require './App/Views/Sales/my_sales.php';
    }
}