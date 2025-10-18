<?php

require_once __DIR__ . '/../config/database.php';

class Category
{
    private $conn;

    private function __construct()
    {
        $this->conn = Database::getConnection();
    }

    // get all categories
    public function getAll()
    {
        try {
            $query = "SELECT * FROM categories ORDER by name ASC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $th) {
            error_log("Get categories error: " . $th->getMessage());
            return [];
        }
    }

    // get category by ID
    public function getById($id)
    {
        try {
            $query = "SELECT * FROM categories WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $th) {
            error_log("Get category by id error: " . $th->getMessage());
            return false;
        }
    }

    // Create a new Category
    public function createCategory($data)
    {
        try {
            $query = "INSERT INTO categories (name, description, icon) VALUES (:name, :description, :icon)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':name', $data['name']);
            $stmt->bindParam(':description', $data['description']);
            $stmt->bindParam(':icon', $data['icon']);
            return $stmt->execute();
        } catch (PDOException $th) {
            error_log("Create new category error: " . $th->getMessage());
            return false;
        }
    }

    // update category
    public function updateCategory($id, $data){
        try {
            $query = "UPDATE categories SET name = :name, description = :description, icon = :icon WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':name', $data['name']);
            $stmt->bindParam(':description', $data['description']);
            $stmt->bindParam(':icon', $data['icon']);
            return $stmt->execute();

        } catch (PDOException $th) {
            error_log("Update category error: " . $th->getMessage());
            return false;
        }
    }

    // delete category

    public function deleteCategory($id){
        try {
            $query = "DELETE FROM categories WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();

        } catch (PDOException $th) {
            error_log('Delete category error: ' . $th->getMessage());
            return false;
        }
    }
}
