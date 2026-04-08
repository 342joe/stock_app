<?php
require_once './App/Models/Products.php';
require_once './App/Models/Customer.php';
require_once './App/Models/Supplier.php';
require_once './App/Models/Category.php';
require_once './App/Models/User.php';


class ControllerHome
{
    public function index()
    {
        $productModel  = new Products();
        $customerModel = new Customer();
        $supplierModel = new Supplier();
        $categoryModel = new Category();
        $userModel     = new User();

        $stats = [
            'products'   => $productModel->countAll(),
            'categories' => $categoryModel->countAll(),
            'customers'  => $customerModel->countAll(),
            'suppliers'  => $supplierModel->countAll(),
            'users'      => $userModel->countAll(),
        ];

        require './App/Views/Home/index.php';
    }
}