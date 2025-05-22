<?php
$pageTitle = "Manage Customers";
require_once 'admin_header.php';

// Handle delete customer
if (isset($_GET['delete'])) {
    $customer_id = intval($_GET['delete']);
    $query = "DELETE FROM customers WHERE id = $customer_id";
    
    if ($conn->query($query)) {
        $_SESSION['success_message'] = "Customer deleted successfully.";
    } else {
        $_SESSION['error_message'] = "Failed to delete customer.";
    }
    
    header("Location: manage_customers.php");
    exit();
}

// Search functionality
$search = isset($_GET['search']) ? sanitizeInput($_GET['search']) : '';
$where = '';

if (!empty($search)) {
    $where = "WHERE firstname LIKE '%$search%' OR lastname LIKE '%$search%' OR email LIKE '%$search%' OR phone LIKE '%$search%'";
}

// Get all customers
$query = "SELECT * FROM customers $where ORDER BY created_at DESC";
$result = $conn->query($query);
?>

<div class="manage-customers">
    <div class="section-header">
        <h2>Manage Customers</h2>
        
        <div class="search-box">
            <form method="GET" action="manage_customers.php">
                <input type="text" name="search" placeholder="Search customers..." value="<?php echo $search; ?>">
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </div>
    
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success"><?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?></div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger"><?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?></div>
    <?php endif; ?>
    
    <div class="customers-table">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Registered</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['firstname'] . ' ' . $row['lastname']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['phone']; ?></td>
                            <td><?php echo date('M j, Y', strtotime($row['created_at'])); ?></td>
                            <td class="actions">
                                <a href="edit_customer.php?id=<?php echo $row['id']; ?>" class="btn btn-small btn-edit"><i class="fas fa-edit"></i></a>
                                <a href="manage_customers.php?delete=<?php echo $row['id']; ?>" class="btn btn-small btn-delete" onclick="return confirm('Are you sure you want to delete this customer?');"><i class="fas fa-trash"></i></a>
                                <a href="view_customer.php?id=<?php echo $row['id']; ?>" class="btn btn-small btn-view"><i class="fas fa-eye"></i></a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">No customers found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
require_once '../includes/footer.php';
?>