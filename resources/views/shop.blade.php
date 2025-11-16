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
            <h1 class="shop-hero-title fade-in-up">{{ __('Business & Industrial Equipment') }}</h1>
            <p class="shop-hero-subtitle fade-in-up delay-1">{{ __('Browse our extensive catalog of industrial machinery, equipment, and parts from trusted sellers') }}</p>
        </div>
        <div class="wave-divider wave-bottom"></div>
    </section>

    <!-- Shop Tabs -->
    <section class="shop-tabs-section">
        <div class="container">
            <div class="shop-tabs">
                <a href="{{ route('shop', ['locale' => currentLocale()]) }}"
                   class="shop-tab active">
                    {{ __('Business & Industrial Equipment') }}
                </a>
                <a href="{{ route('shop.motors', ['locale' => currentLocale()]) }}"
                   class="shop-tab">
                    {{ __('Motor Parts') }}
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
                    <input type="text" name="keywords" class="search-input" placeholder="{{ __('Search products...') }}" value="{{ $keywords ?? '' }}">
                </div>
                <button type="submit" class="btn btn-primary">{{ __('Search') }}</button>
            </form>
        </div>
    </section>

    <!-- Main Shop Content -->
    <section class="shop-main-section">
        <div class="container">
            @if($hasError ?? false)
                <div style="background: #fee; border: 1px solid #fcc; border-radius: 8px; padding: 1rem; margin-bottom: 2rem; color: #c33;">
                    <strong>{{ __('Error:') }}</strong> {{ $errorMessage }}
                </div>
            @endif

            @if($showSearchOnly ?? false)
                <!-- Search Only View -->
                <div style="text-align: center; padding: 4rem 2rem;">
                    <svg width="120" height="120" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin: 0 auto 2rem;">
                        <circle cx="60" cy="60" r="58" stroke="#002748" stroke-width="3" fill="#EDF3F6"/>
                        <circle cx="50" cy="50" r="25" stroke="#002748" stroke-width="4" fill="none"/>
                        <path d="M 68 68 L 85 85" stroke="#002748" stroke-width="4" stroke-linecap="round"/>
                    </svg>
                    <h2 style="color: #002748; margin-bottom: 1rem; font-size: 2rem;">{{ __('Start Your Search') }}</h2>
                    <p style="color: #003B5C; font-size: 1.125rem; margin-bottom: 2rem; max-width: 600px; margin-left: auto; margin-right: auto;">
                        {{ __('Enter keywords in the search bar above to browse thousands of industrial equipment and parts.') }}
                    </p>
                </div>
            @else
            <div class="shop-layout">
                <!-- Sidebar Filters -->
                <aside class="shop-sidebar">
                    <div class="sidebar-section">
                        <h3 class="sidebar-title">{{ __('Categories') }}</h3>
                        <ul class="category-list">
                            @if(!empty($categoryDistributions) && count($categoryDistributions) > 0)
                                @foreach($categoryDistributions as $index => $category)
                                    @if($index < 15)
                                        <li>
                                            <a href="{{ route('shop', ['locale' => currentLocale(), 'categoryId' => $category->categoryId]) }}" 
                                               class="{{ $currentCategoryId == $category->categoryId ? 'active' : '' }}">
                                                <span class="category-name">{{ $category->categoryName }}</span>
                                                @if(isset($category->matchCount))
                                                    <span class="category-count">{{ number_format($category->matchCount) }}</span>
                                                @endif
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            @else
                                <!-- Fallback static categories if API data not available -->
                                <li><a href="{{ route('shop', ['locale' => currentLocale(), 'categoryId' => '12576']) }}" class="{{ !request('categoryId') || request('categoryId') == '12576' ? 'active' : '' }}">All Business & Industrial</a></li>
                                <li><a href="{{ route('shop', ['locale' => currentLocale(), 'categoryId' => '92074']) }}" class="{{ request('categoryId') == '92074' ? 'active' : '' }}">Heavy Equipment</a></li>
                                <li><a href="{{ route('shop', ['locale' => currentLocale(), 'categoryId' => '11804']) }}" class="{{ request('categoryId') == '11804' ? 'active' : '' }}">Healthcare, Lab & Dental</a></li>
                                <li><a href="{{ route('shop', ['locale' => currentLocale(), 'categoryId' => '182969']) }}" class="{{ request('categoryId') == '182969' ? 'active' : '' }}">Restaurant & Food Service</a></li>
                                <li><a href="{{ route('shop', ['locale' => currentLocale(), 'categoryId' => '92087']) }}" class="{{ request('categoryId') == '92087' ? 'active' : '' }}">Construction</a></li>
                            @endif
                        </ul>
                    </div>

                    <div class="sidebar-section">
                        <h3 class="sidebar-title">{{ __('Sort By') }}</h3>
                        <form action="{{ route('shop', ['locale' => currentLocale()]) }}" method="GET" id="sortForm">
                            <input type="hidden" name="keywords" value="{{ $keywords ?? '' }}">
                            <input type="hidden" name="categoryId" value="{{ request('categoryId', '12576') }}">
                            <select name="sortOrder" class="sort-select" onchange="document.getElementById('sortForm').submit()">
                                <option value="BestMatch" {{ ($sortOrder ?? '') == 'BestMatch' ? 'selected' : '' }}>{{ __('Best Match') }}</option>
                                <option value="CurrentPriceLowest" {{ ($sortOrder ?? '') == 'CurrentPriceLowest' ? 'selected' : '' }}>{{ __('Price: Lowest First') }}</option>
                                <option value="CurrentPriceHighest" {{ ($sortOrder ?? '') == 'CurrentPriceHighest' ? 'selected' : '' }}>{{ __('Price: Highest First') }}</option>
                                <option value="StartTimeNewest" {{ ($sortOrder ?? '') == 'StartTimeNewest' ? 'selected' : '' }}>{{ __('Newly Listed') }}</option>
                                <option value="EndTimeSoonest" {{ ($sortOrder ?? '') == 'EndTimeSoonest' ? 'selected' : '' }}>{{ __('Ending Soon') }}</option>
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
                                    {{ number_format($total) }} {{ __('results') }}
                                    @if($keywords)
                                        {{ __('for') }} "<strong>{{ $keywords }}</strong>"
                                    @endif
                                    {{ __('in Business & Industrial') }}
                                    @if(config('app.debug') && isset($isCached))
                                        <span style="font-size: 0.75rem; color: {{ $isCached ? '#10b981' : '#f59e0b' }}; margin-left: 0.5rem;">
                                            {{ $isCached ? '(Cached)' : '(Fresh)' }}
                                        </span>
                                    @endif
                                @else
                                    {{ __('No products found') }}
                                    @if($keywords)
                                        {{ __('for') }} "{{ $keywords }}"
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
                                            {{ __('Seller:') }} {{ $item->seller->feedbackPercentage }}% {{ __('positive') }}
                                        </p>
                                    @endif

                                    @if(isset($item->itemWebUrl))
                                        <a href="{{ $item->itemWebUrl }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline btn-sm btn-block" style="margin-bottom: 0.5rem;">
                                            {{ __('View Detail') }}
                                        </a>
                                    @endif

                                    <a href="{{ route('request-quote', ['locale' => currentLocale(), 'product_url' => $item->itemWebUrl ?? '']) }}" class="btn btn-secondary btn-sm btn-block">
                                        {{ __('Request Quote') }}
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div style="grid-column: 1/-1; text-align: center; padding: 4rem 2rem;">
                                <h3 style="color: var(--gray-600); margin-bottom: 1rem;">{{ __('No products found') }}</h3>
                                <p style="color: var(--gray-500);">{{ __('Try adjusting your search keywords or browse without filters') }}</p>
                                <a href="{{ route('shop', ['locale' => currentLocale()]) }}" class="btn btn-primary" style="margin-top: 1.5rem;">{{ __('Clear Search') }}</a>
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
                                <a href="{{ route('shop', array_merge(['locale' => currentLocale()], request()->query(), ['page' => $currentPage - 1])) }}" class="btn btn-outline btn-sm">{{ __('Previous') }}</a>
                            @endif

                            @for($i = $startPage; $i <= $endPage; $i++)
                                <a href="{{ route('shop', array_merge(['locale' => currentLocale()], request()->query(), ['page' => $i])) }}"
                                   class="btn btn-sm {{ $i == $currentPage ? 'btn-primary' : 'btn-outline' }}">
                                    {{ $i }}
                                </a>
                            @endfor

                            @if($currentPage < $totalPages)
                                <a href="{{ route('shop', array_merge(['locale' => currentLocale()], request()->query(), ['page' => $currentPage + 1])) }}" class="btn btn-outline btn-sm">{{ __('Next') }}</a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        // Request quote functionality
        function requestQuote() {
            window.location.href = '{{ route('request-quote', ['locale' => currentLocale()]) }}';
        }
    </script>
@endpush
