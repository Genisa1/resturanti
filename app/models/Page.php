<?php

class Page {
    private $db;
    private $table = 'pages';

    public $id;
    public $title;
    public $slug;
    public $content;
    public $created_by;
    public $created_at;

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Get all pages
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
     * Get page by id
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
     * Get page by slug
     */
    public function getBySlug($slug) {
        $query = 'SELECT p.*, u.name as creator_name 
                  FROM ' . $this->table . ' p
                  LEFT JOIN users u ON p.created_by = u.id
                  WHERE p.slug = ?';
        
        $stmt = $this->db->prepare($query);
        $stmt->execute([$slug]);
        return $stmt->fetch();
    }

    /**
     * Create page
     */
    public function create() {
        // Generate slug from title
        $this->slug = $this->generateSlug($this->title);

        // Check if slug already exists
        if ($this->getBySlug($this->slug)) {
            $this->slug .= '-' . time();
        }

        $query = 'INSERT INTO ' . $this->table . ' 
                  (title, slug, content, created_by) 
                  VALUES (?, ?, ?, ?)';
        
        $stmt = $this->db->prepare($query);
        
        return $stmt->execute([
            $this->title,
            $this->slug,
            $this->content,
            $this->created_by
        ]);
    }

    /**
     * Update page
     */
    public function update($id) {
        $query = 'UPDATE ' . $this->table . ' 
                  SET title = ?, content = ? 
                  WHERE id = ?';
        
        $stmt = $this->db->prepare($query);
        
        return $stmt->execute([
            $this->title,
            $this->content,
            $id
        ]);
    }

    /**
     * Delete page
     */
    public function delete($id) {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = ?';
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$id]);
    }

    /**
     * Generate slug from title
     */
    private function generateSlug($title) {
        $slug = strtolower(trim($title));
        $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        $slug = trim($slug, '-');
        return $slug;
    }
}
