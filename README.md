```
CREATE DATABASE ecommerce_db;

USE ecommerce_db;

-- Customers table
CREATE TABLE customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Products table
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255),
    stock INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Orders table
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    status VARCHAR(20) DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(id)
);

-- Order items table
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Insert some sample products
INSERT INTO products (name, description, price, image, stock) VALUES 
('Smartphone X', 'Latest smartphone with amazing features', 599.99, 'product1.jpg', 50),
('Wireless Headphones', 'Noise cancelling wireless headphones', 199.99, 'product2.jpg', 30),
('Smart Watch', 'Track your fitness with this smart watch', 249.99, 'product3.jpg', 20);
('Gaming Laptop', 'Gaming Laptop with amazing features', 599.99, 'product4.jpg', 50),
('Bluetooth Speaker', 'High sound quality', 199.99, 'product5.jpg', 30),
('Wireless Mouse', 'Smooth for gaming', 249.99, 'product6.jpg', 20);
```
