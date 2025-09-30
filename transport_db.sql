CREATE DATABASE IF NOT EXISTS transport_db;
USE transport_db;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    password VARCHAR(255),
    role ENUM('admin', 'user') DEFAULT 'user'
);

CREATE TABLE IF NOT EXISTS vehicles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    number_plate VARCHAR(50),
    capacity INT,
    route VARCHAR(100)
);

CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    vehicle_id INT,
    booking_date DATE,
    status ENUM('booked','cancelled') DEFAULT 'booked',
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (vehicle_id) REFERENCES vehicles(id)
);

-- Correct admin user with PHP password_hash('admin123', PASSWORD_BCRYPT)
INSERT INTO users (username, password, role) VALUES 
('admin', '$2y$10$N9qo8uLOickgx2ZMRZo5i.e1Oa4O1Jc94FPK3.Him9lZ/aeWc.WvG', 'admin');
