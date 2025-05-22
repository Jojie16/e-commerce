<?php
$pageTitle = "Products";
require_once 'includes/header.php';
?>

<section class="products-page">
    <br><h1>Our Products</h1>
    
    <div class="filter-section">
        <form method="GET" action="products.php">
            <div class="filter-group">
                <label for="sort">Sort by:</label>
                <select name="sort" id="sort">
                    <option value="price_asc">Price: Low to High</option>
                    <option value="price_desc">Price: High to Low</option>
                    <option value="name_asc">Name: A to Z</option>
                    <option value="name_desc">Name: Z to A</option>
                </select>
            </div>
            <button type="submit" class="btn filterBtn">Apply</button>
        </form>
    </div>
    
    <div class="products-grid">
        <?php
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'name_asc';
        $order_by = '';
        
        switch ($sort) {
            case 'price_asc':
                $order_by = 'price ASC';
                break;
            case 'price_desc':
                $order_by = 'price DESC';
                break;
            case 'name_asc':
                $order_by = 'name ASC';
                break;
            case 'name_desc':
                $order_by = 'name DESC';
                break;
            default:
                $order_by = 'name ASC';
        }
        
        $query = "SELECT * FROM products ORDER BY $order_by";
        $result = $conn->query($query);
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="product-card">';
                echo '<img src="assets/images/products/' . $row['image'] . '" alt="' . $row['name'] . '">';
                echo '<h3>' . $row['name'] . '</h3>';
                echo '<p class="price">$' . number_format($row['price'], 2) . '</p>';
                echo '<p class="stock">' . ($row['stock'] > 0 ? 'In Stock' : 'Out of Stock') . '</p>';
                echo '<div class="product-actions">';
                echo '<a href="product_detail.php?id=' . $row['id'] . '" class="btnDetails">View Details</a>';
                
                if ($row['stock'] > 0) {
                    echo '<form action="php/process_cart.php" method="POST" class="add-to-cart-form">';
                    echo '<input type="hidden" name="product_id" value="' . $row['id'] . '">';
                    echo '<input type="number" name="quantity" value="1" min="1" max="' . $row['stock'] . '">';
                    echo '<button type="submit" name="add_to_cart" class="btn btn-primary">Add to Cart</button>';
                    echo '</form>';
                }
                
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<p>No products available.</p>';
        }
        ?>
    </div>
</section>

<?php
require_once 'includes/footer.php';
?>