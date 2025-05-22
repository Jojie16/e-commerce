<?php
session_start();
require_once 'config.php';
require_once 'functions.php';

// Initialize cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Count items in cart
$cart_count = count($_SESSION['cart']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo SITE_NAME; ?> - Your one-stop e-commerce shop">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' | ' . SITE_NAME : SITE_NAME; ?></title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- Favicon -->
    <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
    
    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- <link rel="stylesheet" href="assets/css/responsive.css"> -->
    
    <!-- JavaScript -->
    <script src="assets/js/script.js" defer></script>
</head>
<body>
    <header class="main-header">
        <div class="container">
            <div class="logo">
                <a href="index.php"><?php echo SITE_NAME; ?></a>
            </div>
            
            <nav class="main-nav">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="products.php">Products</a></li>
                    <?php if (isLoggedIn()): ?>
                        <li>
                            <a href="cart.php" class="cart-link">
                                <span class="cart-count"><?php echo $cart_count; ?></span>
                                <i class="fas fa-shopping-cart"></i>
                            </a>
                        </li>
                        <li class="dropdown">
        <a href="#" class="dropdown-toggle" id="userDropdown">
            <i class="fas fa-user-circle"></i> <?php echo htmlspecialchars($_SESSION['firstname']); ?>
            <i class="fas fa-caret-down"></i>
        </a>
        <ul class="dropdown-menu" id="dropdownMenu">
            <li><a href="account.php"><i class="fas fa-user"></i> My Account</a></li>
            <li><a href="my_orders.php"><i class="fas fa-box"></i> My Orders</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            <!-- Assume this is conditionally rendered in PHP -->
            <li class="divider"></li>
            <li><a href="admin/admin_dashboard.php"><i class="fas fa-cog"></i> Admin Panel</a></li>
        </ul>
    </li>
                    <?php else: ?>
                        <li><a href="login.php">Login</a></li>
                        <li><a href="register.php" class="btn-register">SignUp</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
            
            <div class="mobile-menu-btn">
                <i class="fas fa-bars"></i>
                <?php if ($cart_count > 0): ?>
                    <span class="mobile-cart-count"><?php echo $cart_count; ?></span>
                <?php endif; ?>
            </div>
            
            <!-- <div class="search-box">
                <form action="products.php" method="GET">
                    <input type="text" name="search" placeholder="Search products...">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div> -->
        </div>
    </header>
    
    <div class="mobile-menu">
        <div class="mobile-search">
            <form action="products.php" method="GET">
                <input type="text" name="search" placeholder="Search products...">
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
        <ul>
            <li><a href="index.php"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="products.php"><i class="fas fa-box-open"></i> Products</a></li>
            <?php if (isLoggedIn()): ?>
                <li><a href="cart.php"><i class="fas fa-shopping-cart"></i> Cart <span class="cart-count"><?php echo $cart_count; ?></span></a></li>
                <li><a href="account.php"><i class="fas fa-user"></i> My Account</a></li>
                <li><a href="orders.php"><i class="fas fa-box"></i> My Orders</a></li>
                <?php if (isAdminLoggedIn()): ?>
                    <li><a href="admin/admin_dashboard.php"><i class="fas fa-cog"></i> Admin Panel</a></li>
                <?php endif; ?>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            <?php else: ?>
                <li><a href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a></li>
                <li><a href="register.php"><i class="fas fa-user-plus"></i> Register</a></li>
            <?php endif; ?>
        </ul>
    </div>
    
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success">
            <?php echo $_SESSION['success_message']; ?>
            <?php unset($_SESSION['success_message']); ?>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger">
            <?php echo $_SESSION['error_message']; ?>
            <?php unset($_SESSION['error_message']); ?>
        </div>
    <?php endif; ?>
    
    <main class="container">
    <script src="assets/js/script.js" defer></script>
