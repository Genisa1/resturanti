<?php

class AdminController {
    private $db;
    private $userModel;
    private $productModel;
    private $newsModel;
    private $pageModel;
    private $contactModel;

    public function __construct($db) {
        $this->db = $db;
        require_once 'models/User.php';
        require_once 'models/Product.php';
        require_once 'models/News.php';
        require_once 'models/Page.php';
        require_once 'models/Contact.php';

        $this->userModel = new User($db);
        $this->productModel = new Product($db);
        $this->newsModel = new News($db);
        $this->pageModel = new Page($db);
        $this->contactModel = new Contact($db);

        // Check if user is logged in and is admin
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ?page=login');
            exit;
        }
    }

    /**
     * Display admin dashboard
     */
    public function dashboard() {
        require_once 'views/admin/dashboard.php';
    }

    /**
     * Manage products
     */
    public function manageProducts() {
        $action = $_GET['action'] ?? 'list';
        $products = $this->productModel->getAll();

        if ($action === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->addProduct();
        } elseif ($action === 'edit' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->updateProduct($_GET['id'] ?? 0);
        } elseif ($action === 'delete') {
            $this->deleteProduct($_GET['id'] ?? 0);
        }

        require_once 'views/admin/manage-products.php';
    }

    /**
     * Add product
     */
    private function addProduct() {
        $this->productModel->title = htmlspecialchars($_POST['title'] ?? '');
        $this->productModel->description = $_POST['description'] ?? '';
        $this->productModel->created_by = $_SESSION['user_id'];

        // Handle file uploads
        if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
            $this->productModel->image = $this->uploadFile($_FILES['image']);
        }

        if (isset($_FILES['pdf']) && $_FILES['pdf']['size'] > 0) {
            $this->productModel->pdf = $this->uploadFile($_FILES['pdf']);
        }

        if ($this->productModel->create()) {
            $_SESSION['success'] = 'Product added successfully!';
        } else {
            $_SESSION['error'] = 'Error adding product.';
        }

        header('Location: ?page=admin&action=manageProducts');
        exit;
    }

    /**
     * Update product
     */
    private function updateProduct($id) {
        $this->productModel->title = htmlspecialchars($_POST['title'] ?? '');
        $this->productModel->description = $_POST['description'] ?? '';

        // Handle file uploads
        if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
            $this->productModel->image = $this->uploadFile($_FILES['image']);
        }

        if (isset($_FILES['pdf']) && $_FILES['pdf']['size'] > 0) {
            $this->productModel->pdf = $this->uploadFile($_FILES['pdf']);
        }

        if ($this->productModel->update($id)) {
            $_SESSION['success'] = 'Product updated successfully!';
        } else {
            $_SESSION['error'] = 'Error updating product.';
        }

        header('Location: ?page=admin&action=manageProducts');
        exit;
    }

    /**
     * Delete product
     */
    private function deleteProduct($id) {
        if ($this->productModel->delete($id)) {
            $_SESSION['success'] = 'Product deleted successfully!';
        } else {
            $_SESSION['error'] = 'Error deleting product.';
        }

        header('Location: ?page=admin&action=manageProducts');
        exit;
    }

    /**
     * Manage news
     */
    public function manageNews() {
        $action = $_GET['action'] ?? 'list';
        $newsList = $this->newsModel->getAll();

        if ($action === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->addNews();
        } elseif ($action === 'edit' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->updateNews($_GET['id'] ?? 0);
        } elseif ($action === 'delete') {
            $this->deleteNews($_GET['id'] ?? 0);
        }

        require_once 'views/admin/manage-news.php';
    }

    /**
     * Add news
     */
    private function addNews() {
        $this->newsModel->title = htmlspecialchars($_POST['title'] ?? '');
        $this->newsModel->content = $_POST['content'] ?? '';
        $this->newsModel->created_by = $_SESSION['user_id'];

        if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
            $this->newsModel->image = $this->uploadFile($_FILES['image']);
        }

        if ($this->newsModel->create()) {
            $_SESSION['success'] = 'News added successfully!';
        } else {
            $_SESSION['error'] = 'Error adding news.';
        }

        header('Location: ?page=admin&action=manageNews');
        exit;
    }

    /**
     * Update news
     */
    private function updateNews($id) {
        $this->newsModel->title = htmlspecialchars($_POST['title'] ?? '');
        $this->newsModel->content = $_POST['content'] ?? '';

        if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
            $this->newsModel->image = $this->uploadFile($_FILES['image']);
        }

        if ($this->newsModel->update($id)) {
            $_SESSION['success'] = 'News updated successfully!';
        } else {
            $_SESSION['error'] = 'Error updating news.';
        }

        header('Location: ?page=admin&action=manageNews');
        exit;
    }

    /**
     * Delete news
     */
    private function deleteNews($id) {
        if ($this->newsModel->delete($id)) {
            $_SESSION['success'] = 'News deleted successfully!';
        } else {
            $_SESSION['error'] = 'Error deleting news.';
        }

        header('Location: ?page=admin&action=manageNews');
        exit;
    }

    /**
     * Manage pages
     */
    public function managePages() {
        $action = $_GET['action'] ?? 'list';
        $pages = $this->pageModel->getAll();

        if ($action === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->addPage();
        } elseif ($action === 'edit' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->updatePage($_GET['id'] ?? 0);
        } elseif ($action === 'delete') {
            $this->deletePage($_GET['id'] ?? 0);
        }

        require_once 'views/admin/manage-pages.php';
    }

    /**
     * Add page
     */
    private function addPage() {
        $this->pageModel->title = htmlspecialchars($_POST['title'] ?? '');
        $this->pageModel->content = $_POST['content'] ?? '';
        $this->pageModel->created_by = $_SESSION['user_id'];

        if ($this->pageModel->create()) {
            $_SESSION['success'] = 'Page added successfully!';
        } else {
            $_SESSION['error'] = 'Error adding page.';
        }

        header('Location: ?page=admin&action=managePages');
        exit;
    }

    /**
     * Update page
     */
    private function updatePage($id) {
        $this->pageModel->title = htmlspecialchars($_POST['title'] ?? '');
        $this->pageModel->content = $_POST['content'] ?? '';

        if ($this->pageModel->update($id)) {
            $_SESSION['success'] = 'Page updated successfully!';
        } else {
            $_SESSION['error'] = 'Error updating page.';
        }

        header('Location: ?page=admin&action=managePages');
        exit;
    }

    /**
     * Delete page
     */
    private function deletePage($id) {
        if ($this->pageModel->delete($id)) {
            $_SESSION['success'] = 'Page deleted successfully!';
        } else {
            $_SESSION['error'] = 'Error deleting page.';
        }

        header('Location: ?page=admin&action=managePages');
        exit;
    }

    /**
     * View contacts
     */
    public function viewContacts() {
        $contacts = $this->contactModel->getAll();
        require_once 'views/admin/view-contacts.php';
    }

    /**
     * Upload file
     */
    private function uploadFile($file) {
        $uploadDir = 'public/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $fileName = uniqid() . '_' . basename($file['name']);
        $uploadFile = $uploadDir . $fileName;

        if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
            return $fileName;
        }

        return null;
    }
}
