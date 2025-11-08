<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Shop industrial machinery, equipment and parts - ONCUBE GLOBAL">
    <title>Shop - ONCUBE GLOBAL</title>

    <!-- Design System Styles -->
    <link rel="stylesheet" href="{{ asset('css/design-system.css') }}">
    <link rel="stylesheet" href="{{ asset('css/waves.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('css/b2b-styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/shop.css') }}">
</head>
<body>
    <!-- Navigation -->
    <nav class="nav">
        <div class="container">
            <div class="nav-content">
                <a href="{{ route('home') }}" class="logo">
                    <img src="{{ asset('assets/logo.svg') }}" alt="ONCUBE GLOBAL" style="height: 50px;">
                </a>
                <ul class="nav-links">
                    <li><a href="{{ route('home') }}" data-i18n="nav_home">Home</a></li>
                    <li><a href="{{ route('shop') }}" class="active" data-i18n="nav_shop">Shop</a></li>
                    <li><a href="{{ route('about') }}" data-i18n="nav_about">About Us</a></li>
                    <li><a href="{{ route('contact') }}" data-i18n="nav_contact">Contact Us</a></li>
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
            <h1 class="shop-hero-title fade-in-up">Industrial Products from Korea</h1>
            <p class="shop-hero-subtitle fade-in-up delay-1">Browse our extensive catalog of Korean industrial machinery, equipment, and parts</p>
        </div>
        <div class="wave-divider wave-bottom"></div>
    </section>

    <!-- Search and Filter Bar -->
    <section class="shop-search-section">
        <div class="container">
            <form action="{{ route('shop') }}" method="GET" class="shop-search-bar">
                <div class="search-input-wrapper">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"/>
                        <path d="m21 21-4.35-4.35"/>
                    </svg>
                    <input type="text" name="keywords" class="search-input" placeholder="Search products..." value="{{ $keywords ?? '' }}">
                </div>
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>
    </section>

    <!-- Main Shop Content -->
    <section class="shop-main-section">
        <div class="container">
            @if($hasError ?? false)
                <div style="background: #fee; border: 1px solid #fcc; border-radius: 8px; padding: 1rem; margin-bottom: 2rem; color: #c33;">
                    <strong>Error:</strong> {{ $errorMessage }}
                </div>
            @endif

            <div class="shop-layout">
                <!-- Sidebar Filters -->
                <aside class="shop-sidebar">
                    <div class="sidebar-section">
                        <h3 class="sidebar-title">Sort By</h3>
                        <form action="{{ route('shop') }}" method="GET" id="sortForm">
                            <input type="hidden" name="keywords" value="{{ $keywords ?? '' }}">
                            <select name="sortOrder" class="sort-select" onchange="document.getElementById('sortForm').submit()">
                                <option value="BestMatch" {{ ($sortOrder ?? '') == 'BestMatch' ? 'selected' : '' }}>Best Match</option>
                                <option value="CurrentPriceLowest" {{ ($sortOrder ?? '') == 'CurrentPriceLowest' ? 'selected' : '' }}>Price: Lowest First</option>
                                <option value="CurrentPriceHighest" {{ ($sortOrder ?? '') == 'CurrentPriceHighest' ? 'selected' : '' }}>Price: Highest First</option>
                                <option value="StartTimeNewest" {{ ($sortOrder ?? '') == 'StartTimeNewest' ? 'selected' : '' }}>Newly Listed</option>
                                <option value="EndTimeSoonest" {{ ($sortOrder ?? '') == 'EndTimeSoonest' ? 'selected' : '' }}>Ending Soon</option>
                            </select>
                        </form>
                    </div>

                    <div class="sidebar-section">
                        <h3 class="sidebar-title">About Korean Products</h3>
                        <p style="font-size: 0.875rem; color: var(--gray-600); line-height: 1.5;">
                            All products are sourced from Korea (KR), featuring high-quality industrial equipment and parts from Korean sellers.
                        </p>
                    </div>
                </aside>

                <!-- Product Grid -->
                <div class="shop-content">
                    <!-- Results Header -->
                    <div class="results-header">
                        <div class="results-info">
                            <h2>
                                @if($total > 0)
                                    {{ number_format($total) }} results
                                    @if($keywords)
                                        for "<strong>{{ $keywords }}</strong>"
                                    @endif
                                    from Korea
                                @else
                                    No products found
                                    @if($keywords)
                                        for "{{ $keywords }}"
                                    @endif
                                @endif
                            </h2>
                        </div>
                    </div>

                    <!-- Product Grid -->
                    <div class="shop-products-grid" id="productsGrid">
                        @forelse($items as $item)
                            <div class="shop-product-card fade-in-up">
                                <div class="shop-product-image">
                                    @if(isset($item->image->imageUrl))
                                        <img src="{{ $item->image->imageUrl }}" alt="{{ $item->title ?? 'Product' }}" loading="lazy">
                                    @else
                                        <img src="{{ asset('product.png') }}" alt="{{ $item->title ?? 'Product' }}">
                                    @endif
                                    @if(isset($item->condition))
                                        <span class="product-badge">{{ $item->condition }}</span>
                                    @endif
                                </div>
                                <div class="shop-product-content">
                                    @if(isset($item->categories) && count($item->categories) > 0)
                                        <span class="shop-product-category">{{ $item->categories[0]->categoryName ?? 'Industrial' }}</span>
                                    @endif
                                    <h3 class="shop-product-title">{{ Str::limit($item->title ?? 'Product', 80) }}</h3>

                                    @if(isset($item->price))
                                        <p class="shop-product-price">
                                            {{ $item->price->currency ?? 'USD' }}
                                            ${{ number_format((float)($item->price->value ?? 0), 2) }}
                                        </p>
                                    @endif

                                    @if(isset($item->seller->feedbackPercentage))
                                        <p style="font-size: 0.75rem; color: var(--gray-600); margin: 0.5rem 0;">
                                            Seller: {{ $item->seller->feedbackPercentage }}% positive
                                        </p>
                                    @endif

                                    <button class="btn btn-secondary btn-sm btn-block" onclick="requestQuote({
                                        id: '{{ $item->itemId ?? '' }}',
                                        legacyId: '{{ $item->legacyItemId ?? '' }}',
                                        name: '{{ addslashes($item->title ?? 'Product') }}',
                                        price: '{{ $item->price->value ?? 0 }}',
                                        currency: '{{ $item->price->currency ?? 'USD' }}',
                                        image: '{{ $item->image->imageUrl ?? '' }}',
                                        url: '{{ $item->itemWebUrl ?? '#' }}'
                                    })">Request Quote</button>
                                </div>
                            </div>
                        @empty
                            <div style="grid-column: 1/-1; text-align: center; padding: 4rem 2rem;">
                                <h3 style="color: var(--gray-600); margin-bottom: 1rem;">No products found</h3>
                                <p style="color: var(--gray-500);">Try adjusting your search keywords or browse without filters</p>
                                <a href="{{ route('shop') }}" class="btn btn-primary" style="margin-top: 1.5rem;">Clear Search</a>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if($total > $perPage)
                        <div class="pagination-container" style="margin-top: 3rem; display: flex; justify-content: center; gap: 0.5rem;">
                            @php
                                $totalPages = ceil($total / $perPage);
                                $startPage = max(1, $currentPage - 2);
                                $endPage = min($totalPages, $currentPage + 2);
                            @endphp

                            @if($currentPage > 1)
                                <a href="{{ route('shop', array_merge(request()->query(), ['page' => $currentPage - 1])) }}" class="btn btn-outline btn-sm">Previous</a>
                            @endif

                            @for($i = $startPage; $i <= $endPage; $i++)
                                <a href="{{ route('shop', array_merge(request()->query(), ['page' => $i])) }}"
                                   class="btn btn-sm {{ $i == $currentPage ? 'btn-primary' : 'btn-outline' }}">
                                    {{ $i }}
                                </a>
                            @endfor

                            @if($currentPage < $totalPages)
                                <a href="{{ route('shop', array_merge(request()->query(), ['page' => $currentPage + 1])) }}" class="btn btn-outline btn-sm">Next</a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer wave-background-top">
        <div class="wave-divider wave-top"></div>
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3 class="footer-title">ONCUBE GLOBAL</h3>
                    <p class="footer-description">Your trusted partner in Korean industrial solutions</p>
                </div>
                <div class="footer-column">
                    <h4 class="footer-heading">Quick Links</h4>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('shop') }}">Shop</a></li>
                        <li><a href="{{ route('about') }}">About</a></li>
                        <li><a href="{{ route('contact') }}">Contact</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4 class="footer-heading">Contact Info</h4>
                    <ul class="footer-contact">
                        <li>ONCUBE GLOBAL</li>
                        <li>98, Gasan digital 2-ro, Unit 2-209</li>
                        <li>IT Castle, Geumcheon-gu</li>
                        <li>Seoul 08506, Korea</li>
                        <li>Tel. +82-10-4846-0846</li>
                        <li>E-mail: oncube2019@gmail.com</li>
                        <li>Biz License: 416-19-94501</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 ONCUBE GLOBAL. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('js/language.js') }}"></script>
    <script src="{{ asset('js/animations.js') }}"></script>
    <script>
        // Request quote functionality
        function requestQuote(product) {
            const message = `Hi, I'm interested in:\n\nProduct: ${product.name}\nPrice: ${product.currency} $${product.price}\neBay Item ID: ${product.legacyId || product.id}\n\nCould you provide a quote for international shipping to my location?`;

            // Option 1: Open contact page with pre-filled message (if you implement this)
            // window.location.href = `/contact?product=${encodeURIComponent(product.id)}`;

            // Option 2: Open eBay URL in new tab
            if (product.url && product.url !== '#') {
                window.open(product.url, '_blank');
            }

            // Option 3: Show contact modal (implement later)
            alert('Request Quote:\n\n' + message + '\n\nClick OK to be redirected to the contact page.');
            window.location.href = '{{ route('contact') }}';
        }
    </script>
</body>
</html>
