<?php
$pageTitle = "Order Confirmation";
require_once 'includes/header.php';

if (!isLoggedIn() || !isset($_SESSION['order_id'])) {
    header("Location: index.php");
    exit();
}

$order_id = $_SESSION['order_id'];
unset($_SESSION['order_id']);

// Get order details
$query = "SELECT o.*, c.firstname, c.lastname, c.email, c.phone 
          FROM orders o 
          JOIN customers c ON o.customer_id = c.id 
          WHERE o.id = $order_id AND o.customer_id = {$_SESSION['user_id']}";
$result = $conn->query($query);

if ($result->num_rows === 0) {
    header("Location: index.php");
    exit();
}

$order = $result->fetch_assoc();

// Get order items
$query = "SELECT oi.*, p.name, p.image 
          FROM order_items oi 
          JOIN products p ON oi.product_id = p.id 
          WHERE oi.order_id = $order_id";
$items_result = $conn->query($query);
$items = [];
$total = 0;

while ($row = $items_result->fetch_assoc()) {
    $items[] = $row;
    $total += $row['price'] * $row['quantity'];
}
?>

<section class="order-confirmation">
    <div class="confirmation-container">
        <div class="confirmation-header">
            <i class="fas fa-check-circle"></i>
            <h1>Thank You for Your Order!</h1>
            <p>Your order has been placed successfully. Here are your order details:</p>
        </div>
        
        <div class="order-details">
            <div class="order-info">
                <h2>Order Information</h2>
                <p><strong>Order Number:</strong> #<?php echo str_pad($order['id'], 6, '0', STR_PAD_LEFT); ?></p>
                <p><strong>Order Date:</strong> <?php echo date('F j, Y', strtotime($order['created_at'])); ?></p>
                <p><strong>Order Status:</strong> <?php echo ucfirst($order['status']); ?></p>
                <p><strong>Total Amount:</strong> $<?php echo number_format($order['total'], 2); ?></p>
            </div>
            
            <div class="customer-info">
                <h2>Customer Information</h2>
                <p><strong>Name:</strong> <?php echo $order['firstname'] . ' ' . $order['lastname']; ?></p>
                <p><strong>Email:</strong> <?php echo $order['email']; ?></p>
                <p><strong>Phone:</strong> <?php echo $order['phone']; ?></p>
            </div>
        </div>
        
        <div class="order-items">
            <h2>Order Items</h2>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td class="product-info">
                                <img src="assets/images/products/<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>">
                                <div>
                                    <h3><?php echo $item['name']; ?></h3>
                                </div>
                            </td>
                            <td class="price">$<?php echo number_format($item['price'], 2); ?></td>
                            <td class="quantity"><?php echo $item['quantity']; ?></td>
                            <td class="subtotal">$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="total-label">Total</td>
                        <td class="total">$<?php echo number_format($total, 2); ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        <div class="confirmation-actions">
            <a href="products.php" class="btn btn-secondary">Continue Shopping</a>
            <a href="index.php" class="btn btn-primary">Back to Home</a>
        </div>
    </div>
</section>

<?php
require_once 'includes/footer.php';
?>