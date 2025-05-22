<?php
require_once 'db_connection.php';

// Function to sanitize input data
function sanitizeInput($data) {
    global $conn;
    return htmlspecialchars(strip_tags(trim($conn->real_escape_string($data))));
}

// Function to redirect
function redirect($url) {
    header("Location: $url");
    exit();
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isAdminLoggedIn() {
    return isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;
}


// Function to display error messages
function displayError($error) {
    if (!empty($error)) {
        echo '<div class="alert alert-danger">' . $error . '</div>';
    }
}

// Function to display success messages
function displaySuccess($message) {
    if (!empty($message)) {
        echo '<div class="alert alert-success">' . $message . '</div>';
    }
}
?>