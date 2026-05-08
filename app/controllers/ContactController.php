<?php

class ContactController {
    private $db;
    private $contactModel;

    public function __construct($db) {
        $this->db = $db;
        require_once 'app/models/Contact.php';
        $this->contactModel = new Contact($db);
    }

    /**
     * Display contact form
     */
    public function index() {
        require_once 'app/views/contact.php';
    }

    /**
     * Handle form submission
     */
    public function submit() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $message = trim($_POST['message'] ?? '');

            if ($name === '' || $email === '' || $message === '') {
                $_SESSION['error'] = 'Please fill in all required fields.';
                header('Location: ?page=contact');
                exit;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = 'Please provide a valid email address.';
                header('Location: ?page=contact');
                exit;
            }

            $this->contactModel->name = htmlspecialchars($name);
            $this->contactModel->email = htmlspecialchars($email);
            $this->contactModel->message = htmlspecialchars($message);

            if ($this->contactModel->create()) {
                $_SESSION['success'] = 'Thank you! We will get back to you soon.';
            } else {
                $_SESSION['error'] = 'Error submitting form. Please try again.';
            }

            header('Location: ?page=contact');
            exit;
        }
    }
}
