document.addEventListener('DOMContentLoaded', function() {
    const cart = [];

    // Function to add product to cart
    function addToCart(productId, productName, productPrice) {
        const existingProductIndex = cart.findIndex(product => product.id === productId);
        if (existingProductIndex !== -1) {
            cart[existingProductIndex].quantity += 1;
        } else {
            cart.push({
                id: productId,
                name: productName,
                price: productPrice,
                quantity: 1
            });
        }
        updateCartUI();
    }

    // Function to update cart UI
    function updateCartUI() {
        const cartContainer = document.getElementById('cart');
        cartContainer.innerHTML = ''; // Clear previous content
        cart.forEach(product => {
            const productElement = document.createElement('div');
            productElement.className = 'cart-item';
            productElement.innerHTML = `
                <span>${product.name} (x${product.quantity}) - $${(product.price * product.quantity).toFixed(2)}</span>
                <button data-id="${product.id}">Remove</button>
            `;
            cartContainer.appendChild(productElement);
        });
    }

    // Event listener for add to cart buttons
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.id;
            const productName = this.dataset.name;
            const productPrice = parseFloat(this.dataset.price);
            addToCart(productId, productName, productPrice);
        });
    });

    // Event listener for remove from cart buttons
    document.getElementById('cart').addEventListener('click', function(event) {
        if (event.target.tagName === 'BUTTON') {
            const productId = event.target.dataset.id;
            removeFromCart(productId);
        }
    });

    // Function to remove product from cart
    function removeFromCart(productId) {
        const productIndex = cart.findIndex(product => product.id === productId);
        if (productIndex !== -1) {
            cart.splice(productIndex, 1);
            updateCartUI();
        }
    }
});
