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
}