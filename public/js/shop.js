/**
 * Shop Page JavaScript
 * Handles filters, sorting, view toggle, and pagination
 */

// ==================
// Search Functionality
// ==================

document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.querySelector('.search-input');
    const searchBtn = document.querySelector('.shop-search-bar .btn-primary');

    if (searchBtn && searchInput) {
        searchBtn.addEventListener('click', performSearch);
        searchInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                performSearch();
            }
        });
    }

    function performSearch() {
        const query = searchInput.value.trim();
        if (query) {
            console.log('Searching for:', query);
            // In a real app, this would filter products or make an API call
            showNotification(`Searching for "${query}"...`);
        }
    }
});

// ==================
// Price Range Filter
// ==================

document.addEventListener('DOMContentLoaded', () => {
    const priceMinInput = document.querySelector('.price-input:first-of-type');
    const priceMaxInput = document.querySelector('.price-input:last-of-type');
    const applyPriceBtn = document.querySelector('.price-range-inputs + .btn');

    if (applyPriceBtn) {
        applyPriceBtn.addEventListener('click', () => {
            const min = priceMinInput.value;
            const max = priceMaxInput.value;

            if (min || max) {
                console.log('Filtering by price:', { min, max });
                showNotification(`Filtering products: $${min || '0'} - $${max || '∞'}`);
                // In a real app, this would filter the product grid
            }
        });
    }
});

// ==================
// Category Filter
// ==================

document.addEventListener('DOMContentLoaded', () => {
    const categoryItems = document.querySelectorAll('.category-item');

    categoryItems.forEach(item => {
        item.addEventListener('click', (e) => {
            e.preventDefault();

            // Remove active class from all categories
            categoryItems.forEach(cat => cat.classList.remove('active'));

            // Add active class to clicked category
            item.classList.add('active');

            const category = item.textContent.trim().split('(')[0].trim();
            console.log('Selected category:', category);
            showNotification(`Filtering by: ${category}`);

            // In a real app, this would filter products by category
        });
    });
});

// ==================
// Condition Checkboxes
// ==================

document.addEventListener('DOMContentLoaded', () => {
    const conditionCheckboxes = document.querySelectorAll('.sidebar-section:nth-child(3) input[type="checkbox"]');

    conditionCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            const selectedConditions = Array.from(conditionCheckboxes)
                .filter(cb => cb.checked)
                .map(cb => cb.parentElement.textContent.trim().split('(')[0].trim());

            console.log('Selected conditions:', selectedConditions);
            // In a real app, this would filter products by condition
        });
    });
});

// ==================
// Brand Filter
// ==================

document.addEventListener('DOMContentLoaded', () => {
    const brandSearch = document.querySelector('.brand-search .search-input-sm');
    const brandCheckboxes = document.querySelectorAll('.sidebar-section:last-child input[type="checkbox"]');
    const showMoreBtn = document.querySelector('.show-more-btn');

    // Brand search
    if (brandSearch) {
        brandSearch.addEventListener('input', (e) => {
            const query = e.target.value.toLowerCase();
            const labels = document.querySelectorAll('.sidebar-section:last-child .checkbox-label');

            labels.forEach(label => {
                const brandName = label.textContent.toLowerCase();
                if (brandName.includes(query)) {
                    label.style.display = 'flex';
                } else {
                    label.style.display = 'none';
                }
            });
        });
    }

    // Brand checkboxes
    brandCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            const selectedBrands = Array.from(brandCheckboxes)
                .filter(cb => cb.checked)
                .map(cb => cb.parentElement.textContent.trim().split('(')[0].trim());

            console.log('Selected brands:', selectedBrands);
            // In a real app, this would filter products by brand
        });
    });

    // Show more button
    if (showMoreBtn) {
        let expanded = false;

        showMoreBtn.addEventListener('click', () => {
            expanded = !expanded;
            showMoreBtn.textContent = expanded ? 'Show Less' : 'Show More';

            // In a real app, this would reveal more brands
            showNotification(expanded ? 'Showing all brands' : 'Showing fewer brands');
        });
    }
});

// ==================
// Sort Dropdown
// ==================

