<?php

class Product {
    private $db;
    private $table = 'products';

    public $id;
    public $title;
    public $description;
    public $image;
    public $pdf;
    public $created_by;
    public $created_at;

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Get all products
     */
    public function getAll() {
        $query = 'SELECT p.*, u.name as creator_name 
                  FROM ' . $this->table . ' p
                  LEFT JOIN users u ON p.created_by = u.id
                  ORDER BY p.created_at DESC';
        
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Get product by id
     */
    public function getById($id) {
        $query = 'SELECT p.*, u.name as creator_name 
                  FROM ' . $this->table . ' p
                  LEFT JOIN users u ON p.created_by = u.id
                  WHERE p.id = ?';
        
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Create product
     */
    public function create() {
        $query = 'INSERT INTO ' . $this->table . ' 
                  (title, description, image, pdf, created_by) 
                  VALUES (?, ?, ?, ?, ?)';
        
        $stmt = $this->db->prepare($query);
        
        return $stmt->execute([
            $this->title,
            $this->description,
            $this->image,
            $this->pdf,
            $this->created_by
        ]);
    }

    /**
     * Update product
     */
    public function update($id) {
        $query = 'UPDATE ' . $this->table . ' 
                  SET title = ?, description = ?, image = ?, pdf = ? 
                  WHERE id = ?';
        
        $stmt = $this->db->prepare($query);
        
        return $stmt->execute([
            $this->title,
            $this->description,
            $this->image,
            $this->pdf,
            $id
        ]);
    }

    /**
     * Delete product
     */
    public function delete($id) {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = ?';
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$id]);
    }
}
