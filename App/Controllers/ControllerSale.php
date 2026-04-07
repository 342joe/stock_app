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

        $products = $this->productModel->getAvailableProducts();
        $cart = $_SESSION['cart'] ?? [];

        require './App/Views/Sales/index.php';
    }

    // ================= AJOUT AU PANIER =================
    public function addToCart()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $productId = (int) $_POST['product_id'];
            $quantity  = (int) $_POST['quantity'];

            if ($quantity <= 0) {
                header('Location: index.php?action=sales&error=quantite_invalide');
                exit;
            }

            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            $found = false;
            foreach ($_SESSION['cart'] as &$item) {
                if ($item['product_id'] === $productId) {
                    $item['quantity'] += $quantity;
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                $_SESSION['cart'][] = [
                    'product_id' => $productId,
                    'quantity'   => $quantity
                ];
            }

            header('Location: index.php?action=sales');
            exit;
        }
    }

    // ================= RETIRER DU PANIER =================
    public function removeFromCart()
    {
        if (isset($_GET['index']) && isset($_SESSION['cart'])) {
            $index = (int) $_GET['index'];
            unset($_SESSION['cart'][$index]);
            $_SESSION['cart'] = array_values($_SESSION['cart']);
        }

        header('Location: index.php?action=sales');
        exit;
    }

    // ================= VALIDER LA VENTE =================
    public function store()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=login');
            exit;
        }

        if (empty($_SESSION['cart'])) {
            header('Location: index.php?action=sales&error=panier_vide');
            exit;
        }

        // ✅ RÉCUPÉRATION DU MOYEN DE PAIEMENT
        $paymentMethod = $_POST['payment_method'] ?? 'cash';

        try {
            $saleId = $this->saleModel->createInvoice(
                $_SESSION['cart'],
                $_SESSION['user']['id'],
                $paymentMethod
            );

            unset($_SESSION['cart']);

            header('Location: index.php?action=invoice&id=' . $saleId);
            exit;

        } catch (Exception $e) {
            header('Location: index.php?action=sales&error=' . urlencode($e->getMessage()));
            exit;
        }
    }

    // ================= MES VENTES =================
    public function mySales()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $sales = $this->saleModel->getByUser($_SESSION['user']['id']);
        require './App/Views/Sales/my_sales.php';
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

        $sales = $this->saleModel->getAll();
        require './App/Views/Sales/history.php';
    }
}