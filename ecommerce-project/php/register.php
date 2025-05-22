<?php
require_once '../includes/header.php';
require_once '../includes/functions.php';
require_once '../includes/db_connection.php';

if (isLoggedIn()) {
    header("Location: ../index.php");
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = sanitizeInput($_POST['firstname']);
    $lastname = sanitizeInput($_POST['lastname']);
    $email = sanitizeInput($_POST['email']);
    $phone = sanitizeInput($_POST['phone']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validate inputs
    if (empty($firstname) || empty($lastname) || empty($email) || empty($phone) || empty($password)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } elseif (strlen($password) < 8) {
        $error = "Password must be at least 8 characters long.";
    } else {
        // Check if email or phone already exists
        $query = "SELECT * FROM customers WHERE email = '$email' OR phone = '$phone'";
        $result = $conn->query($query);
        
        if ($result->num_rows > 0) {
            $error = "Email or phone number already registered.";
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert new customer
            $query = "INSERT INTO customers (firstname, lastname, email, phone, password) 
                      VALUES ('$firstname', '$lastname', '$email', '$phone', '$hashed_password')";
            
            if ($conn->query($query)) {
                // Get the new customer ID
                $customer_id = $conn->insert_id;
                
                // Log in the user
                $_SESSION['user_id'] = $customer_id;
                $_SESSION['firstname'] = $firstname;
                $_SESSION['lastname'] = $lastname;
                $_SESSION['email'] = $email;
                
                // Initialize cart
                $_SESSION['cart'] = [];
                
                // Redirect to home page
                header("Location: ../index.php");
                exit();
            } else {
                $error = "Registration failed. Please try again.";
            }
        }
    }
}

require_once '../includes/footer.php';
?>