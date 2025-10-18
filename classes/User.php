<?php
require_once __DIR__ . "/../config/database.php";

class User
{
    private $conn;

    public function __construct()
    {
        $this->conn = Database::getConnection();
    }

    // check if username of email already exists 
    private function usernameExists($username)
    {
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
    } // check if username of email already exists 
    private function EmailExists($email)
    {
        try {
            $query = "SELECT id FROM users WHERE email = :email";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (PDOException $th) {
            error_log('Username check error: ' . $th->getMessage());
            return false;
        }
    }


    // register user
    public function register($data)
    {

        try {
            if ($this->usernameExists($data['username'])) {
                return false;
            }

            if ($this->emailExists($data['email'])) {
                return false;
            }

            // hash password for security
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
            $query = "INSERT INTO users (username, email, password, full_name, phone, role) VALUES (:username, :email, :password, :full_name, :phone, :role)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':username', $data['username']);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':full_name', $data['full_name']);
            $stmt->bindParam(':phone', $data['phone']);

            // default role should be user
            $role = isset($data['role']) ? $data['role'] : 'user';
            $stmt->bindParam(':role', $role);

            if ($stmt->execute()) {
                return $this->conn->lastInsertId();
            }

            return false;
        } catch (PDOException $th) {
            error_log('User registration error: ' . $th->getMessage());
            return false;
        }
    }
}
