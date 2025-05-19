<?php

namespace Aries\MiniFrameworkStore\Models;

use Aries\MiniFrameworkStore\Includes\Database;

class Category extends Database
{
    private $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = $this->getConnection();
    }

    public function getAll()
    {
        $sql = "SELECT * FROM product_categories ORDER BY name ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM product_categories WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $sql = "INSERT INTO product_categories (name, description, slug, created_at, updated_at) 
                VALUES (:name, :description, :slug, :created_at, :updated_at)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'slug' => $this->generateSlug($data['name']),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function update($id, $data)
    {
        $sql = "UPDATE product_categories 
                SET name = :name, 
                    description = :description, 
                    slug = :slug, 
                    updated_at = :updated_at 
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'slug' => $this->generateSlug($data['name']),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM product_categories WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    private function generateSlug($name)
    {
        // Basic slug generation - you might want to enhance this
        $slug = strtolower(trim($name));
        $slug = preg_replace('/[^a-z0-9-]+/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        return $slug;
    }
}