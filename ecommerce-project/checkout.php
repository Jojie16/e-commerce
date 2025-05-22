<?php
$pageTitle = "Checkout";
require_once 'includes/header.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

$customer_id = $_SESSION['user_id'];
$cart_items = [];
$total = 0;

// Check if cart exists in session
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        $query = "SELECT * FROM products WHERE id = $product_id";
        $result = $conn->query($query);
        
        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
            $product['quantity'] = $quantity;
            $product['subtotal'] = $product['price'] * $quantity;
            $cart_items[] = $product;
            $total += $product['subtotal'];
        }
    }
} else {
    header("Location: cart.php");
    exit();
}

// Get customer details
$query = "SELECT * FROM customers WHERE id = $customer_id";
$result = $conn->query($query);
$customer = $result->fetch_assoc();

// Process checkout
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Create order
    $query = "INSERT INTO orders (customer_id, total) VALUES ($customer_id, $total)";
    if ($conn->query($query)) {
        $order_id = $conn->insert_id;
        
        // Add order items
        foreach ($cart_items as $item) {
            $product_id = $item['id'];
            $quantity = $item['quantity'];
            $price = $item['price'];
            
            $query = "INSERT INTO order_items (order_id, product_id, quantity, price) 
                      VALUES ($order_id, $product_id, $quantity, $price)";
            $conn->query($query);
            
            // Update product stock
            $query = "UPDATE products SET stock = stock - $quantity WHERE id = $product_id";
            $conn->query($query);
        }
        
        // Clear cart
        unset($_SESSION['cart']);
        
        // Redirect to thank you page
        $_SESSION['order_id'] = $order_id;
        header("Location: order_confirmation.php");
        exit();
    } else {
        $error = "There was an error processing your order. Please try again.";
    }
}
?>

<section class="checkout-page">
    <h1>Checkout</h1>
    
    <div class="checkout-container">
        <div class="checkout-form">
            <h2>Shipping Information</h2>
            <form method="POST" action="checkout.php">
                <div class="form-group">
                    <label for="firstname">First Name</label>
                    <input type="text" id="firstname" name="firstname" value="<?php echo $customer['firstname']; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="lastname">Last Name</label>
                    <input type="text" id="lastname" name="lastname" value="<?php echo $customer['lastname']; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo $customer['email']; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" value="<?php echo $customer['phone']; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="address">Shipping Address</label>
                    <textarea id="address" name="address" rows="3" required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="payment">Payment Method</label>
                    <select id="payment" name="payment" required>
                        <option value="credit_card">Credit Card</option>
                        <option value="g-cash">G-Cash</option>
                        <option value="paymaya">PayMaya</option>
                        <option value="paypal">PayPal</option>
                        <option value="bank_transfer">Bank Transfer</option>
                    </select>
                </div>
                
                <button type="submit" class="btn btn-primary btn-block">Place Order</button>
            </form>
        </div>
        
        <div class="order-summary">
            <h2>Your Order</h2>
            <div class="order-items">
                <?php foreach ($cart_items as $item): ?>
                    <div class="order-item">
                        <div class="item-info">
                            <h4><?php echo $item['name']; ?></h4>
                            <p>Qty: <?php echo $item['quantity']; ?></p>
                        </div>
                        <div class="item-price">
                            $<?php echo number_format($item['subtotal'], 2); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="order-total">
                <div class="total-row">
                    <span>Subtotal</span>
                    <span>$<?php echo number_format($total, 2); ?></span>
                </div>
                <div class="total-row">
                    <span>Shipping</span>
                    <span>Free</span>
                </div>
                <div class="total-row grand-total">
                    <span>Total</span>
                    <span>$<?php echo number_format($total, 2); ?></span>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
require_once 'includes/footer.php';
?>