<?php

class News {
    private $db;
    private $table = 'news';

    public $id;
    public $title;
    public $content;
    public $image;
    public $created_by;
    public $created_at;

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Get all news
     */
    public function getAll() {
        $query = 'SELECT n.*, u.name as creator_name 
                  FROM ' . $this->table . ' n
                  LEFT JOIN users u ON n.created_by = u.id
                  ORDER BY n.created_at DESC';
        
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Get news by id
     */
    public function getById($id) {
        $query = 'SELECT n.*, u.name as creator_name 
                  FROM ' . $this->table . ' n
                  LEFT JOIN users u ON n.created_by = u.id
                  WHERE n.id = ?';
        
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Get latest news (limit)
     */
    public function getLatest($limit = 5) {
        $query = 'SELECT n.*, u.name as creator_name 
                  FROM ' . $this->table . ' n
                  LEFT JOIN users u ON n.created_by = u.id
                  ORDER BY n.created_at DESC
                  LIMIT ?';
        
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(1, (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Create news
     */
    public function create() {
        $query = 'INSERT INTO ' . $this->table . ' 
                  (title, content, image, created_by) 
                  VALUES (?, ?, ?, ?)';
        
        $stmt = $this->db->prepare($query);
        
        return $stmt->execute([
            $this->title,
            $this->content,
            $this->image,
            $this->created_by
        ]);
    }

    /**
     * Update news
     */
    public function update($id) {
        $query = 'UPDATE ' . $this->table . ' 
                  SET title = ?, content = ?, image = ? 
                  WHERE id = ?';
        
        $stmt = $this->db->prepare($query);
        
        return $stmt->execute([
            $this->title,
            $this->content,
            $this->image,
            $id
        ]);
    }

    /**
     * Delete news
     */
    public function delete($id) {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = ?';
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$id]);
    }
}
