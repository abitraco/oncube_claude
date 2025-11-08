<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Shop industrial machinery, equipment and parts - ONCUBE GLOBAL">
    <title>Shop - ONCUBE GLOBAL</title>

    <!-- Design System Styles -->
    <link rel="stylesheet" href="css/design-system.css">
    <link rel="stylesheet" href="css/waves.css">
    <link rel="stylesheet" href="css/components.css">
    <link rel="stylesheet" href="css/b2b-styles.css">
    <link rel="stylesheet" href="css/shop.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="nav">
        <div class="container">
            <div class="nav-content">
                <a href="home.html" class="logo">
                    <img src="assets/logo.svg" alt="ONCUBE GLOBAL" style="height: 50px;">
                </a>
                <ul class="nav-links">
                    <li><a href="home.html" data-i18n="nav_home">Home</a></li>
                    <li><a href="shop.html" class="active" data-i18n="nav_shop">Shop</a></li>
                    <li><a href="about.html" data-i18n="nav_about">About Us</a></li>
                    <li><a href="contact.html" data-i18n="nav_contact">Contact Us</a></li>
                    <li class="language-selector">
                        <button class="lang-btn lang-selector active" data-lang="en" onclick="changeLanguage('en')">EN</button>
                        <button class="lang-btn lang-selector" data-lang="ko" onclick="changeLanguage('ko')">한</button>
                        <button class="lang-btn lang-selector" data-lang="ja" onclick="changeLanguage('ja')">日</button>
                        <button class="lang-btn lang-selector" data-lang="zh" onclick="changeLanguage('zh')">中</button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Shop Hero with Wave -->
    <section class="shop-hero wave-background-top">
        <div class="container">
            <h1 class="shop-hero-title fade-in-up">Industrial Products</h1>
            <p class="shop-hero-subtitle fade-in-up delay-1">Browse our extensive catalog of industrial machinery, equipment, and parts</p>
        </div>
        <div class="wave-divider wave-bottom"></div>
    </section>

    <!-- Search and Filter Bar -->
    <section class="shop-search-section">
        <div class="container">
            <div class="shop-search-bar">
                <div class="search-input-wrapper">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"/>
                        <path d="m21 21-4.35-4.35"/>
                    </svg>
                    <input type="text" class="search-input" placeholder="Search products...">
                </div>
                <button class="btn btn-primary">Search</button>
            </div>
        </div>
    </section>

    <!-- Main Shop Content -->
    <section class="shop-main-section">
        <div class="container">
            <div class="shop-layout">
                <!-- Sidebar Filters -->
                <aside class="shop-sidebar">
                    <div class="sidebar-section">
                        <h3 class="sidebar-title">Categories</h3>
                        <ul class="category-list">
                            <li><a href="?category=heavy-equipment" class="category-item">Heavy Equipment <span class="count">(245)</span></a></li>
                            <li><a href="?category=healthcare" class="category-item">Healthcare, Lab & Dental <span class="count">(189)</span></a></li>
                            <li><a href="?category=cnc" class="category-item active">CNC & Manufacturing <span class="count">(412)</span></a></li>
                            <li><a href="?category=food-service" class="category-item">Food Service <span class="count">(156)</span></a></li>
                            <li><a href="?category=agriculture" class="category-item">Agriculture & Forestry <span class="count">(298)</span></a></li>
                            <li><a href="?category=parts" class="category-item">Heavy Equipment Parts <span class="count">(1,024)</span></a></li>
                            <li><a href="?category=office" class="category-item">Office Equipment <span class="count">(87)</span></a></li>
                            <li><a href="?category=hvac" class="category-item">HVAC & Refrigeration <span class="count">(234)</span></a></li>
                            <li><a href="?category=measurement" class="category-item">Measurement & Inspection <span class="count">(167)</span></a></li>
                            <li><a href="?category=facility" class="category-item">Facility Maintenance <span class="count">(203)</span></a></li>
                        </ul>
                    </div>

                    <div class="sidebar-section">
                        <h3 class="sidebar-title">Price Range</h3>
                        <div class="price-range-inputs">
                            <input type="number" class="price-input" placeholder="Min">
                            <span>-</span>
                            <input type="number" class="price-input" placeholder="Max">
                        </div>
                        <button class="btn btn-outline btn-sm" style="width: 100%; margin-top: var(--space-3);">Apply</button>
                    </div>

                    <div class="sidebar-section">
                        <h3 class="sidebar-title">Condition</h3>
                        <label class="checkbox-label">
                            <input type="checkbox" checked> New <span class="count">(892)</span>
                        </label>
                        <label class="checkbox-label">
                            <input type="checkbox"> Used <span class="count">(1,245)</span>
                        </label>
                        <label class="checkbox-label">
                            <input type="checkbox"> Refurbished <span class="count">(156)</span>
                        </label>
                    </div>

                    <div class="sidebar-section">
                        <h3 class="sidebar-title">Brand</h3>
                        <div class="brand-search">
                            <input type="text" class="search-input-sm" placeholder="Search brands...">
                        </div>
                        <label class="checkbox-label">
                            <input type="checkbox"> Caterpillar <span class="count">(45)</span>
                        </label>
                        <label class="checkbox-label">
                            <input type="checkbox"> John Deere <span class="count">(38)</span>
                        </label>
                        <label class="checkbox-label">
                            <input type="checkbox"> Siemens <span class="count">(67)</span>
                        </label>
                        <label class="checkbox-label">
                            <input type="checkbox"> Bosch <span class="count">(52)</span>
                        </label>
                        <button class="show-more-btn">Show More</button>
                    </div>
                </aside>

                <!-- Product Grid -->
                <div class="shop-content">
                    <!-- Results Header -->
                    <div class="results-header">
                        <div class="results-info">
                            <h2>2,293 results in <strong>CNC & Manufacturing</strong></h2>
                        </div>
                        <div class="results-controls">
                            <label class="sort-label">Sort by:</label>
                            <select class="sort-select">
                                <option>Best Match</option>
                                <option>Price: Lowest First</option>
                                <option>Price: Highest First</option>
                                <option>Newly Listed</option>
                                <option>Ending Soon</option>
                            </select>
                            <div class="view-toggle">
                                <button class="view-btn active" data-view="grid">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                        <rect x="3" y="3" width="7" height="7"/>
                                        <rect x="14" y="3" width="7" height="7"/>
                                        <rect x="3" y="14" width="7" height="7"/>
                                        <rect x="14" y="14" width="7" height="7"/>
                                    </svg>
                                </button>
                                <button class="view-btn" data-view="list">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                        <rect x="3" y="5" width="18" height="3"/>
                                        <rect x="3" y="11" width="18" height="3"/>
                                        <rect x="3" y="17" width="18" height="3"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Product Grid -->
                    <div class="shop-products-grid" id="productsGrid">
                        <!-- Repeat this product card structure -->
                        <div class="shop-product-card fade-in-up">
                            <div class="shop-product-image">
                                <img src="product.png" alt="Product">
                                <span class="product-badge">New</span>
                            </div>
                            <div class="shop-product-content">
                                <span class="shop-product-category">Parts & Components</span>
                                <h3 class="shop-product-title">Starter For Ford 7.3 7.3L PowerStroke Pickup Truck Higher Torque</h3>
                                <p class="shop-product-price">USD $289.99</p>
                                <button class="btn btn-secondary btn-sm btn-block" onclick="requestQuote({id: 'sp1', name: 'Product', price: '289.99', currency: 'USD', image: 'product.png', category: 'Parts'})">Request Quote</button>
                            </div>
                        </div>

                        <div class="shop-product-card fade-in-up delay-1">
                            <div class="shop-product-image">
                                <img src="product.png" alt="Product">
                            </div>
                            <div class="shop-product-content">
                                <span class="shop-product-category">Parts & Components</span>
                                <h3 class="shop-product-title">Starter For Ford 7.3 7.3L PowerStroke Pickup Truck Higher Torque</h3>
                                <p class="shop-product-price">USD $289.99</p>
                                <button class="btn btn-secondary btn-sm btn-block" onclick="requestQuote({id: 'sp2', name: 'Starter For Ford 7.3 7.3L PowerStroke Pickup Truck Higher Torque', price: '289.99', currency: 'USD', image: 'product.png', category: 'Parts & Components'})">Request Quote</button>
                            </div>
                        </div>

                        <div class="shop-product-card fade-in-up delay-2">
                            <div class="shop-product-image">
                                <img src="product.png" alt="Product">
                            </div>
                            <div class="shop-product-content">
                                <span class="shop-product-category">Parts & Components</span>
                                <h3 class="shop-product-title">Starter For Ford 7.3 7.3L PowerStroke Pickup Truck Higher Torque</h3>
                                <p class="shop-product-price">USD $289.99</p>
                                <button class="btn btn-secondary btn-sm btn-block" onclick="requestQuote({id: 'sp3', name: 'Starter For Ford 7.3 7.3L PowerStroke Pickup Truck Higher Torque', price: '289.99', currency: 'USD', image: 'product.png', category: 'Parts & Components'})">Request Quote</button>
                            </div>
                        </div>

                        <div class="shop-product-card fade-in-up">
                            <div class="shop-product-image">
                                <img src="product.png" alt="Product">
                                <span class="product-badge">New</span>
                            </div>
                            <div class="shop-product-content">
                                <span class="shop-product-category">Parts & Components</span>
                                <h3 class="shop-product-title">Starter For Ford 7.3 7.3L PowerStroke Pickup Truck Higher Torque</h3>
                                <p class="shop-product-price">USD $289.99</p>
                                <button class="btn btn-secondary btn-sm btn-block" onclick="requestQuote({id: 'sp4', name: 'Starter For Ford 7.3 7.3L PowerStroke Pickup Truck Higher Torque', price: '289.99', currency: 'USD', image: 'product.png', category: 'Parts & Components'})">Request Quote</button>
                            </div>
                        </div>

                        <div class="shop-product-card fade-in-up delay-1">
                            <div class="shop-product-image">
                                <img src="product.png" alt="Product">
                            </div>
                            <div class="shop-product-content">
                                <span class="shop-product-category">Parts & Components</span>
                                <h3 class="shop-product-title">Starter For Ford 7.3 7.3L PowerStroke Pickup Truck Higher Torque</h3>
                                <p class="shop-product-price">USD $289.99</p>
                                <button class="btn btn-secondary btn-sm btn-block" onclick="requestQuote({id: 'sp5', name: 'Starter For Ford 7.3 7.3L PowerStroke Pickup Truck Higher Torque', price: '289.99', currency: 'USD', image: 'product.png', category: 'Parts & Components'})">Request Quote</button>
                            </div>
                        </div>

                        <div class="shop-product-card fade-in-up delay-2">
                            <div class="shop-product-image">
                                <img src="product.png" alt="Product">
                            </div>
                            <div class="shop-product-content">
                                <span class="shop-product-category">Parts & Components</span>
                                <h3 class="shop-product-title">Starter For Ford 7.3 7.3L PowerStroke Pickup Truck Higher Torque</h3>
                                <p class="shop-product-price">USD $289.99</p>
                                <button class="btn btn-secondary btn-sm btn-block" onclick="requestQuote({id: 'sp6', name: 'Starter For Ford 7.3 7.3L PowerStroke Pickup Truck Higher Torque', price: '289.99', currency: 'USD', image: 'product.png', category: 'Parts & Components'})">Request Quote</button>
                            </div>
                        </div>

                        <div class="shop-product-card fade-in-up">
                            <div class="shop-product-image">
                                <img src="product.png" alt="Product">
                            </div>
                            <div class="shop-product-content">
                                <span class="shop-product-category">Parts & Components</span>
                                <h3 class="shop-product-title">Starter For Ford 7.3 7.3L PowerStroke Pickup Truck Higher Torque</h3>
                                <p class="shop-product-price">USD $289.99</p>
                                <button class="btn btn-secondary btn-sm btn-block" onclick="requestQuote({id: 'sp7', name: 'Starter For Ford 7.3 7.3L PowerStroke Pickup Truck Higher Torque', price: '289.99', currency: 'USD', image: 'product.png', category: 'Parts & Components'})">Request Quote</button>
                            </div>
                        </div>

                        <div class="shop-product-card fade-in-up delay-1">
                            <div class="shop-product-image">
                                <img src="product.png" alt="Product">
                                <span class="product-badge">New</span>
                            </div>
                            <div class="shop-product-content">
                                <span class="shop-product-category">Parts & Components</span>
                                <h3 class="shop-product-title">Starter For Ford 7.3 7.3L PowerStroke Pickup Truck Higher Torque</h3>
                                <p class="shop-product-price">USD $289.99</p>
                                <button class="btn btn-secondary btn-sm btn-block" onclick="requestQuote({id: 'sp8', name: 'Starter For Ford 7.3 7.3L PowerStroke Pickup Truck Higher Torque', price: '289.99', currency: 'USD', image: 'product.png', category: 'Parts & Components'})">Request Quote</button>
                            </div>
                        </div>

                        <div class="shop-product-card fade-in-up delay-2">
                            <div class="shop-product-image">
                                <img src="product.png" alt="Product">
                            </div>
                            <div class="shop-product-content">
                                <span class="shop-product-category">Parts & Components</span>
                                <h3 class="shop-product-title">Starter For Ford 7.3 7.3L PowerStroke Pickup Truck Higher Torque</h3>
                                <p class="shop-product-price">USD $289.99</p>
                                <button class="btn btn-secondary btn-sm btn-block" onclick="requestQuote({id: 'sp9', name: 'Starter For Ford 7.3 7.3L PowerStroke Pickup Truck Higher Torque', price: '289.99', currency: 'USD', image: 'product.png', category: 'Parts & Components'})">Request Quote</button>
                            </div>
                        </div>

                        <div class="shop-product-card fade-in-up">
                            <div class="shop-product-image">
                                <img src="product.png" alt="Product">
                            </div>
                            <div class="shop-product-content">
                                <span class="shop-product-category">Parts & Components</span>
                                <h3 class="shop-product-title">Starter For Ford 7.3 7.3L PowerStroke Pickup Truck Higher Torque</h3>
                                <p class="shop-product-price">USD $289.99</p>
                                <button class="btn btn-secondary btn-sm btn-block" onclick="requestQuote({id: 'sp10', name: 'Starter For Ford 7.3 7.3L PowerStroke Pickup Truck Higher Torque', price: '289.99', currency: 'USD', image: 'product.png', category: 'Parts & Components'})">Request Quote</button>
                            </div>
                        </div>

                        <div class="shop-product-card fade-in-up delay-1">
                            <div class="shop-product-image">
                                <img src="product.png" alt="Product">
                            </div>
                            <div class="shop-product-content">
                                <span class="shop-product-category">Parts & Components</span>
                                <h3 class="shop-product-title">Starter For Ford 7.3 7.3L PowerStroke Pickup Truck Higher Torque</h3>
                                <p class="shop-product-price">USD $289.99</p>
                                <button class="btn btn-secondary btn-sm btn-block" onclick="requestQuote({id: 'sp11', name: 'Starter For Ford 7.3 7.3L PowerStroke Pickup Truck Higher Torque', price: '289.99', currency: 'USD', image: 'product.png', category: 'Parts & Components'})">Request Quote</button>
                            </div>
                        </div>

                        <div class="shop-product-card fade-in-up delay-2">
                            <div class="shop-product-image">
                                <img src="product.png" alt="Product">
                                <span class="product-badge">New</span>
                            </div>
                            <div class="shop-product-content">
                                <span class="shop-product-category">Parts & Components</span>
                                <h3 class="shop-product-title">Starter For Ford 7.3 7.3L PowerStroke Pickup Truck Higher Torque</h3>
                                <p class="shop-product-price">USD $289.99</p>
                                <button class="btn btn-secondary btn-sm btn-block" onclick="requestQuote({id: 'sp12', name: 'Starter For Ford 7.3 7.3L PowerStroke Pickup Truck Higher Torque', price: '289.99', currency: 'USD', image: 'product.png', category: 'Parts & Components'})">Request Quote</button>
                            </div>
                        </div>

                        <div class="shop-product-card fade-in-up">
                            <div class="shop-product-image">
                                <img src="product.png" alt="Product">
                            </div>
                            <div class="shop-product-content">
                                <span class="shop-product-category">Parts & Components</span>
                                <h3 class="shop-product-title">Starter For Ford 7.3 7.3L PowerStroke Pickup Truck Higher Torque</h3>
                                <p class="shop-product-price">USD $289.99</p>
                                <button class="btn btn-secondary btn-sm btn-block" onclick="requestQuote({id: 'sp13', name: 'Starter For Ford 7.3 7.3L PowerStroke Pickup Truck Higher Torque', price: '289.99', currency: 'USD', image: 'product.png', category: 'Parts & Components'})">Request Quote</button>
                            </div>
                        </div>

                        <div class="shop-product-card fade-in-up delay-1">
                            <div class="shop-product-image">
                                <img src="product.png" alt="Product">
                            </div>
                            <div class="shop-product-content">
                                <span class="shop-product-category">Parts & Components</span>
                                <h3 class="shop-product-title">Starter For Ford 7.3 7.3L PowerStroke Pickup Truck Higher Torque</h3>
                                <p class="shop-product-price">USD $289.99</p>
                                <button class="btn btn-secondary btn-sm btn-block" onclick="requestQuote({id: 'sp14', name: 'Starter For Ford 7.3 7.3L PowerStroke Pickup Truck Higher Torque', price: '289.99', currency: 'USD', image: 'product.png', category: 'Parts & Components'})">Request Quote</button>
                            </div>
                        </div>

                        <div class="shop-product-card fade-in-up delay-2">
                            <div class="shop-product-image">
                                <img src="product.png" alt="Product">
                            </div>
                            <div class="shop-product-content">
                                <span class="shop-product-category">Parts & Components</span>
                                <h3 class="shop-product-title">Starter For Ford 7.3 7.3L PowerStroke Pickup Truck Higher Torque</h3>
                                <p class="shop-product-price">USD $289.99</p>
                                <button class="btn btn-secondary btn-sm btn-block" onclick="requestQuote({id: 'sp15', name: 'Starter For Ford 7.3 7.3L PowerStroke Pickup Truck Higher Torque', price: '289.99', currency: 'USD', image: 'product.png', category: 'Parts & Components'})">Request Quote</button>
                            </div>
                        </div>

                        <div class="shop-product-card fade-in-up">
                            <div class="shop-product-image">
                                <img src="product.png" alt="Product">
                            </div>
                            <div class="shop-product-content">
                                <span class="shop-product-category">Parts & Components</span>
                                <h3 class="shop-product-title">Starter For Ford 7.3 7.3L PowerStroke Pickup Truck Higher Torque</h3>
                                <p class="shop-product-price">USD $289.99</p>
                                <button class="btn btn-secondary btn-sm btn-block" onclick="requestQuote({id: 'sp16', name: 'Starter For Ford 7.3 7.3L PowerStroke Pickup Truck Higher Torque', price: '289.99', currency: 'USD', image: 'product.png', category: 'Parts & Components'})">Request Quote</button>
                            </div>
                        </div>

                        <div class="shop-product-card fade-in-up delay-1">
                            <div class="shop-product-image">
                                <img src="product.png" alt="Product">
                                <span class="product-badge">New</span>
                            </div>
                            <div class="shop-product-content">
                                <span class="shop-product-category">Parts & Components</span>
                                <h3 class="shop-product-title">Starter For Ford 7.3 7.3L PowerStroke Pickup Truck Higher Torque</h3>
                                <p class="shop-product-price">USD $289.99</p>
                                <button class="btn btn-secondary btn-sm btn-block" onclick="requestQuote({id: 'sp17', name: 'Starter For Ford 7.3 7.3L PowerStroke Pickup Truck Higher Torque', price: '289.99', currency: 'USD', image: 'product.png', category: 'Parts & Components'})">Request Quote</button>
                            </div>
                        </div>

                        <div class="shop-product-card fade-in-up delay-2">
                            <div class="shop-product-image">
                                <img src="product.png" alt="Product">
                            </div>
                            <div class="shop-product-content">
                                <span class="shop-product-category">Parts & Components</span>
                                <h3 class="shop-product-title">Starter For Ford 7.3 7.3L PowerStroke Pickup Truck Higher Torque</h3>
                                <p class="shop-product-price">USD $289.99</p>
                                <button class="btn btn-secondary btn-sm btn-block" onclick="requestQuote({id: 'sp18', name: 'Starter For Ford 7.3 7.3L PowerStroke Pickup Truck Higher Torque', price: '289.99', currency: 'USD', image: 'product.png', category: 'Parts & Components'})">Request Quote</button>
                            </div>
                        </div>

                        <div class="shop-product-card fade-in-up">
                            <div class="shop-product-image">
                                <img src="product.png" alt="Product">
                            </div>
                            <div class="shop-product-content">
                                <span class="shop-product-category">Parts & Components</span>
                                <h3 class="shop-product-title">Starter For Ford 7.3 7.3L PowerStroke Pickup Truck Higher Torque</h3>
                                <p class="shop-product-price">USD $289.99</p>
                                <button class="btn btn-secondary btn-sm btn-block" onclick="requestQuote({id: 'sp19', name: 'Starter For Ford 7.3 7.3L PowerStroke Pickup Truck Higher Torque', price: '289.99', currency: 'USD', image: 'product.png', category: 'Parts & Components'})">Request Quote</button>
                            </div>
                        </div>

                        <div class="shop-product-card fade-in-up delay-1">
                            <div class="shop-product-image">
                                <img src="product.png" alt="Product">
                            </div>
                            <div class="shop-product-content">
                                <span class="shop-product-category">Parts & Components</span>
                                <h3 class="shop-product-title">Starter For Ford 7.3 7.3L PowerStroke Pickup Truck Higher Torque</h3>
                                <p class="shop-product-price">USD $289.99</p>
                                <button class="btn btn-secondary btn-sm btn-block" onclick="requestQuote({id: 'sp20', name: 'Starter For Ford 7.3 7.3L PowerStroke Pickup Truck Higher Torque', price: '289.99', currency: 'USD', image: 'product.png', category: 'Parts & Components'})">Request Quote</button>
                            </div>
                        </div>

                        <div class="shop-product-card fade-in-up delay-2">
                            <div class="shop-product-image">
                                <img src="product.png" alt="Product">
                            </div>
                            <div class="shop-product-content">
                                <span class="shop-product-category">Parts & Components</span>
                                <h3 class="shop-product-title">Starter For Ford 7.3 7.3L PowerStroke Pickup Truck Higher Torque</h3>
                                <p class="shop-product-price">USD $289.99</p>
                                <button class="btn btn-secondary btn-sm btn-block" onclick="requestQuote({id: 'sp21', name: 'Starter For Ford 7.3 7.3L PowerStroke Pickup Truck Higher Torque', price: '289.99', currency: 'USD', image: 'product.png', category: 'Parts & Components'})">Request Quote</button>
                            </div>
                        </div>

                        <div class="shop-product-card fade-in-up">
                            <div class="shop-product-image">
                                <img src="product.png" alt="Product">
                                <span class="product-badge">New</span>
                            </div>
                            <div class="shop-product-content">
                                <span class="shop-product-category">Parts & Components</span>
                                <h3 class="shop-product-title">Starter For Ford 7.3 7.3L PowerStroke Pickup Truck Higher Torque</h3>
                                <p class="shop-product-price">USD $289.99</p>
                                <button class="btn btn-secondary btn-sm btn-block" onclick="requestQuote({id: 'sp22', name: 'Starter For Ford 7.3 7.3L PowerStroke Pickup Truck Higher Torque', price: '289.99', currency: 'USD', image: 'product.png', category: 'Parts & Components'})">Request Quote</button>
                            </div>
                        </div>

                        <div class="shop-product-card fade-in-up delay-1">
                            <div class="shop-product-image">
                                <img src="product.png" alt="Product">
                            </div>
                            <div class="shop-product-content">
                                <span class="shop-product-category">Parts & Components</span>
                                <h3 class="shop-product-title">Starter For Ford 7.3 7.3L PowerStroke Pickup Truck Higher Torque</h3>
                                <p class="shop-product-price">USD $289.99</p>
                                <button class="btn btn-secondary btn-sm btn-block" onclick="requestQuote({id: 'sp23', name: 'Starter For Ford 7.3 7.3L PowerStroke Pickup Truck Higher Torque', price: '289.99', currency: 'USD', image: 'product.png', category: 'Parts & Components'})">Request Quote</button>
                            </div>
                        </div>

                        <div class="shop-product-card fade-in-up delay-2">
                            <div class="shop-product-image">
                                <img src="product.png" alt="Product">
                            </div>
                            <div class="shop-product-content">
                                <span class="shop-product-category">Parts & Components</span>
                                <h3 class="shop-product-title">Starter For Ford 7.3 7.3L PowerStroke Pickup Truck Higher Torque</h3>
                                <p class="shop-product-price">USD $289.99</p>
                                <button class="btn btn-secondary btn-sm btn-block" onclick="requestQuote({id: 'sp24', name: 'Starter For Ford 7.3 7.3L PowerStroke Pickup Truck Higher Torque', price: '289.99', currency: 'USD', image: 'product.png', category: 'Parts & Components'})">Request Quote</button>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="pagination">
                        <button class="pagination-btn" disabled>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M15 18l-6-6 6-6"/>
                            </svg>
                        </button>
                        <button class="pagination-number active">1</button>
                        <button class="pagination-number">2</button>
                        <button class="pagination-number">3</button>
                        <button class="pagination-number">4</button>
                        <button class="pagination-number">5</button>
                        <span class="pagination-dots">...</span>
                        <button class="pagination-number">96</button>
                        <button class="pagination-btn">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 18l6-6-6-6"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content-grid">
                <div class="footer-column">
                    <img src="assets/logo.svg" alt="ONCUBE GLOBAL" style="height: 50px; margin-bottom: var(--space-4);">
                    <p>Your trusted partner for industrial machinery, equipment & parts worldwide.</p>
                </div>

                <div class="footer-column">
                    <h4 data-i18n="footer_quick_links">Quick Links</h4>
                    <ul class="footer-links">
                        <li><a href="home.html" data-i18n="nav_home">Home</a></li>
                        <li><a href="shop.html" data-i18n="nav_shop">Shop</a></li>
                        <li><a href="about.html" data-i18n="nav_about">About Us</a></li>
                        <li><a href="contact.html" data-i18n="nav_contact">Contact Us</a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h4 data-i18n="footer_contact_info">Contact Information</h4>
                    <ul class="footer-contact">
                        <li>98, Gasan digital 2-ro, Unit 2-209, IT Castle</li>
                        <li>Geumcheon-gu, Seoul 08506, Korea</li>
                        <li>Tel: +82-10-4846-0846</li>
                        <li>Fax: +82-504-476-0846</li>
                        <li>Email: oncube2019@gmail.com</li>
                        <li>Biz License: 416-19-94501</li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <p data-i18n="footer_copyright">&copy; 2025 ONCUBE GLOBAL. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="js/language.js"></script>
    <script src="js/cart.js"></script>
    <script src="js/animations.js"></script>
    <script src="js/shop.js"></script>
</body>
</html>
