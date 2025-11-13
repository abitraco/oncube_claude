@extends('layouts.app')

@section('title', 'Shop - ONCUBE GLOBAL')
@section('meta_description', 'Shop industrial machinery, equipment and parts - ONCUBE GLOBAL')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/shop.css') }}?v={{ time() }}">
@endpush

@section('content')
    <!-- Shop Hero with Wave -->
    <section class="shop-hero wave-background-top">
        <div class="container">
            <h1 class="shop-hero-title fade-in-up">Business & Industrial Equipment</h1>
            <p class="shop-hero-subtitle fade-in-up delay-1">Browse our extensive catalog of industrial machinery, equipment, and parts from trusted sellers</p>
        </div>
        <div class="wave-divider wave-bottom"></div>
    </section>

    <!-- Shop Tabs -->
    <section class="shop-tabs-section">
        <div class="container">
            <div class="shop-tabs">
                <a href="{{ route('shop', ['locale' => currentLocale()]) }}"
                   class="shop-tab active">
                    Business & Industrial Equipment
                </a>
                <a href="{{ route('shop.motors', ['locale' => currentLocale()]) }}"
                   class="shop-tab">
                    Motor Parts
                </a>
            </div>
        </div>
    </section>

    <!-- Search and Filter Bar -->
    <section class="shop-search-section">
        <div class="container">
            <form action="{{ route('shop', ['locale' => currentLocale()]) }}" method="GET" class="shop-search-bar">
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
                        <h3 class="sidebar-title">Categories</h3>
                        <ul class="category-list">
                            <li><a href="{{ route('shop', ['locale' => currentLocale(), 'categoryId' => '12576']) }}" class="{{ !request('categoryId') || request('categoryId') == '12576' ? 'active' : '' }}">All Business & Industrial</a></li>
                            <li><a href="{{ route('shop', ['locale' => currentLocale(), 'categoryId' => '92074']) }}" class="{{ request('categoryId') == '92074' ? 'active' : '' }}">Heavy Equipment</a></li>
                            <li><a href="{{ route('shop', ['locale' => currentLocale(), 'categoryId' => '11804']) }}" class="{{ request('categoryId') == '11804' ? 'active' : '' }}">Healthcare, Lab & Dental</a></li>
                            <li><a href="{{ route('shop', ['locale' => currentLocale(), 'categoryId' => '12576']) }}" class="{{ request('categoryId') == '12576' && request('keywords') == 'CNC' ? 'active' : '' }}">CNC & Metalworking</a></li>
                            <li><a href="{{ route('shop', ['locale' => currentLocale(), 'categoryId' => '182969']) }}" class="{{ request('categoryId') == '182969' ? 'active' : '' }}">Restaurant & Food Service</a></li>
                            <li><a href="{{ route('shop', ['locale' => currentLocale(), 'categoryId' => '92087']) }}" class="{{ request('categoryId') == '92087' ? 'active' : '' }}">Construction</a></li>
                            <li><a href="{{ route('shop', ['locale' => currentLocale(), 'categoryId' => '26242']) }}" class="{{ request('categoryId') == '26242' ? 'active' : '' }}">Office Equipment</a></li>
                            <li><a href="{{ route('shop', ['locale' => currentLocale(), 'categoryId' => '92085']) }}" class="{{ request('categoryId') == '92085' ? 'active' : '' }}">Farming & Agriculture</a></li>
                            <li><a href="{{ route('shop', ['locale' => currentLocale(), 'categoryId' => '11875']) }}" class="{{ request('categoryId') == '11875' ? 'active' : '' }}">Printing & Graphic Arts</a></li>
                            <li><a href="{{ route('shop', ['locale' => currentLocale(), 'categoryId' => '26238']) }}" class="{{ request('categoryId') == '26238' ? 'active' : '' }}">Electrical Equipment</a></li>
                            <li><a href="{{ route('shop', ['locale' => currentLocale(), 'categoryId' => '11804']) }}" class="{{ request('categoryId') == '11804' ? 'active' : '' }}">Material Handling</a></li>
                            <li><a href="{{ route('shop', ['locale' => currentLocale(), 'categoryId' => '260328']) }}" class="{{ request('categoryId') == '260328' ? 'active' : '' }}">HVAC & Refrigeration</a></li>
                        </ul>
                    </div>

                    <div class="sidebar-section">
                        <h3 class="sidebar-title">Sort By</h3>
                        <form action="{{ route('shop', ['locale' => currentLocale()]) }}" method="GET" id="sortForm">
                            <input type="hidden" name="keywords" value="{{ $keywords ?? '' }}">
                            <input type="hidden" name="categoryId" value="{{ request('categoryId', '12576') }}">
                            <select name="sortOrder" class="sort-select" onchange="document.getElementById('sortForm').submit()">
                                <option value="BestMatch" {{ ($sortOrder ?? '') == 'BestMatch' ? 'selected' : '' }}>Best Match</option>
                                <option value="CurrentPriceLowest" {{ ($sortOrder ?? '') == 'CurrentPriceLowest' ? 'selected' : '' }}>Price: Lowest First</option>
                                <option value="CurrentPriceHighest" {{ ($sortOrder ?? '') == 'CurrentPriceHighest' ? 'selected' : '' }}>Price: Highest First</option>
                                <option value="StartTimeNewest" {{ ($sortOrder ?? '') == 'StartTimeNewest' ? 'selected' : '' }}>Newly Listed</option>
                                <option value="EndTimeSoonest" {{ ($sortOrder ?? '') == 'EndTimeSoonest' ? 'selected' : '' }}>Ending Soon</option>
                            </select>
                        </form>
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
                                    in Business & Industrial
                                    @if(config('app.debug') && isset($isCached))
                                        <span style="font-size: 0.75rem; color: {{ $isCached ? '#10b981' : '#f59e0b' }}; margin-left: 0.5rem;">
                                            {{ $isCached ? '(Cached)' : '(Fresh)' }}
                                        </span>
                                    @endif
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
                                <a href="{{ route('shop', ['locale' => currentLocale()]) }}" class="btn btn-primary" style="margin-top: 1.5rem;">Clear Search</a>
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
                                <a href="{{ route('shop', array_merge(['locale' => currentLocale()], request()->query(), ['page' => $currentPage - 1])) }}" class="btn btn-outline btn-sm">Previous</a>
                            @endif

                            @for($i = $startPage; $i <= $endPage; $i++)
                                <a href="{{ route('shop', array_merge(['locale' => currentLocale()], request()->query(), ['page' => $i])) }}"
                                   class="btn btn-sm {{ $i == $currentPage ? 'btn-primary' : 'btn-outline' }}">
                                    {{ $i }}
                                </a>
                            @endfor

                            @if($currentPage < $totalPages)
                                <a href="{{ route('shop', array_merge(['locale' => currentLocale()], request()->query(), ['page' => $currentPage + 1])) }}" class="btn btn-outline btn-sm">Next</a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Request Quote Section -->
    <section id="request-quote" class="request-quote-section wave-background-full">
        <div class="wave-divider wave-top"></div>
        <div class="container">
            <div class="request-quote-content">
                <div class="request-quote-text fade-in-up">
                    <h2 class="section-title">Request a Quote</h2>
                    <p class="section-subtitle">
                        Need a custom quote for bulk orders or specific equipment? Our team is here to help.
                    </p>
                    <ul class="request-quote-benefits">
                        <li>✓ Competitive wholesale pricing</li>
                        <li>✓ Volume discounts available</li>
                        <li>✓ International shipping quotes</li>
                        <li>✓ Custom procurement services</li>
                    </ul>
                </div>
                <div class="request-quote-form-wrapper fade-in-up delay-1">
                    @include('partials.request-quote-form')
                </div>
            </div>
        </div>
        <div class="wave-divider wave-bottom"></div>
    </section>
@endsection

@push('scripts')
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
            window.location.href = '{{ route('contact', ['locale' => currentLocale()]) }}';
        }
    </script>
@endpush
