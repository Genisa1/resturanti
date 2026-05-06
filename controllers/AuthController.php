<?php

class AuthController {
    private $db;
    private $userModel;

    public function __construct($db) {
        $this->db = $db;
        require_once 'models/User.php';
        $this->userModel = new User($db);
    }

    /**
     * Display login form
     */
    public function login() {
        // If already logged in, redirect to admin
        if (isset($_SESSION['user_id'])) {
            header('Location: ?page=admin');
            exit;
        }

        // Handle login submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            // Verify credentials
            $user = $this->userModel->verifyPassword($email, $password);

            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];

                header('Location: ?page=admin');
                exit;
            } else {
                $_SESSION['error'] = 'Invalid email or password';
            }
        }

        $title = 'Login';
        include 'views/login.php';
    }
}
