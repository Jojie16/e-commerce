<?php
$pageTitle = "Reset Password";
require_once 'includes/header.php';

if (isLoggedIn()) {
    header("Location: index.php");
    exit();
}

$error = '';
$success = '';

if (!isset($_GET['token'])) {
    header("Location: forgot_password.php");
    exit();
}

$token = sanitizeInput($_GET['token']);

// Check if token is valid
$query = "SELECT * FROM customers WHERE reset_token = '$token' AND reset_token_expires > NOW()";
$result = $conn->query($query);

if ($result->num_rows === 0) {
    $error = "Invalid or expired token. Please request a new password reset.";
} else {
    $user = $result->fetch_assoc();
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        
        if (empty($password) || empty($confirm_password)) {
            $error = "Both password fields are required.";
        } elseif ($password !== $confirm_password) {
            $error = "Passwords do not match.";
        } elseif (strlen($password) < 8) {
            $error = "Password must be at least 8 characters long.";
        } else {
            // Update password and clear reset token
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $query = "UPDATE customers SET password = '$hashed_password', reset_token = NULL, reset_token_expires = NULL WHERE id = {$user['id']}";
            
            if ($conn->query($query)) {
                $success = "Your password has been reset successfully. You can now login with your new password.";
            } else {
                $error = "Failed to reset password. Please try again.";
            }
        }
    }
}
?>

<section class="auth-page">
    <div class="auth-container">
        <h1>Reset Password</h1>
        
        <?php displayError($error); ?>
        <?php displaySuccess($success); ?>
        
        <?php if (empty($success) && $result->num_rows === 1): ?>
        <form method="POST" action="reset_password.php?token=<?php echo $token; ?>">
            <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Confirm New Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            
            <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
        </form>
        <?php endif; ?>
        
        <div class="auth-footer">
            <p><a href="login.php">Back to login</a></p>
        </div>
    </div>
</section>

<?php
require_once 'includes/footer.php';
?>