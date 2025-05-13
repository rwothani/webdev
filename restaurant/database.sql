CREATE DATABASE palace_restaurant;
USE palace_restaurant;

CREATE TABLE menu_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    category ENUM('local', 'foreign', 'special') NOT NULL,
    date DATE,
    image VARCHAR(255)
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(100) NOT NULL,
    customer_phone VARCHAR(20) NOT NULL,
    items TEXT NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    delivery_type ENUM('delivery', 'pickup') NOT NULL,
    time_slot TIME NOT NULL,
    status ENUM('pending', 'confirmed', 'delivered') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE time_slots (
    id INT AUTO_INCREMENT PRIMARY KEY,
    slot_time TIME NOT NULL,
    is_available BOOLEAN DEFAULT TRUE
);

CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default time slots (12:00 PM to 10:00 PM)
INSERT INTO time_slots (slot_time, is_available) VALUES
('12:00:00', TRUE),
('13:00:00', TRUE),
('14:00:00', TRUE),
('15:00:00', TRUE),
('16:00:00', TRUE),
('17:00:00', TRUE),
('18:00:00', TRUE),
('19:00:00', TRUE),
('20:00:00', TRUE),
('21:00:00', TRUE),
('22:00:00', TRUE);

-- Sample admin (username: admin, password: password123)
INSERT INTO admins (username, password) VALUES
('admin', '$2y$10$3z7e3Xz5tY9Qz3k2z5Xz3u9Qz3k2z5Xz3u9Qz3k2z5Xz3u9Qz3k2z');

-- Sample menu items
INSERT INTO menu_items (name, description, price, category, date, image) VALUES
('Jollof Rice', 'Spicy West African rice dish with tomatoes and peppers.', 8.50, 'local', NULL, 'assets/images/dish1.jpg'),
('Sushi Platter', 'Assorted fresh sushi with soy sauce and wasabi.', 15.00, 'foreign', NULL, 'assets/images/dish2.jpg'),
('Daily Special: Grilled Fish', 'Fresh catch of the day, grilled with herbs.', 12.00, 'special', CURDATE(), 'assets/images/dish3.jpg');