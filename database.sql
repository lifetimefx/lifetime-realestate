-- Create database
CREATE DATABASE IF NOT EXISTS lifetime_realestate;
USE lifetime_realestate;

-- Users table (for both regular users and admins)
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100),
    phone VARCHAR(20),
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Categories table
CREATE TABLE categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    description TEXT,
    icon VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Properties table
CREATE TABLE properties (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    category_id INT,
    property_type ENUM('sale', 'rent') NOT NULL,
    bedrooms INT,
    bathrooms INT,
    area DECIMAL(10, 2),
    location VARCHAR(200),
    address TEXT,
    image VARCHAR(255),
    featured BOOLEAN DEFAULT FALSE,
    status ENUM('available', 'sold', 'rented') DEFAULT 'available',
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id),
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Favorites table (wishlist)
CREATE TABLE favorites (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    property_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (property_id) REFERENCES properties(id),
    UNIQUE KEY unique_favorite (user_id, property_id)
);

-- Insert default admin user (password: admin123)
INSERT INTO users (username, email, password, full_name, role) 
VALUES ('admin', 'admin@lifetime.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin User', 'admin');

-- Insert sample categories
INSERT INTO categories (name, description, icon) VALUES
('Apartment', 'Modern apartments and flats', 'fa-building'),
('House', 'Single-family houses', 'fa-home'),
('Villa', 'Luxury villas', 'fa-hotel'),
('Land', 'Land and plots', 'fa-map'),
('Commercial', 'Commercial properties', 'fa-store');