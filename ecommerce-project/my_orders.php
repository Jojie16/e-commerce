<?php
$pageTitle = "My Orders";
require_once 'includes/header.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

$customer_id = $_SESSION['user_id'];

// Fetch customer's orders
$query = "SELECT * FROM orders 
          WHERE customer_id = ? 
          ORDER BY created_at DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$orders = $stmt->get_result();
?>

<section class="my-orders">
    <h1>My Orders</h1>
    
    <?php if ($orders->num_rows === 0): ?>
        <div class="empty-orders">
            <p>You haven't placed any orders yet.</p>
            <a href="products.php" class="btn btn-primary">Browse Products</a>
        </div>
    <?php else: ?>
        <div class="orders-list">
            <?php while ($order = $orders->fetch_assoc()): ?>
                <div class="order-card">
                    <div class="order-header">
                        <div>
                            <h3>Order #<?= str_pad($order['id'], 6, '0', STR_PAD_LEFT) ?></h3>
                            <p class="order-date"><?= date('F j, Y', strtotime($order['created_at'])) ?></p>
                        </div>
                        <div class="order-status <?= strtolower($order['status']) ?>">
                            <?= ucfirst($order['status']) ?>
                        </div>
                    </div>
                    
                    <div class="order-summary">
                        <div class="summary-item">
                            <span>Total:</span>
                            <strong>$<?= number_format($order['total'], 2) ?></strong>
                        </div>
                        <div class="summary-item">
                            <span>Items:</span>
                            <?php
                            $items_query = "SELECT SUM(quantity) as total_items 
                                           FROM order_items 
                                           WHERE order_id = ?";
                            $stmt = $conn->prepare($items_query);
                            $stmt->bind_param("i", $order['id']);
                            $stmt->execute();
                            $items = $stmt->get_result()->fetch_assoc();
                            ?>
                            <strong><?= $items['total_items'] ?></strong>
                        </div>
                    </div>
                    
                    <div class="order-actions">
                        <a href="order_details.php?id=<?= $order['id'] ?>" class="btn btn-secondary">
                            View Details
                        </a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>
</section>

<?php require_once 'includes/footer.php'; ?>