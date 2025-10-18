<?php 
require_once __DIR__ . "/../config/database.php";

class User{
    private $conn;
    
    public function __construct()
    {
        $this->conn = Database::getConnection();
    }

     // check if username of email already exists 
        private function usernameExists($username){
            try {
                $query = "SELECT id FROM users WHERE username = :username";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':username', $username);
                $stmt->execute();
                return $stmt->rowCount() > 0;
            } catch (PDOException $th) {
                error_log('Username check error: ' . $th->getMessage());
                return false;
            }
        }

}