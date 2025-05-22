<?php
$pageTitle = "Forgot Password";
require_once 'includes/header.php';

if (isLoggedIn()) {
    header("Location: index.php");
    exit();
}

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitizeInput($_POST['email']);
    
    if (empty($email)) {
        $error = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        // Check if email exists
        $query = "SELECT * FROM customers WHERE email = '$email'";
        $result = $conn->query($query);
        
        if ($result->num_rows === 1) {
            // Generate reset token (in a real app, you would send an email with this token)
            $reset_token = bin2hex(random_bytes(32));
            $expires_at = date('Y-m-d H:i:s', strtotime('+1 hour'));
            
            // Store token in database (in a real app, you would have a password_resets table)
            $user = $result->fetch_assoc();
            $query = "UPDATE customers SET reset_token = '$reset_token', reset_token_expires = '$expires_at' WHERE email = '$email'";
            $conn->query($query);
            
            $message = "Password reset instructions have been sent to your email.";
        } else {
            $error = "No account found with that email.";
        }
    }
}
?>

<section class="auth-page">
    <div class="auth-container">
        <h1>Forgot Password</h1>
        
        <?php displayError($error); ?>
        <?php displaySuccess($message); ?>
        
        <form method="POST" action="forgot_password.php">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
        </form>
        
        <div class="auth-footer">
            <p>Remember your password? <a href="login.php">Login here</a></p>
        </div>
    </div>
</section>

<?php
require_once 'includes/footer.php';
?>