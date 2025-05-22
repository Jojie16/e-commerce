<?php
$pageTitle = "Register";
require_once 'includes/header.php';

if (isLoggedIn()) {
    header("Location: index.php");
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
    } elseif (!preg_match('/^[0-9]{10,15}$/', $phone)) {
        $error = "Phone number should be 10-15 digits.";
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
                header("Location: index.php");
                exit();
            } else {
                $error = "Registration failed. Please try again.";
            }
        }
    }
}
?>

<section class="auth-page">
    <div class="auth-container">
        <h1>Create an Account</h1>
        
        <?php displayError($error); ?>
        
        <form method="POST" action="register.php">
            <div class="form-group">
                <label for="firstname">First Name</label>
                <input type="text" id="firstname" name="firstname" 
                       value="<?php echo isset($_POST['firstname']) ? htmlspecialchars($_POST['firstname']) : ''; ?>" 
                       required>
            </div>
            
            <div class="form-group">
                <label for="lastname">Last Name</label>
                <input type="text" id="lastname" name="lastname" 
                       value="<?php echo isset($_POST['lastname']) ? htmlspecialchars($_POST['lastname']) : ''; ?>" 
                       required>
            </div>
            
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" 
                       value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" 
                       required>
            </div>
            
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" 
                       value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>" 
                       pattern="[0-9]{10,15}" 
                       title="10-15 digit phone number" 
                       required>
                <small>Format: 10-15 digits (no spaces or special characters)</small>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" 
                       minlength="8" required>
                <small>Minimum 8 characters</small>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" 
                       minlength="8" required>
            </div>
            
            <div class="form-group terms">
                <input type="checkbox" id="terms" name="terms" required>
                <label for="terms">I agree to the <a href="#" target="_blank">Terms of Service</a> and <a href="#" target="_blank">Privacy Policy</a></label>
            </div>
            
            <button type="submit" class="btn btn-primary btn-block">Register</button>
        </form>
        
        <div class="auth-footer">
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </div>
</section>

<?php
require_once 'includes/footer.php';
?>