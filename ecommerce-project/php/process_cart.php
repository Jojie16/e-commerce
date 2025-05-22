<?php
session_start();
require_once '../includes/db_connection.php';
require_once '../includes/functions.php';

if (!isLoggedIn()) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = intval($_POST['product_id']);
    
    if (isset($_POST['add_to_cart'])) {
        $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
        
        // Initialize cart if it doesn't exist
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        
        // Add or update product in cart
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] += $quantity;
        } else {
            $_SESSION['cart'][$product_id] = $quantity;
        }
        
        // If it's a "Buy Now" action, redirect to checkout
        if (isset($_POST['buy_now'])) {
            header("Location: ../checkout.php");
            exit();
        } else {
            header("Location: ../cart.php");
            exit();
        }
    } elseif (isset($_POST['update_cart'])) {
        $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
        
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] = $quantity;
        }
        
        header("Location: ../cart.php");
        exit();
    } elseif (isset($_POST['remove_from_cart'])) {
        if (isset($_SESSION['cart'][$product_id])) {
            unset($_SESSION['cart'][$product_id]);
        }
        
        header("Location: ../cart.php");
        exit();
    }
}

header("Location: ../index.php");
exit();
?>