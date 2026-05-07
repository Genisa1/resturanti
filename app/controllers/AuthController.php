<?php

class AuthController {
    private $db;
    private $userModel;

    public function __construct($db) {
        $this->db = $db;
        require_once 'app/models/User.php';
        $this->userModel = new User($db);
    }

    /**
     * Display login form
     */
    public function login() {
        // If already logged in, redirect based on role
        if (isset($_SESSION['user_id'])) {
            if ($_SESSION['role'] === 'admin') {
                header('Location: ?page=admin');
            } else {
                header('Location: ?page=home');
            }
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

                // Redirect based on user role
                if ($user['role'] === 'admin') {
                    header('Location: ?page=admin');
                } else {
                    header('Location: ?page=home');
                }
                exit;
            } else {
                $_SESSION['error'] = 'Invalid email or password';
            }
        }

        $title = 'Login';
        include 'app/views/login.php';
    }

    /**
     * Display register form
     */
    public function register() {
        // If already logged in, redirect based on role
        if (isset($_SESSION['user_id'])) {
            if ($_SESSION['role'] === 'admin') {
                header('Location: ?page=admin');
            } else {
                header('Location: ?page=home');
            }
            exit;
        }

        // Handle registration submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            // Validation
            $errors = [];

            if (empty($name)) {
                $errors[] = 'Name is required';
            }

            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Valid email is required';
            }

            if (strlen($password) < 6) {
                $errors[] = 'Password must be at least 6 characters';
            }

            if ($password !== $confirmPassword) {
                $errors[] = 'Passwords do not match';
            }

            // Check if email already exists
            if ($this->userModel->getByEmail($email)) {
                $errors[] = 'Email already exists';
            }

            if (empty($errors)) {
                // Create user
                $this->userModel->name = $name;
                $this->userModel->email = $email;
                $this->userModel->password = $password;
                $this->userModel->role = 'user'; // Default role

                if ($this->userModel->create()) {
                    $_SESSION['success'] = 'Registration successful! Please login.';
                    header('Location: ?page=login');
                    exit;
                } else {
                    $_SESSION['error'] = 'Registration failed. Please try again.';
                }
            } else {
                $_SESSION['error'] = implode('<br>', $errors);
            }
        }

        $title = 'Register';
        include 'app/views/register.php';
    }
}
