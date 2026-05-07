<?php

class AboutController {
    private $db;
    private $pageModel;

    public function __construct($db) {
        $this->db = $db;
        require_once 'app/models/Page.php';
        $this->pageModel = new Page($db);
    }

    /**
     * Display about page
     */
    public function index() {
        $page = $this->pageModel->getBySlug('about');

        require_once 'app/views/about.php';
    }
}
