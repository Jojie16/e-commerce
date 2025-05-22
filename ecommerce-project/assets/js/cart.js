document.addEventListener('DOMContentLoaded', function() {
    // Initialize cart if it doesn't exist
    if (!sessionStorage.getItem('cart')) {
        sessionStorage.setItem('cart', JSON.stringify({}));
    }
    
    // Add to cart functionality
    const addToCartForms = document.querySelectorAll('.add-to-cart-form');
    
    addToCartForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const productId = this.querySelector('[name="product_id"]').value;
            const quantity = parseInt(this.querySelector('[name="quantity"]').value) || 1;
            
            // Get current cart
            let cart = JSON.parse(sessionStorage.getItem('cart'));
            
            // Add or update product in cart
            if (cart[productId]) {
                cart[productId] += quantity;
            } else {
                cart[productId] = quantity;
            }
            
            // Save cart
            sessionStorage.setItem('cart', JSON.stringify(cart));
            
            // Update cart count in header
            updateCartCount();
            
            // Show success message
            alert('Product added to cart!');
            
            // If it's a "Buy Now" action, redirect to checkout
            if (e.submitter && e.submitter.name === 'buy_now') {
                window.location.href = 'checkout.php';
            }
        });
    });
    
    // Remove from cart functionality
    const removeFromCartForms = document.querySelectorAll('form[action*="process_cart.php"]');
    
    removeFromCartForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (this.querySelector('[name="remove_from_cart"]')) {
                e.preventDefault();
                
                const productId = this.querySelector('[name="product_id"]').value;
                
                // Get current cart
                let cart = JSON.parse(sessionStorage.getItem('cart'));
                
                // Remove product from cart
                if (cart[productId]) {
                    delete cart[productId];
                }
                
                // Save cart
                sessionStorage.setItem('cart', JSON.stringify(cart));
                
                // Update cart count in header
                updateCartCount();
                
                // Reload the page to reflect changes
                window.location.reload();
            }
        });
    });
    
    // Update cart count in header
    function updateCartCount() {
        const cart = JSON.parse(sessionStorage.getItem('cart'));
        const cartCount = Object.keys(cart).length;
        const cartCountElements = document.querySelectorAll('.cart-count');
        
        cartCountElements.forEach(element => {
            element.textContent = cartCount;
        });
    }
    
    // Initialize cart count on page load
    updateCartCount();
});