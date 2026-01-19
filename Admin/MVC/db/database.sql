CREATE DATABASE IF NOT EXISTS beauty_admin_db;
USE beauty_admin_db;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
 
 name VARCHAR(100) NOT NULL,
 email VARCHAR(100) UNIQUE NOT NULL,
 phone VARCHAR(20),
    password VARCHAR(255) NOT NULL,
    user_type ENUM('admin', 'buyer') DEFAULT 'buyer',
    status ENUM('active', 'inactive') DEFAULT 'active',
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    );

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    category VARCHAR(100),
    stock INT DEFAULT 0,
  status ENUM('available', 'unavailable') DEFAULT 'available',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    );

-- CREATE TABLE complaints(
    -- id INT AUTO_INCREMENT PRIMARY KEY,
    -- user_id INT NOT NULL,
    -- subject VARCHAR(255) NOT NULL,
    -- message TEXT NOT NULL,
    -- status ENUM('pending', 'reject', 'resolved') DEFAULT 'pending',
    -- created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    -- updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    -- FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
-- );

CREATE TABLE activities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    action VARCHAR(255) NOT NULL,
    description TEXT,

    ip_address VARCHAR(45),

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAM
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    );


CREATE TABLE reports(
    id INT AUTO_INCREMENT PRIMARY KEY,
    report_type VARCHAR(100) NOT NULL,
    data Longtext ,

    generateed_by INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (generateed_by) REFERENCES users(id) ON DELETE CASCADE
    );

INSERT INTO users (name , email, phone, password, user_type, status) VALUES
('Admin User', 'admin@beauty.com','0123456789', '$admin123', 'admin', 'active');




    