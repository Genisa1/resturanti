<?php

class Contact {
    private $db;
    private $table = 'contacts';

    public $id;
    public $name;
    public $email;
    public $message;
    public $status;
    public $created_at;

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Get all contacts
     */
    public function getAll() {
        $query = 'SELECT * FROM ' . $this->table . ' ORDER BY created_at DESC';
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Get contact by id
     */
    public function getById($id) {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE id = ?';
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Create contact (from contact form)
     */
    public function create() {
        $query = 'INSERT INTO ' . $this->table . ' 
                  (name, email, message) 
                  VALUES (?, ?, ?)';
        
        $stmt = $this->db->prepare($query);
        
        return $stmt->execute([
            $this->name,
            $this->email,
            $this->message
        ]);
    }

    /**
     * Update contact status
     */
    public function updateStatus($id, $status) {
        $query = 'UPDATE ' . $this->table . ' 
                  SET status = ? 
                  WHERE id = ?';
        
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$status, $id]);
    }

    /**
     * Delete contact
     */
    public function delete($id) {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = ?';
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$id]);
    }
}
