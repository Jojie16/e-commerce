<?php
$pageTitle = "Admin Dashboard";
require_once 'admin_header.php';
?>

<div class="dashboard-grid">
    <div class="dashboard-card">
        <div class="card-header">
            <h3>Total Customers</h3>
            <i class="fas fa-users"></i>
        </div>
        <div class="card-body">
            <?php
            $query = "SELECT COUNT(*) as total FROM customers";
            $result = $conn->query($query);
            $total_customers = $result->fetch_assoc()['total'];
            ?>
            <h2><?php echo $total_customers; ?></h2>
            <p>Registered customers</p>
        </div>
        <div class="card-footer">
            <a href="manage_customers.php">View All</a>
        </div>
    </div>
    
    <div class="dashboard-card">
        <div class="card-header">
            <h3>Total Orders</h3>
            <i class="fas fa-shopping-cart"></i>
        </div>
        <div class="card-body">
            <?php
            $query = "SELECT COUNT(*) as total FROM orders";
            $result = $conn->query($query);
            $total_orders = $result->fetch_assoc()['total'];
            ?>
            <h2><?php echo $total_orders; ?></h2>
            <p>Completed orders</p>
        </div>
        <div class="card-footer">
            <a href="#">View All</a>
        </div>
    </div>
    
    <div class="dashboard-card">
        <div class="card-header">
            <h3>Total Revenue</h3>
            <i class="fas fa-dollar-sign"></i>
        </div>
        <div class="card-body">
            <?php
            $query = "SELECT SUM(total) as total FROM orders WHERE status = 'completed'";
            $result = $conn->query($query);
            $total_revenue = $result->fetch_assoc()['total'] ?? 0;
            ?>
            <h2>$<?php echo number_format($total_revenue, 2); ?></h2>
            <p>Total earnings</p>
        </div>
        <div class="card-footer">
            <a href="#">View Reports</a>
        </div>
    </div>
</div>

<div class="recent-orders">
    <h2>Recent Orders</h2>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Date</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT o.id, o.created_at, o.total, o.status, c.firstname, c.lastname 
                      FROM orders o 
                      JOIN customers c ON o.customer_id = c.id 
                      ORDER BY o.created_at DESC 
                      LIMIT 5";
            $result = $conn->query($query);
            
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>#' . str_pad($row['id'], 6, '0', STR_PAD_LEFT) . '</td>';
                    echo '<td>' . $row['firstname'] . ' ' . $row['lastname'] . '</td>';
                    echo '<td>' . date('M j, Y', strtotime($row['created_at'])) . '</td>';
                    echo '<td>$' . number_format($row['total'], 2) . '</td>';
                    echo '<td><span class="status ' . $row['status'] . '">' . ucfirst($row['status']) . '</span></td>';
                    echo '<td><a href="#" class="btn btn-small">View</a></td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="6">No recent orders found.</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>

<?php
require_once '../includes/footer.php';
?>