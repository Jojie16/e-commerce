<?php
session_start();
require_once 'config.php';
require_once 'functions.php';

if (isLoggedIn()) {
    header("Location: index.php");
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = sanitizeInput($_POST['login']);
    $password = $_POST['password'];

    // Login with email or phone
    if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
        $query = "SELECT * FROM customers WHERE email = ?";
    } else {
        $query = "SELECT * FROM customers WHERE phone = ?";
    }

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['firstname'] = $user['firstname'];
            $_SESSION['lastname'] = $user['lastname'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['is_admin'] = $user['is_admin']; // 🔑 Admin flag

            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            // Redirect based on role
            if ($user['is_admin']) {
                header("Location: admin/admin_dashboard.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No account found with that email or phone.";
    }
}
?>
