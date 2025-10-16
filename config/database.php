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
