<?php
session_start();

// ================= ACTION =================
$action = $_GET['action'] ?? 'home';

// ================= PROTECTION GLOBALE =================
$publicActions = ['login', 'login-auth', 'logout'];

if (!isset($_SESSION['user']) && !in_array($action, $publicActions)) {
    header('Location: index.php?action=login');
    exit;
}

// ================= MODELS =================
require_once './App/Models/Products.php';
require_once './App/Models/Category.php';
require_once './App/Models/User.php';
require_once './App/Models/Sale.php';
require_once './App/Models/Customer.php';
require_once './App/Models/Supplier.php';

// ================= CONTROLLERS =================
require_once './App/Controllers/ControllerProduct.php';
require_once './App/Controllers/ControllerCategory.php';
require_once './App/Controllers/ControllerUser.php';
require_once './App/Controllers/ControllerHome.php';
require_once './App/Controllers/ControllerAuth.php';
require_once './App/Controllers/ControllerSale.php';
require_once './App/Controllers/ControllerCustomer.php';
require_once './App/Controllers/ControllerSupplier.php';

// ================= INSTANCES =================
$controllerProduct   = new ControllerProduct();
$controllerCategory  = new ControllerCategory();
$controllerUser      = new ControllerUser();
$controllerHome      = new ControllerHome();
$controllerAuth      = new ControllerAuth();
$controllerSale      = new ControllerSale();
$controllerCustomer  = new ControllerCustomer();
$controllerSupplier  = new ControllerSupplier();

// ================= ROUTER =================
switch ($action) {

    // ---------- AUTH ----------
    case 'login':
        $controllerAuth->login();
        break;

    case 'login-auth':
        $controllerAuth->authenticate();
        break;

    case 'logout':
        $controllerAuth->logout();
        break;

    // ---------- HOME ----------
    case 'home':
        $controllerHome->index();
        break;

    // ---------- PRODUCTS ----------
    case 'products':
        $controllerProduct->index();
        break;

    case 'products-search':
        $controllerProduct->search();
        break;

    case 'product-store':
        $controllerProduct->store();
        break;

    case 'product-update':
        $controllerProduct->update();
        break;

    case 'product-delete':
        $controllerProduct->delete();
        break;

    case 'product-scan':
        $controllerProduct->scan();
        break;

    // ---------- CATEGORIES ----------
    case 'categories':
        $controllerCategory->index();
        break;

    case 'category-store':
        $controllerCategory->store();
        break;

    case 'category-update':
        $controllerCategory->update();
        break;

    case 'category-delete':
        $controllerCategory->delete();
        break;

    // ---------- SALES ----------
    case 'sales':
        $controllerSale->index();
        break;

    case 'sale-add':
        $controllerSale->addToCart();
        break;

    case 'sale-remove':
        $controllerSale->removeFromCart();
        break;

    case 'sale-store':
        $controllerSale->store();
        break;

    case 'sales-history':
        $controllerSale->history();
        break;

    case 'my-sales':
        $controllerSale->mySales();
        break;

    // ---------- INVOICE ----------
    case 'invoice':
        require './App/Views/Sales/invoice.php';
        break;

    case 'invoice-pdf':
        require './App/Views/Sales/invoice_pdf.php';
        break;

    // ---------- USERS ----------
    case 'users':
        $controllerUser->index();
        break;

    case 'user-store':
        $controllerUser->store();
        break;

    case 'user-update':
        $controllerUser->update();
        break;

    case 'user-delete':
        $controllerUser->delete();
        break;

    case 'user-activate':
        $controllerUser->activate();
        break;

    case 'user-deactivate':
        $controllerUser->deactivate();
        break;

    // ---------- CUSTOMER ----------
    case 'customer':
        $controllerCustomer->index();
        break;

    case 'customer-store':
        $controllerCustomer->store();
        break;

    case 'customer-update':
        $controllerCustomer->update();
        break;

    case 'customer-delete':
        $controllerCustomer->delete();
        break;

    // ---------- SUPPLIER ----------
    case 'supplier':
        $controllerSupplier->index();
        break;

    case 'supplier-store':
        $controllerSupplier->store();
        break;

    case 'supplier-update':
        $controllerSupplier->update();
        break;

    case 'supplier-delete':
        $controllerSupplier->delete();
        break;

    // ---------- 404 ----------
    default:
        http_response_code(404);
        echo '<h1>404 - Page introuvable</h1>';
        break;
}
