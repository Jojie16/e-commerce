<?php
$pageTitle = "Order Details";
require_once 'includes/header.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: my_orders.php");
    exit();
}

$order_id = intval($_GET['id']);
$customer_id = $_SESSION['user_id'];

// Verify the order belongs to the customer
$order_query = "SELECT o.* 
                FROM orders o 
                WHERE o.id = ? AND o.customer_id = ?";
$stmt = $conn->prepare($order_query);
$stmt->bind_param("ii", $order_id, $customer_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if (!$order) {
    header("Location: my_orders.php");
    exit();
}

// Get order items
$items_query = "SELECT oi.*, p.name, p.image, p.id as product_id 
                FROM order_items oi 
                JOIN products p ON oi.product_id = p.id 
                WHERE oi.order_id = ?";
$stmt = $conn->prepare($items_query);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$items = $stmt->get_result();
?>

<section class="order-details">
    <div class="order-header">
        <h1>Order #<?= str_pad($order['id'], 6, '0', STR_PAD_LEFT) ?></h1>
        <p class="order-date">Placed on <?= date('F j, Y \a\t h:i A', strtotime($order['created_at'])) ?></p>
        <div class="order-status <?= strtolower($order['status']) ?>">
            <?= ucfirst($order['status']) ?>
        </div>
    </div>
    
    <div class="order-items">
        <h2>Order Items</h2>
        <div class="items-list">
            <?php while ($item = $items->fetch_assoc()): ?>
                <div class="item-card">
                    <img src="assets/images/products/<?= htmlspecialchars($item['image']) ?>" 
                         alt="<?= htmlspecialchars($item['name']) ?>">
                    <div class="item-info">
                        <h3>
                            <a href="product_detail.php?id=<?= $item['product_id'] ?>">
                                <?= htmlspecialchars($item['name']) ?>
                            </a>
                        </h3>
                        <p class="item-price">$<?= number_format($item['price'], 2) ?></p>
                        <p class="item-quantity">Quantity: <?= $item['quantity'] ?></p>
                        <p class="item-subtotal">Subtotal: $<?= number_format($item['price'] * $item['quantity'], 2) ?></p>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
    
    <div class="order-summary">
        <h2>Order Summary</h2>
        <div class="summary-grid">
            <div class="summary-row">
                <span>Subtotal:</span>
                <span>$<?= number_format($order['total'], 2) ?></span>
            </div>
            <div class="summary-row">
                <span>Shipping:</span>
                <span>Free</span>
            </div>
            <div class="summary-row total">
                <span>Total:</span>
                <span>$<?= number_format($order['total'], 2) ?></span>
            </div>
        </div>
    </div>
    
    <div class="order-actions">
        <a href="my_orders.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Orders
        </a>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>