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
            $this->contactModel->name = htmlspecialchars($_POST['name'] ?? '');
            $this->contactModel->email = htmlspecialchars($_POST['email'] ?? '');
            $this->contactModel->message = htmlspecialchars($_POST['message'] ?? '');

            if ($this->contactModel->create()) {
                $_SESSION['success'] = 'Thank you! We will get back to you soon.';
                header('Location: ?page=contact');
                exit;
            } else {
                $_SESSION['error'] = 'Error submitting form. Please try again.';
                header('Location: ?page=contact');
                exit;
            }
        }
    }
}
