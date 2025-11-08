/**
 * Shopping Cart System for ONCUBE GLOBAL
 */

// Cart state
let cart = JSON.parse(localStorage.getItem('cart')) || [];

// Initialize cart
document.addEventListener('DOMContentLoaded', () => {
    updateCartCount();
});

// Add item to cart
function addToCart(product) {
    const existingItem = cart.find(item => item.id === product.id);

    if (existingItem) {
        existingItem.quantity += 1;
    } else {
        cart.push({
            id: product.id,
            name: product.name,
            price: product.price,
            currency: product.currency,
            image: product.image,
            category: product.category,
            quantity: 1
        });
    }

    saveCart();
    updateCartCount();
    showNotification(t('product_add_cart') + ': ' + product.name);
}

// Remove item from cart
function removeFromCart(productId) {
    cart = cart.filter(item => item.id !== productId);
    saveCart();
    updateCartCount();
    renderCart();
}

// Update quantity
function updateQuantity(productId, quantity) {
    const item = cart.find(item => item.id === productId);
    if (item) {
        item.quantity = Math.max(1, parseInt(quantity));
        saveCart();
        renderCart();
    }
}

// Clear cart
function clearCart() {
    if (confirm('Are you sure you want to clear your cart?')) {
        cart = [];
        saveCart();
        updateCartCount();
        renderCart();
    }
}

// Save cart to localStorage
function saveCart() {
    localStorage.setItem('cart', JSON.stringify(cart));
}

// Update cart count in header
function updateCartCount() {
    const cartBadge = document.querySelector('.cart-count');
    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);

    if (cartBadge) {
        cartBadge.textContent = totalItems;
        cartBadge.style.display = totalItems > 0 ? 'flex' : 'none';
    }
}

// Render cart items
function renderCart() {
    const cartContainer = document.getElementById('cart-items');
    if (!cartContainer) return;

    if (cart.length === 0) {
        cartContainer.innerHTML = `
            <div class="cart-empty">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="9" cy="21" r="1"/>
                    <circle cx="20" cy="21" r="1"/>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                </svg>
                <p data-i18n="cart_empty">Your cart is empty</p>
                <a href="shop.html" class="btn btn-primary">${t('nav_shop')}</a>
            </div>
        `;
        return;
    }

    const cartHTML = cart.map(item => `
        <div class="cart-item" data-id="${item.id}">
            <img src="${item.image}" alt="${item.name}" class="cart-item-image">
            <div class="cart-item-details">
                <h4 class="cart-item-name">${item.name}</h4>
                <p class="cart-item-category">${item.category}</p>
                <p class="cart-item-price">${item.currency} ${item.price}</p>
            </div>
            <div class="cart-item-quantity">
                <label>${t('cart_quantity')}:</label>
                <input type="number" min="1" value="${item.quantity}"
                    onchange="updateQuantity('${item.id}', this.value)">
            </div>
            <button class="cart-item-remove btn-icon" onclick="removeFromCart('${item.id}')">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                </svg>
            </button>
        </div>
    `).join('');

    cartContainer.innerHTML = cartHTML;
}

// Request quote for cart items
function requestQuoteForCart() {
    if (cart.length === 0) {
        alert('Your cart is empty');
        return;
    }

    // Prepare product list for RFQ
    const productList = cart.map(item =>
        `${item.name} (Qty: ${item.quantity})`
    ).join('\n');

    // Redirect to RFQ page with cart items
    localStorage.setItem('rfq-products', JSON.stringify(cart));
    window.location.href = 'rfq.html?source=cart';
}

// Request quote for single product
function requestQuote(product) {
    localStorage.setItem('rfq-products', JSON.stringify([product]));
    window.location.href = 'rfq.html?source=product';
}

// Show notification
function showNotification(message) {
    const notification = document.createElement('div');
    notification.className = 'notification';
    notification.textContent = message;
    document.body.appendChild(notification);

    setTimeout(() => {
        notification.classList.add('show');
    }, 10);

    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Add notification styles
const notificationStyle = document.createElement('style');
notificationStyle.textContent = `
    .notification {
        position: fixed;
        top: 100px;
        right: 20px;
        background-color: var(--success-500);
        color: white;
        padding: var(--space-4) var(--space-6);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-xl);
        z-index: 10000;
        transform: translateX(400px);
        transition: transform var(--transition-base);
    }

    .notification.show {
        transform: translateX(0);
    }

    .cart-empty {
        text-align: center;
        padding: var(--space-20) var(--space-4);
    }

    .cart-empty svg {
        color: var(--gray-400);
        margin: 0 auto var(--space-6);
    }

    .cart-empty p {
        font-size: 1.25rem;
        color: var(--gray-600);
        margin-bottom: var(--space-8);
    }

    .cart-item {
        display: grid;
        grid-template-columns: 100px 1fr auto auto;
        gap: var(--space-4);
        align-items: center;
        padding: var(--space-6);
        background: white;
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-sm);
        margin-bottom: var(--space-4);
    }

    .cart-item-image {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: var(--radius-lg);
    }

    .cart-item-name {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--primary-900);
        margin-bottom: var(--space-2);
    }

    .cart-item-category {
        font-size: 0.875rem;
        color: var(--gray-600);
        margin-bottom: var(--space-2);
    }

    .cart-item-price {
        font-size: 1rem;
        font-weight: 700;
        color: var(--secondary-600);
        margin: 0;
    }

    .cart-item-quantity {
        display: flex;
        flex-direction: column;
        gap: var(--space-2);
    }

    .cart-item-quantity label {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--gray-700);
    }

    .cart-item-quantity input {
        width: 80px;
        padding: var(--space-2) var(--space-3);
        border: 2px solid var(--gray-300);
        border-radius: var(--radius-md);
        font-size: 1rem;
        text-align: center;
    }

    .btn-icon {
        background: transparent;
        border: none;
        color: var(--gray-600);
        cursor: pointer;
        padding: var(--space-2);
        border-radius: var(--radius-md);
        transition: all var(--transition-base);
    }

    .btn-icon:hover {
        background-color: var(--gray-100);
        color: var(--primary-900);
    }

    .cart-count {
        display: none;
        align-items: center;
        justify-content: center;
        position: absolute;
        top: -8px;
        right: -8px;
        background-color: var(--secondary-500);
        color: var(--primary-900);
        font-size: 0.75rem;
        font-weight: 700;
        width: 20px;
        height: 20px;
        border-radius: 50%;
    }

    @media (max-width: 768px) {
        .cart-item {
            grid-template-columns: 80px 1fr;
            gap: var(--space-3);
        }

        .cart-item-quantity,
        .cart-item-remove {
            grid-column: 2;
        }
    }
`;
document.head.appendChild(notificationStyle);

// Export functions
window.addToCart = addToCart;
window.removeFromCart = removeFromCart;
window.updateQuantity = updateQuantity;
window.clearCart = clearCart;
window.requestQuote = requestQuote;
window.requestQuoteForCart = requestQuoteForCart;
window.renderCart = renderCart;
