<?php
session_start();
require_once '../includes/config.php';
require_once '../includes/functions.php';

if (!isAdminLoggedIn()) {
    header("Location: ../login.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' | ' . SITE_NAME . ' Admin' : SITE_NAME . ' Admin'; ?></title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/responsive.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <aside class="admin-sidebar">
            <div class="admin-logo">
                <a href="admin_dashboard.php">ShopEasy Admin</a>
            </div>
            
            <nav class="admin-nav">
                <ul>
                    <li>
                        <a href="admin_dashboard.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'admin_dashboard.php' ? 'active' : ''; ?>">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="manage_customers.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'manage_customers.php' ? 'active' : ''; ?>">
                            <i class="fas fa-users"></i> Customers
                        </a>
                    </li>
                    <li>
                        <a href="../products.php" target="_blank">
                            <i class="fas fa-box-open"></i> View Products
                        </a>
                    </li>
                    <li>
                        <a href="../logout.php">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>
        
        <main class="admin-content">
            <header class="admin-header">
                <div class="header-left">
                    <button class="sidebar-toggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1><?php echo isset($pageTitle) ? $pageTitle : 'Dashboard'; ?></h1>
                </div>
                <div class="header-right">
                    <div class="admin-profile">
                        <span>Welcome, Admin</span>
                    </div>
                </div>
            </header>
            
            <div class="admin-main-content">