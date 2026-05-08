<?php

class Database {
    private $host = 'localhost';
    private $db_name = 'website_db';
    private $username = 'root';
    private $password = '';
    private $conn;

    /**
     * Connect to database
     */
    public function connect() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                'mysql:host=' . $this->host . ';dbname=' . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch(PDOException $e) {
            echo 'Database Error: ' . $e->getMessage();
            return false;
        }

        return $this->conn;
    }

    /**
     * Get connection
     */
    public function getConnection() {
        if ($this->conn === null) {
            $this->connect();
        }
        return $this->conn;
    }

    /**
     * Close connection
     */
    public function closeConnection() {
        $this->conn = null;
    }
}
