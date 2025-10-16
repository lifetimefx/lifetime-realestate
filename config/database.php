<?php

// Database configuration file
// This file contains database connection settings and establishes a connection to the database using PDO (PHP Data Objects).

// Database credentials
define('DB_HOST', 'localhost');
define('DB_NAME', 'lifetime_realestate');
define('DB_USER', 'root');
define('DB_PASS', '');

// Base URL
define('BASE_URL', 'http://localhost/lifetime-realestate');


// File upload settings
define('UPLOAD_DIR', 'assets/uploads/properties');
define('MAX_FILE_SIZE', 5242880); // 5MB maximum size


// Database Connection Class using PDO

class Database{
    // private property to store database connection
    private static $connection = null;

    // Get database connnection

    public static function getConnection(){
        // check if connection already exists

        if(self::$connection === null){
            try {
                self::$connection = new PDO(
                    "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS, [
                        // set error mode to exception for better error handling
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        // fetch results as associative array as default
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        // disable emulated prepared statements for better security
                        PDO::ATTR_EMULATE_PREPARES => false
                    ]
                    );
            } catch (PDOException $e) {
                // if connection fails display error message
                die("Connection failed: " . $e->getMessage());
            }
        }

        // return the database connection

        return self::$connection;
    }

    // close database connection
    public static function closeConnection(){
        self::$connection = null;

    }

}

// session configuration 
// session starts if not already started
if(session_status() === PHP_SESSION_NONE){
    session_start();
}

// helper function to check if user is logged in
// returns boolean value of true if user is logged in and false if user is not
function loggedIn(){
    return isset($_SESSION['user_id']);

}

// helper function to check if user is admin
// returns boolean true is user is admin and false otherwise
function isAdmin(){
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

