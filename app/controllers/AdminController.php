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
        require_once 'app/models/User.php';
        require_once 'app/models/Product.php';
        require_once 'app/models/News.php';
        require_once 'app/models/Page.php';
        require_once 'app/models/Contact.php';

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
        require_once 'app/views/admin/dashboard.php';
    }

    /**
     * Manage products
     */
    public function manageProducts() {
        $task = $_GET['task'] ?? 'list';
        $products = $this->productModel->getAll();
        $product = null;

        if ($task === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->addProduct();
        } elseif ($task === 'edit' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->updateProduct($_GET['id'] ?? 0);
        } elseif ($task === 'delete') {
            $this->deleteProduct($_GET['id'] ?? 0);
        }

        if ($task === 'edit' && isset($_GET['id'])) {
            $product = $this->productModel->getById($_GET['id']);
        }

        require_once 'app/views/admin/manage-products.php';
    }

    /**
     * Add product
     */
    private function addProduct() {
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');

        if ($title === '' || $description === '') {
            $_SESSION['error'] = 'Product title and description are required.';
            header('Location: ?page=admin&action=manageProducts&task=add');
            exit;
        }

        $this->productModel->title = htmlspecialchars($title);
        $this->productModel->description = $description;
        $this->productModel->created_by = $_SESSION['user_id'];

        // Handle file uploads
        if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
            $image = $this->uploadFile($_FILES['image']);
            if ($image === false) {
                header('Location: ?page=admin&action=manageProducts&task=add');
                exit;
            }
            $this->productModel->image = $image;
        }

        if (isset($_FILES['pdf']) && $_FILES['pdf']['size'] > 0) {
            $pdf = $this->uploadFile($_FILES['pdf']);
            if ($pdf === false) {
                header('Location: ?page=admin&action=manageProducts&task=add');
                exit;
            }
            $this->productModel->pdf = $pdf;
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
        $existingProduct = $this->productModel->getById($id);
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');

        if ($title === '' || $description === '') {
            $_SESSION['error'] = 'Product title and description are required.';
            header('Location: ?page=admin&action=manageProducts&task=edit&id=' . $id);
            exit;
        }

        $this->productModel->title = htmlspecialchars($title);
        $this->productModel->description = $description;
        $this->productModel->image = $existingProduct['image'] ?? null;
        $this->productModel->pdf = $existingProduct['pdf'] ?? null;

        // Handle file uploads
        if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
            $image = $this->uploadFile($_FILES['image']);
            if ($image === false) {
                header('Location: ?page=admin&action=manageProducts&task=edit&id=' . $id);
                exit;
            }
            $this->productModel->image = $image;
        }

        if (isset($_FILES['pdf']) && $_FILES['pdf']['size'] > 0) {
            $pdf = $this->uploadFile($_FILES['pdf']);
            if ($pdf === false) {
                header('Location: ?page=admin&action=manageProducts&task=edit&id=' . $id);
                exit;
            }
            $this->productModel->pdf = $pdf;
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
        $task = $_GET['task'] ?? 'list';
        $newsList = $this->newsModel->getAll();
        $newsItem = null;

        if ($task === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->addNews();
        } elseif ($task === 'edit' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->updateNews($_GET['id'] ?? 0);
        } elseif ($task === 'delete') {
            $this->deleteNews($_GET['id'] ?? 0);
        }

        if ($task === 'edit' && isset($_GET['id'])) {
            $newsItem = $this->newsModel->getById($_GET['id']);
        }

        require_once 'app/views/admin/manage-news.php';
    }

    /**
     * Add news
     */
    private function addNews() {
        $title = trim($_POST['title'] ?? '');
        $content = trim($_POST['content'] ?? '');

        if ($title === '' || $content === '') {
            $_SESSION['error'] = 'News title and content are required.';
            header('Location: ?page=admin&action=manageNews&task=add');
            exit;
        }

        $this->newsModel->title = htmlspecialchars($title);
        $this->newsModel->content = $content;
        $this->newsModel->created_by = $_SESSION['user_id'];

        if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
            $image = $this->uploadFile($_FILES['image']);
            if ($image === false) {
                header('Location: ?page=admin&action=manageNews&task=add');
                exit;
            }
            $this->newsModel->image = $image;
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
        $existingNews = $this->newsModel->getById($id);
        $title = trim($_POST['title'] ?? '');
        $content = trim($_POST['content'] ?? '');

        if ($title === '' || $content === '') {
            $_SESSION['error'] = 'News title and content are required.';
            header('Location: ?page=admin&action=manageNews&task=edit&id=' . $id);
            exit;
        }

        $this->newsModel->title = htmlspecialchars($title);
        $this->newsModel->content = $content;
        $this->newsModel->image = $existingNews['image'] ?? null;

        if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
            $image = $this->uploadFile($_FILES['image']);
            if ($image === false) {
                header('Location: ?page=admin&action=manageNews&task=edit&id=' . $id);
                exit;
            }
            $this->newsModel->image = $image;
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
        $task = $_GET['task'] ?? 'list';
        $pages = $this->pageModel->getAll();
        $pageItem = null;

        if ($task === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->addPage();
        } elseif ($task === 'edit' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->updatePage($_GET['id'] ?? 0);
        } elseif ($task === 'delete') {
            $this->deletePage($_GET['id'] ?? 0);
        }

        if ($task === 'edit' && isset($_GET['id'])) {
            $pageItem = $this->pageModel->getById($_GET['id']);
        }

        require_once 'app/views/admin/manage-pages.php';
    }

    /**
     * Add page
     */
    private function addPage() {
        $title = trim($_POST['title'] ?? '');
        $content = trim($_POST['content'] ?? '');

        if ($title === '' || $content === '') {
            $_SESSION['error'] = 'Page title and content are required.';
            header('Location: ?page=admin&action=managePages&task=add');
            exit;
        }

        $this->pageModel->title = htmlspecialchars($title);
        $this->pageModel->content = $content;
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
        $title = trim($_POST['title'] ?? '');
        $content = trim($_POST['content'] ?? '');

        if ($title === '' || $content === '') {
            $_SESSION['error'] = 'Page title and content are required.';
            header('Location: ?page=admin&action=managePages&task=edit&id=' . $id);
            exit;
        }

        $this->pageModel->title = htmlspecialchars($title);
        $this->pageModel->content = $content;

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
        $task = $_GET['task'] ?? 'list';
        $contacts = $this->contactModel->getAll();
        $contactDetail = null;

        if ($task === 'view' && isset($_GET['id'])) {
            $contactDetail = $this->contactModel->getById($_GET['id']);
            if ($contactDetail && $contactDetail['status'] === 'new') {
                $this->contactModel->updateStatus($_GET['id'], 'read');
                $contactDetail['status'] = 'read';
                $contacts = $this->contactModel->getAll();
            }
        } elseif ($task === 'delete' && isset($_GET['id'])) {
            if ($this->contactModel->delete($_GET['id'])) {
                $_SESSION['success'] = 'Contact message deleted successfully.';
            } else {
                $_SESSION['error'] = 'Failed to delete contact message.';
            }
            header('Location: ?page=admin&action=viewContacts');
            exit;
        }

        require_once 'app/views/admin/view-contacts.php';
    }

    /**
     * Manage users
     */
    public function manageUsers() {
        $task = $_GET['task'] ?? 'list';
        $users = $this->userModel->getAll();

        if ($task === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->addUser();
        } elseif ($task === 'edit' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->updateUser($_GET['id'] ?? 0);
        } elseif ($task === 'delete') {
            $this->deleteUser($_GET['id'] ?? 0);
        }

        require_once 'app/views/admin/manage-users.php';
    }

    /**
     * Add new user
     */
    private function addUser() {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $role = $_POST['role'] ?? 'user';

        if ($name === '' || $email === '' || $password === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'Please enter a valid name, email, and password.';
            header('Location: ?page=admin&action=manageUsers&task=add');
            exit;
        }

        if (strlen($password) < 6) {
            $_SESSION['error'] = 'Password must be at least 6 characters long.';
            header('Location: ?page=admin&action=manageUsers&task=add');
            exit;
        }

        $this->userModel->name = htmlspecialchars($name);
        $this->userModel->email = htmlspecialchars($email);
        $this->userModel->password = $password;
        $this->userModel->role = $role;

        if ($this->userModel->create()) {
            $_SESSION['success'] = 'User added successfully';
            header('Location: ?page=admin&action=manageUsers');
            exit;
        } else {
            $_SESSION['error'] = 'Failed to add user';
        }
    }

    /**
     * Update user
     */
    private function updateUser($id) {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $role = $_POST['role'] ?? 'user';

        if ($name === '' || $email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'Please enter a valid name and email.';
            header('Location: ?page=admin&action=manageUsers&task=edit&id=' . $id);
            exit;
        }

        $this->userModel->name = htmlspecialchars($name);
        $this->userModel->email = htmlspecialchars($email);
        $this->userModel->role = $role;

        if ($this->userModel->update($id)) {
            $_SESSION['success'] = 'User updated successfully';
            header('Location: ?page=admin&action=manageUsers');
            exit;
        } else {
            $_SESSION['error'] = 'Failed to update user';
        }
    }

    /**
     * Delete user
     */
    private function deleteUser($id) {
        // Prevent deleting self
        if ($id == $_SESSION['user_id']) {
            $_SESSION['error'] = 'Cannot delete your own account';
            header('Location: ?page=admin&action=manageUsers');
            exit;
        }

        if ($this->userModel->delete($id)) {
            $_SESSION['success'] = 'User deleted successfully';
            header('Location: ?page=admin&action=manageUsers');
            exit;
        } else {
            $_SESSION['error'] = 'Failed to delete user';
        }
    }

    /**
     * Upload file
     */
    private function uploadFile($file) {
        if (!isset($file['tmp_name']) || $file['error'] !== UPLOAD_ERR_OK) {
            $_SESSION['error'] = 'There was a problem uploading the file. Please try again.';
            return false;
        }

        $allowedMime = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'pdf' => 'application/pdf'
        ];

        $uploadDir = 'public/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $baseName = pathinfo($file['name'], PATHINFO_FILENAME);
        $cleanName = preg_replace('/[^A-Za-z0-9_-]/', '_', $baseName);
        $fileName = uniqid() . '_' . $cleanName . '.' . $ext;
        $uploadFile = $uploadDir . $fileName;
        $mime = mime_content_type($file['tmp_name']);

        if (!array_key_exists($ext, $allowedMime)) {
            $_SESSION['error'] = 'Invalid file format. Only JPG, PNG, GIF, and PDF files are allowed.';
            return false;
        }

        if ($mime !== $allowedMime[$ext]) {
            if (!($ext === 'jpg' && $mime === 'image/jpeg')) {
                $_SESSION['error'] = 'Invalid file type. Please upload an image or PDF file.';
                return false;
            }
        }

        if ($file['size'] > 5 * 1024 * 1024) {
            $_SESSION['error'] = 'Upload failed. Files must be smaller than 5MB.';
            return false;
        }

        if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
            return $fileName;
        }

        $_SESSION['error'] = 'Failed to save uploaded file.';
        return false;
    }
}
