<?php

class User {
    private $db;
    private $table = 'users';

    public $id;
    public $name;
    public $email;
    public $password;
    public $role;
    public $created_at;

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Get user by id
     */
    public function getById($id) {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE id = ?';
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Get user by email
     */
    public function getByEmail($email) {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE email = ?';
        $stmt = $this->db->prepare($query);
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    /**
     * Create user
     */
    public function create() {
        $query = 'INSERT INTO ' . $this->table . ' 
                  (name, email, password, role) 
                  VALUES (?, ?, ?, ?)';
        
        $stmt = $this->db->prepare($query);
        
        // Hash password
        $hashedPassword = password_hash($this->password, PASSWORD_BCRYPT);
        
        $stmt->execute([
            $this->name,
            $this->email,
            $hashedPassword,
            $this->role ?? 'user'
        ]);

        return $stmt->rowCount() > 0;
    }

    /**
     * Update user
     */
    public function update($id) {
        $query = 'UPDATE ' . $this->table . ' 
                  SET name = ?, email = ?, role = ? 
                  WHERE id = ?';
        
        $stmt = $this->db->prepare($query);
        
        return $stmt->execute([
            $this->name,
            $this->email,
            $this->role,
            $id
        ]);
    }

    /**
     * Delete user
     */
    public function delete($id) {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = ?';
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$id]);
    }

    /**
     * Get all users
     */
    public function getAll() {
        $query = 'SELECT id, name, email, role, created_at FROM ' . $this->table . ' ORDER BY created_at DESC';
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Verify password
     */
    public function verifyPassword($email, $password) {
        $user = $this->getByEmail($email);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
}
