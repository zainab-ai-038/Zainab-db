-- Run this file in phpMyAdmin or MySQL CLI to create the database and table

CREATE DATABASE IF NOT EXISTS carrental_db;
USE carrental_db;

CREATE TABLE IF NOT EXISTS cars (
    id INT AUTO_INCREMENT PRIMARY KEY,
    car_name VARCHAR(100) NOT NULL,
    model VARCHAR(50) NOT NULL,
    license_plate VARCHAR(20) NOT NULL,
    rent_per_day DECIMAL(10,2) NOT NULL,
    status VARCHAR(20) NOT NULL,
    added_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Sample data (optional)
INSERT INTO cars (car_name, model, license_plate, rent_per_day, status) VALUES
('Toyota Corolla', '2022', 'LHR-1234', 5000.00, 'Available'),
('Honda Civic', '2021', 'LHR-5678', 6000.00, 'Rented'),
('Suzuki Alto', '2023', 'LHR-9101', 3000.00, 'Available');
