<?php
$pageTitle = "Shopping Cart";
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
}
?>

<section class="shopping-cart">
    <h1>Your Shopping Cart</h1>
    
    <?php if (empty($cart_items)): ?>
        <div class="empty-cart">
            <p>Your cart is empty.</p>
            <a href="products.php" class="btn btn-primary">Continue Shopping</a>
        </div>
    <?php else: ?>
        <div class="cart-items">
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart_items as $item): ?>
                        <tr>
                            <td class="product-info">
                                <img src="assets/images/products/<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>">
                                <div>
                                    <h3><?php echo $item['name']; ?></h3>
                                    <p><?php echo substr($item['description'], 0, 50) . '...'; ?></p>
                                </div>
                            </td>
                            <td class="price">$<?php echo number_format($item['price'], 2); ?></td>
                            <td class="quantity">
                                <form action="php/process_cart.php" method="POST" class="update-quantity-form">
                                    <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                    <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" max="<?php echo $item['stock']; ?>">
                                    <button type="submit" name="update_cart" class="btn btn-small">Update</button>
                                </form>
                            </td>
                            <td class="subtotal">$<?php echo number_format($item['subtotal'], 2); ?></td>
                            <td class="action">
                                <form action="php/process_cart.php" method="POST">
                                    <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                    <button type="submit" name="remove_from_cart" class="btn btn-small btn-danger">Remove</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div class="cart-summary">
            <div class="summary-card">
                <h3>Order Summary</h3>
                <div class="summary-row">
                    <span>Subtotal</span>
                    <span>$<?php echo number_format($total, 2); ?></span>
                </div>
                <div class="summary-row">
                    <span>Shipping</span>
                    <span>Free</span>
                </div>
                <div class="summary-row total">
                    <span>Total</span>
                    <span>$<?php echo number_format($total, 2); ?></span>
                </div>
                <a href="checkout.php" class="btn btn-primary btn-block">Proceed to Checkout</a>
                <a href="products.php" class="btn btn-secondary btn-block">Continue Shopping</a>
            </div>
        </div>
    <?php endif; ?>
</section>

<?php
require_once 'includes/footer.php';
?>