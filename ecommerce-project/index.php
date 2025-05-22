<?php
$pageTitle = "Home";
require_once 'includes/header.php';
?>
<section class="hero">
        <div class="container">
            <div class="hero-content">
                <h1>Welcome to Shopocalypse</h1>
                <p>Discover amazing products at unbeatable prices</p>
                <a href="products.php" class="btn">Shop Now</a>
            </div>
        </div>
    </section>

<section class="featured-products">
    <h2>Featured Products</h2>
    <div class="products-grid">
        <?php
        $query = "SELECT * FROM products LIMIT 3";
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
        } else {
            echo '<p>No featured products available.</p>';
        }
        ?>
    </div>
</section>

<section class="benefits">
        <div class="container">
            <div class="benefit-item">
                <i class="fas fa-shipping-fast"></i>
                <h3>Free Shipping</h3>
                <p>On orders over $50</p>
            </div>
            <div class="benefit-item">
                <i class="fas fa-undo"></i>
                <h3>Easy Returns</h3>
                <p>30-day return policy</p>
            </div>
            <div class="benefit-item">
                <i class="fas fa-lock"></i>
                <h3>Secure Payment</h3>
                <p>100% secure checkout</p>
            </div>
            <div class="benefit-item">
                <i class="fas fa-headset"></i>
                <h3>24/7 Support</h3>
                <p>Dedicated support</p>
            </div>
        </div>
    </section>

<?php
require_once 'includes/footer.php';
?>
    <script src="assets/js/script.js" defer></script>