document.addEventListener('DOMContentLoaded', () => {
    const sortSelect = document.querySelector('.sort-select');

    if (sortSelect) {
        sortSelect.addEventListener('change', (e) => {
            const sortOption = e.target.value;
            console.log('Sorting by:', sortOption);
            showNotification(`Sorting by: ${sortOption}`);

            // In a real app, this would re-sort the product grid
            // For demonstration, we'll just show a notification
        });
    }
});

// ==================
// View Toggle (Grid/List)
// ==================

document.addEventListener('DOMContentLoaded', () => {
    const viewButtons = document.querySelectorAll('.view-btn');
    const productsGrid = document.querySelector('.shop-products-grid');

    viewButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            // Remove active from all buttons
            viewButtons.forEach(b => b.classList.remove('active'));

            // Add active to clicked button
            btn.classList.add('active');

            const view = btn.getAttribute('data-view');
            console.log('View changed to:', view);

            if (view === 'list') {
                // Change to list view
                productsGrid.style.gridTemplateColumns = '1fr';
                showNotification('Switched to list view');
            } else {
                // Change to grid view
                productsGrid.style.gridTemplateColumns = 'repeat(auto-fill, minmax(220px, 1fr))';
                showNotification('Switched to grid view');
            }
        });
    });
});

// ==================
// Pagination
// ==================

document.addEventListener('DOMContentLoaded', () => {
    const paginationNumbers = document.querySelectorAll('.pagination-number');
    const paginationBtns = document.querySelectorAll('.pagination-btn');
    let currentPage = 1;

    // Handle page number clicks
    paginationNumbers.forEach(btn => {
        btn.addEventListener('click', () => {
            const pageNum = parseInt(btn.textContent);

            if (!isNaN(pageNum)) {
                goToPage(pageNum);
            }
        });
    });

    // Handle prev/next buttons
    paginationBtns.forEach((btn, index) => {
        btn.addEventListener('click', () => {
            if (index === 0) {
                // Previous button
                if (currentPage > 1) {
                    goToPage(currentPage - 1);
                }
            } else {
                // Next button
                const maxPage = parseInt(document.querySelector('.pagination-number:last-of-type').textContent);
                if (currentPage < maxPage) {
                    goToPage(currentPage + 1);
                }
            }
        });
    });

    function goToPage(pageNum) {
        currentPage = pageNum;

        // Update active state
        paginationNumbers.forEach(btn => {
            if (parseInt(btn.textContent) === pageNum) {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        });

        // Enable/disable prev/next buttons
        const prevBtn = paginationBtns[0];
        const nextBtn = paginationBtns[1];
        const maxPage = parseInt(document.querySelector('.pagination-number:last-of-type').textContent);

        prevBtn.disabled = (currentPage === 1);
        nextBtn.disabled = (currentPage === maxPage);

        // Scroll to top
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });

        console.log('Navigated to page:', currentPage);
        showNotification(`Page ${currentPage}`);

        // In a real app, this would load new products via AJAX
    }
});

// ==================
// Utility: Notification System
// ==================

function showNotification(message) {
    // Check if notification container exists
    let notificationContainer = document.querySelector('.notification-container');

    if (!notificationContainer) {
        notificationContainer = document.createElement('div');
        notificationContainer.className = 'notification-container';
        notificationContainer.style.cssText = `
            position: fixed;
            top: 100px;
            right: 20px;
            z-index: 10000;
            display: flex;
            flex-direction: column;
            gap: 10px;
        `;
        document.body.appendChild(notificationContainer);
    }

    const notification = document.createElement('div');
    notification.className = 'notification';
    notification.textContent = message;
    notification.style.cssText = `
        background-color: var(--primary-900);
        color: var(--white);
        padding: var(--space-4) var(--space-6);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-xl);
        animation: slideIn 0.3s ease-out;
        min-width: 250px;
        font-weight: 600;
    `;

    notificationContainer.appendChild(notification);

    // Auto remove after 3 seconds
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease-out';
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
}

// Add animation styles
const notificationStyles = document.createElement('style');
notificationStyles.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(400px);
            opacity: 0;
        }
    }
`;
document.head.appendChild(notificationStyles);
