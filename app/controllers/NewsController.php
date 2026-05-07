<?php

class NewsController {
    private $db;
    private $newsModel;

    public function __construct($db) {
        $this->db = $db;
        require_once 'app/models/News.php';
        $this->newsModel = new News($db);
    }

    /**
     * Display all news
     */
    public function index() {
        $newsList = $this->newsModel->getAll();
        require_once 'app/views/news.php';
    }

    /**
     * Display single news item
     */
    public function view($id) {
        $newsItem = $this->newsModel->getById($id);
        require_once 'app/views/news-detail.php';
    }
}
