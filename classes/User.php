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

    // Login user

    public function login($username, $password){
        try {
            // allow login with username or email
            $query = "SELECT * FROM users WHERE username = :username OR email = :username LIMIT 1"; // so here anything the user inputs, it will check if it matches the username or the email in the database
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            $user = $stmt->fetch();

            // verify password
            if ($user && password_verify($password, $user['password'])) {
                // start session and store user data
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['full_name'] = $user['full_name'];

                return $user;
            } 
            return false;


        } catch (PDOException $th) {
           error_log("User login error: " . $th->getMessage());
           return false;
        }
    }

    // logout user
    public function logout(){
        // destroy all session data
        session_unset();
        session_destroy();
        return true;

    }


    public function getById($id){
        try {
            $query = "SELECT id, username, email, full_name, phone, role, created_at FROM users WHERE id = :id";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $th) {
           error_log("Get user error: " . $th->getMessage());
           return false;
        }
    }

    // get all users
    public function getAll($limit = 50, $offset = 0){
        try {
            $query = "SELECT id, username, email, full_name, phone, role, created_at FROM users ORDER BY created_at DESC LIMIT :limit OFFSET :offset";

            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();

        } catch (PDOException $th) {
            error_log("Get users error: " . $th->getMessage());
            return [];
        }
    }

    // update user profile

    public function update($id, $data){
        try {
            $query = "UPDATE users SET full_name = :full_name, email = :email, phone = :phone ";

            // only update password if provided
            if(!empty($data['password'])){
                // if password is fille or present for updating, then add it to the query to update.
                $query .= ", password = :passoword";
            }

            $query .= " WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':full_name', $data['full_name']);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':phone', $data['phone']);

            if (!empty($data['password'])) {
                $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
                $stmt->bindParam(':password', $hashedPassword);
            }

            return $stmt->execute();

            


        } catch (PDOException $th) {
            error_log("Update user error: " . $th->getMessage());
            return false;
        }
    }

    // delete user
    public function delete($id){
        try {
            $query = "DELETE FROM users WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $th) {
            error_log('Delete user error: '. $th->getMessage());
            return false;
        }
    }

    // change user role (only Admin can)

    public function changeRole($id, $role){
        try {
            $query = "UPDATE users SET role = :role WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':role', $role);
            return $stmt->execute();
        } catch (PDOException $th) {
            error_log("Change role error: ", $th->getMessage());
            return false;
        }
    }

    // count total users
    public function total(){
        try {
            $query = "SELECT COUNT(*) as total FROM users";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result['total'];
        } catch (PDOException $th) {
            error_log("Count users error: " . $th->getMessage());
            return 0;
        }
    }
}
