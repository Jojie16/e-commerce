<?php
if (!defined('FOOTER_INCLUDED')) {
    define('FOOTER_INCLUDED', true);
?>
        </main>

        <!-- ========== FOOTER START ========== -->
        <footer class="main-footer">
            <div class="container">
                <div class="footer-content">
                    <!-- About Section -->
                    <div class="footer-section about">
                        <h3>About Shopocalypse</h3>
                        <p>Your one-stop shop for all your needs. We provide quality products at affordable prices with excellent customer service.</p>
                        <div class="social-icons">
                            <a href="#"><i class="fab fa-facebook"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="footer-section links">
                        <h3>Quick Links</h3>
                        <ul>
                            <li><a href="">Home</a></li>
                            <li><a href="products.php">Products</a></li>
                            <li><a href="cart.php">Cart</a></li>
                            <li><a href="login.php">Login</a></li>
                            <li><a href="register.php">Register</a></li>
                        </ul>
                    </div>

                    <!-- Contact Info -->
                    <div class="footer-section contact">
                        <h3>Contact Us</h3>
                        <p><i class="fas fa-map-marker-alt"></i> 123 Ave Street, Cebu, Philippines</p>
                        <p><i class="fas fa-phone"></i> +63 123 456 789</p>
                        <p><i class="fas fa-envelope"></i> info@shopocalypse.com</p>
                    </div>
                </div>

                <div class="footer-bottom">
                    <p>&copy; <?php echo date('Y'); ?> Shopocalypse. All Rights Reserved.</p>
                </div>
            </div>
        </footer>
        <!-- ========== FOOTER END ========== -->

        <!-- JavaScript Files -->
        <script src="/assets/js/script.js"></script>
        <script src="/assets/js/cart.js"></script>
    </body>
</html>
<?php } ?>
