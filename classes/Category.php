<?php 

require_once __DIR__ . '/../config/database.php';

class Category{
    private $conn;

    private function __construct()
    {
        $this->conn = Database::getConnection();

    }

    // get all categories
    public function getAll(){
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
    public function getById($id){
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
}