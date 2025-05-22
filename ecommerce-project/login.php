<?php
$pageTitle = "Login";
require_once 'includes/header.php';

if (isLoggedIn()) {
    header("Location: index.php");
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = sanitizeInput($_POST['login']);
    $password = $_POST['password'];
    
    // Check if login is email or phone
    if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
        $query = "SELECT * FROM customers WHERE email = '$login'";
    } else {
        $query = "SELECT * FROM customers WHERE phone = '$login'";
    }
    
    $result = $conn->query($query);
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['firstname'] = $user['firstname'];
            $_SESSION['lastname'] = $user['lastname'];
            $_SESSION['email'] = $user['email'];
            
            // Check if cart exists in session, if not initialize it
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }
            
            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No account found with that email/phone.";
    }
}
?>

<section class="auth-page">
    <div class="auth-container">
        <h1>Login to Your Account</h1>
        
        <?php displayError($error); ?>
        
        <form method="POST" action="login.php">
            <div class="form-group">
                <label for="login">Email or Phone Number</label>
                <input type="text" id="login" name="login" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <div class="form-group remember-forgot">
                <div class="remember-me">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Remember&nbsp;me</label>
                </div>
                <div class="forgot-password">
                    <a href="forgot_password.php">Forgot password?</a>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>
        
        <div class="auth-footer">
            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </div>
    </div>
</section>

<?php
require_once 'includes/footer.php';
?>