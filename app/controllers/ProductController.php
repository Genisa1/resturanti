<?php

class ProductController {
    private $db;
    private $productModel;

    public function __construct($db) {
        $this->db = $db;
        require_once 'app/models/Product.php';
        $this->productModel = new Product($db);
    }

    /**
     * Display all products
     */
    public function index() {
        $products = $this->productModel->getAll();
        require_once 'app/views/products.php';
    }

    /**
     * Display single product
     */
    public function view($id) {
        $product = $this->productModel->getById($id);
        require_once 'app/views/product-detail.php';
    }
}
