<?php
require_once 'includes/header.php';

if (!isset($_GET['id'])) {
    header("Location: products.php");
    exit();
}

$product_id = intval($_GET['id']);
$query = "SELECT * FROM products WHERE id = $product_id";
$result = $conn->query($query);

if ($result->num_rows === 0) {
    header("Location: products.php");
    exit();
}

$product = $result->fetch_assoc();
$pageTitle = $product['name'];
?>

<section class="product-detail">
    <div class="product-images">
        <img src="assets/images/products/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
    </div>
    
    <div class="product-info">
        <h1><?php echo $product['name']; ?></h1>
        <p class="price">$<?php echo number_format($product['price'], 2); ?></p>
        <p class="stock"><?php echo ($product['stock'] > 0 ? 'In Stock' : 'Out of Stock'); ?></p>
        
        <div class="product-description">
            <h3>Description</h3>
            <p><?php echo $product['description']; ?></p>
        </div>
        
        <?php if ($product['stock'] > 0): ?>
        <div class="product-actions">
            <form action="php/process_cart.php" method="POST" class="add-to-cart-form">
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                <div class="quantity-selector">
                    <label for="quantity">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" value="1" min="1" max="<?php echo $product['stock']; ?>">
                </div>
                <button type="submit" name="add_to_cart" class="btn buyNow">Add to Cart</button>
                <button type="submit" name="buy_now" class="btn btn-primary">Buy Now</button>
            </form>
        </div>
        <?php endif; ?>
    </div>
</section>

<section class="related-products">
    <h2>You May Also Like</h2>
    <div class="products-grid">
        <?php
        $query = "SELECT * FROM products WHERE id != $product_id LIMIT 3";
        $result = $conn->query($query);
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="product-card">';
                echo '<img src="assets/images/products/' . $row['image'] . '" alt="' . $row['name'] . '">';
                echo '<h3>' . $row['name'] . '</h3>';
                echo '<p class="price">$' . number_format($row['price'], 2) . '</p>';
                echo '<a href="product_detail.php?id=' . $row['id'] . '" class="btnDetails">View Details</a>';
                echo '</div>';
            }
        }
        ?>
    </div>
</section>

<?php
require_once 'includes/footer.php';
?>