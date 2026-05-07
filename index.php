<?php
/**
 * Main Application Router
 * OOP MVC Framework
 */

// Start session
session_start();

// Include configuration and models
require_once 'config/Database.php';

// Initialize database connection
$database = new Database();
$db = $database->connect();

if (!$db) {
    die('Database connection failed');
}

// Get the page parameter
$page = $_GET['page'] ?? 'home';
$action = $_GET['action'] ?? null;
$id = $_GET['id'] ?? null;

// Route to appropriate controller
switch ($page) {
    case 'home':
        require_once 'app/controllers/HomeController.php';
        $controller = new HomeController($db);
        $controller->index();
        break;

    case 'about':
        require_once 'app/controllers/AboutController.php';
        $controller = new AboutController($db);
        $controller->index();
        break;

    case 'products':
        require_once 'app/controllers/ProductController.php';
        $controller = new ProductController($db);
        
        if ($id) {
            $controller->view($id);
        } else {
            $controller->index();
        }
        break;

    case 'news':
        require_once 'app/controllers/NewsController.php';
        $controller = new NewsController($db);
        
        if ($id) {
            $controller->view($id);
        } else {
            $controller->index();
        }
        break;

    case 'contact':
        require_once 'app/controllers/ContactController.php';
        $controller = new ContactController($db);
        
        if ($_POST && isset($_POST['name'])) {
            $controller->submit();
        } else {
            $controller->index();
        }
        break;

    case 'admin':
        require_once 'app/controllers/AdminController.php';
        
        $action = $_GET['action'] ?? 'dashboard';
        
        try {
            $controller = new AdminController($db);
            
            switch ($action) {
                case 'manageProducts':
                    $controller->manageProducts();
                    break;
                case 'manageNews':
                    $controller->manageNews();
                    break;
                case 'managePages':
                    $controller->managePages();
                    break;
                case 'manageUsers':
                    $controller->manageUsers();
                    break;
                case 'viewContacts':
                    $controller->viewContacts();
                    break;
                default:
                    $controller->dashboard();
            }
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: ?page=login');
            exit;
        }
        break;

    case 'login':
        require_once 'app/controllers/AuthController.php';
        $controller = new AuthController($db);
        $controller->login();
        break;

    case 'register':
        require_once 'app/controllers/AuthController.php';
        $controller = new AuthController($db);
        $controller->register();
        break;

    case 'logout':
        session_destroy();
        header('Location: ?page=home');
        exit;
        break;

    default:
        header('Location: ?page=home');
        break;
}

// Close database connection
$database->closeConnection();
