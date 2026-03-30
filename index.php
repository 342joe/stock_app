<?php

require_once './App/Models/Products.php';
require_once './App/Controllers/ControllerProduct.php';

$action = $_GET['action'] ?? 'products';

switch ($action) {

    case 'home':
        echo "<h1>Bienvenue dans ton application StockApp </h1>";
        break;

    case 'products':
        $controller = new ControllerProduct();
        $controller->index();
        break;

    case 'product-create':
        $controller = new ControllerProduct();
        $controller->store();
        break;

    case 'product-edit':
        $controller = new ControllerProduct();
        $controller->update();
        break;

    case 'product-store':
        $controller = new ControllerProduct();
        $controller->store();
        break;

    case 'product-update':
        $controller = new ControllerProduct();
        $controller->update();
        break;

    case 'product-delete':
        $controller = new ControllerProduct();
        $controller->delete();
        break;

    default:
        http_response_code(404);
        echo "<h1>404 - Page introuvable </h1>";
        break;
}

?>