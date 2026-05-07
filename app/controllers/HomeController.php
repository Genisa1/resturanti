<?php

class HomeController {
    private $db;
    private $newsModel;
    private $productModel;
    private $pageModel;

    public function __construct($db) {
        $this->db = $db;
        require_once 'app/models/News.php';
        require_once 'app/models/Product.php';
        require_once 'app/models/Page.php';
        
        $this->newsModel = new News($db);
        $this->productModel = new Product($db);
        $this->pageModel = new Page($db);
    }

    /**
     * Display home page
     */
    public function index() {
        $page = $this->pageModel->getBySlug('home');
        $latestNews = $this->newsModel->getLatest(3);
        $featuredProducts = $this->productModel->getAll();

        require_once 'app/views/home.php';
    }
}
