@extends('layouts.app')

@section('title', 'ONCUBE GLOBAL - Industrial Machinery & Equipment')
@section('meta_description', 'ONCUBE GLOBAL - Your trusted partner for industrial machinery, equipment and parts worldwide')

@section('content')
    <!-- Hero Section with Wavy Background -->
    <section id="hero" class="hero-section wave-background-top">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title fade-in-up" data-i18n="hero_title">Global Industrial Solutions</h1>
                <p class="hero-subtitle fade-in-up delay-1" data-i18n="hero_subtitle">Your Trusted Partner for Industrial Machinery, Equipment & Parts</p>
                <div class="hero-buttons fade-in-up delay-2">
                    <a href="{{ route('shop', ['locale' => currentLocale()]) }}" class="btn btn-primary" data-i18n="hero_cta_primary">Browse Products</a>
                    <a href="{{ route('request-quote', ['locale' => currentLocale()]) }}" class="btn btn-secondary" data-i18n="hero_cta_secondary">Request Quote</a>
                </div>
            </div>
        </div>
        <div class="wave-divider wave-bottom"></div>
    </section>

    <!-- Features Section with Wavy Background -->
    <section id="features" class="features-section wave-background-full">
        <div class="wave-divider wave-top"></div>
        <div class="container">
            <h2 class="section-title fade-in-up" data-i18n="features_title">Why Choose ONCUBE GLOBAL</h2>
            <div class="features-grid">
                <div class="feature-card fade-in-up">
                    <div class="feature-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <path d="M2 12h20"/>
                            <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                        </svg>
                    </div>
                    <h3 class="feature-title" data-i18n="feature1_title">Global Sourcing</h3>
                    <p class="feature-text" data-i18n="feature1_desc">Access to worldwide industrial products from trusted suppliers</p>
                </div>

                <div class="feature-card fade-in-up delay-1">
                    <div class="feature-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                        </svg>
                    </div>
                    <h3 class="feature-title" data-i18n="feature2_title">Competitive Pricing</h3>
                    <p class="feature-text" data-i18n="feature2_desc">Direct pricing from manufacturers with transparent quotation system</p>
                </div>

                <div class="feature-card fade-in-up delay-2">
                    <div class="feature-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                    </div>
                    <h3 class="feature-title" data-i18n="feature3_title">Expert Support</h3>
                    <p class="feature-text" data-i18n="feature3_desc">Dedicated B2B team to handle all your industrial procurement needs</p>
                </div>
            </div>
        </div>
        <div class="wave-divider wave-bottom"></div>
    </section>

    <!-- Shop by Category Section -->
    <section id="shop-by-category" class="shop-by-category-section wave-background-full">
        <div class="container">
            <h2 class="section-title fade-in-up">Shop by category</h2>

            <!-- Row 1 -->
            <div class="category-showcase-grid">
                <a href="{{ route('shop', ['locale' => currentLocale(), 'categoryId' => '92074']) }}" class="category-showcase-card fade-in-up">
                    <div class="category-showcase-image">
                        <svg width="120" height="120" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <!-- Excavator -->
                            <rect x="20" y="70" width="40" height="20" rx="3" fill="#FFB800"/>
                            <rect x="15" y="85" width="10" height="8" rx="2" fill="#333"/>
                            <rect x="50" y="85" width="10" height="8" rx="2" fill="#333"/>
                            <path d="M60 75 L75 60 L85 65 L70 80 Z" fill="#FF6B00"/>
                            <rect x="75" y="55" width="8" height="15" rx="2" fill="#666"/>
                            <circle cx="40" cy="50" r="8" fill="#FFEC2D"/>
                            <path d="M40 45 L85 20 L90 25 L45 50 Z" fill="#333" stroke="#FFEC2D" stroke-width="2"/>
                            <rect x="85" y="15" width="15" height="12" rx="2" fill="#666"/>
                        </svg>
                    </div>
                    <h3 class="category-showcase-title">Heavy equipment</h3>
                </a>

                <a href="{{ route('shop', ['locale' => currentLocale(), 'categoryId' => '11804']) }}" class="category-showcase-card fade-in-up delay-1">
                    <div class="category-showcase-image">
                        <svg width="120" height="120" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <!-- Microscope -->
                            <rect x="35" y="85" width="50" height="6" rx="2" fill="#002748"/>
                            <rect x="50" y="70" width="20" height="15" rx="2" fill="#003B5C"/>
                            <circle cx="60" cy="55" r="8" fill="#FFEC2D"/>
                            <rect x="56" y="30" width="8" height="25" fill="#002748"/>
                            <circle cx="60" cy="25" r="6" fill="#003B5C"/>
                            <path d="M45 55 L40 70 L50 70 Z" fill="#003B5C"/>
                            <rect x="65" y="40" width="3" height="20" fill="#666"/>
                            <circle cx="66.5" cy="38" r="4" fill="#FFEC2D"/>
                        </svg>
                    </div>
                    <h3 class="category-showcase-title">Healthcare, lab and dental</h3>
                </a>

                <a href="{{ route('shop', ['locale' => currentLocale(), 'categoryId' => '12576']) }}" class="category-showcase-card fade-in-up delay-2">
                    <div class="category-showcase-image">
                        <svg width="120" height="120" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <!-- CNC Machine -->
                            <rect x="25" y="30" width="70" height="55" rx="4" fill="#002748" stroke="#FFEC2D" stroke-width="2"/>
                            <rect x="35" y="40" width="20" height="25" rx="2" fill="#FFEC2D"/>
                            <rect x="65" y="40" width="20" height="25" rx="2" fill="#003B5C"/>
                            <circle cx="45" cy="52" r="3" fill="#002748"/>
                            <circle cx="75" cy="52" r="3" fill="#FFEC2D"/>
                            <rect x="35" y="70" width="50" height="4" fill="#FFEC2D"/>
                            <rect x="55" y="45" width="3" height="15" fill="#FF6B00"/>
                            <polygon points="56.5,42 53,47 60,47" fill="#FF6B00"/>
                        </svg>
                    </div>
                    <h3 class="category-showcase-title">CNC and manufacturing</h3>
                </a>

                <a href="{{ route('shop', ['locale' => currentLocale(), 'categoryId' => '182969']) }}" class="category-showcase-card fade-in-up delay-3">
                    <div class="category-showcase-image">
                        <svg width="120" height="120" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <!-- Coffee Machine -->
                            <rect x="35" y="40" width="50" height="45" rx="4" fill="#002748"/>
                            <rect x="40" y="30" width="40" height="12" rx="2" fill="#003B5C"/>
                            <circle cx="60" cy="55" r="8" fill="#FFEC2D"/>
                            <rect x="45" y="65" width="8" height="3" fill="#FFEC2D"/>
                            <rect x="67" y="65" width="8" height="3" fill="#FFEC2D"/>
                            <rect x="50" y="78" width="20" height="3" rx="1" fill="#666"/>
                            <path d="M55 81 Q60 88 65 81" fill="none" stroke="#FFEC2D" stroke-width="2"/>
                        </svg>
                    </div>
                    <h3 class="category-showcase-title">Food service</h3>
                </a>
            </div>

            <!-- Row 2 -->
            <div class="category-showcase-grid mt-8">
                <a href="{{ route('shop', ['locale' => currentLocale(), 'categoryId' => '26242']) }}" class="category-showcase-card fade-in-up">
                    <div class="category-showcase-image">
                        <svg width="120" height="120" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <!-- Calculator -->
                            <rect x="35" y="25" width="50" height="70" rx="4" fill="#002748"/>
                            <rect x="40" y="30" width="40" height="15" rx="2" fill="#FFEC2D"/>
                            <rect x="42" y="50" width="10" height="8" rx="1" fill="#666"/>
                            <rect x="55" y="50" width="10" height="8" rx="1" fill="#666"/>
                            <rect x="68" y="50" width="10" height="8" rx="1" fill="#666"/>
                            <rect x="42" y="62" width="10" height="8" rx="1" fill="#666"/>
                            <rect x="55" y="62" width="10" height="8" rx="1" fill="#666"/>
                            <rect x="68" y="62" width="10" height="8" rx="1" fill="#666"/>
                            <rect x="42" y="74" width="10" height="8" rx="1" fill="#666"/>
                            <rect x="55" y="74" width="10" height="8" rx="1" fill="#666"/>
                            <rect x="68" y="74" width="10" height="8" rx="1" fill="#FFEC2D"/>
                        </svg>
                    </div>
                    <h3 class="category-showcase-title">Office equipment</h3>
                </a>

                <a href="{{ route('shop', ['locale' => currentLocale(), 'categoryId' => '26238']) }}" class="category-showcase-card fade-in-up delay-2">
                    <div class="category-showcase-image">
                        <svg width="120" height="120" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <!-- Wrench and Screwdriver -->
                            <path d="M35 75 L45 85 L65 65 L55 55 Z" fill="#666"/>
                            <circle cx="32" cy="72" r="8" fill="#002748" stroke="#FFEC2D" stroke-width="2"/>
                            <rect x="60" y="30" width="6" height="45" rx="1" fill="#FF6B00"/>
                            <polygon points="63,28 58,35 68,35" fill="#666"/>
                            <line x1="50" y1="50" x2="70" y2="70" stroke="#FFEC2D" stroke-width="2"/>
                        </svg>
                    </div>
                    <h3 class="category-showcase-title">Facility maintenance</h3>
                </a>
            </div>
        </div>
    </section>

    <!-- Featured Products Section with Wavy Background -->
    <section id="products" class="products-section wave-background-full">
        <div class="wave-divider wave-top"></div>
        <div class="container">
            <h2 class="section-title fade-in-up" data-i18n="products_title">Featured Products</h2>
            <p class="section-subtitle fade-in-up delay-1" data-i18n="products_subtitle">High-quality industrial machinery and equipment</p>

            <div class="products-grid">
                @forelse($featuredProducts as $index => $product)
                <div class="product-card fade-in-up {{ 'delay-' . ($index % 6) }}">
                    <div class="product-image">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}">
                        @else
                            <img src="product.png" alt="{{ $product->title }}">
                        @endif
                        @if($index === 0)
                            <span class="product-badge">Featured</span>
                        @endif
                    </div>
                    <div class="product-content">
                        @if($product->category)
                            <span class="product-category">{{ $product->category }}</span>
                        @endif
                        <h3 class="product-title">{{ $product->title }}</h3>
                        @if($product->subtitle)
                            <p class="product-desc">{{ $product->subtitle }}</p>
                        @endif
                        <div class="product-price-section">
                            <span class="product-price-label" data-i18n="product_original_price">Original Price</span>
                            <span class="product-price">USD ${{ number_format($product->price, 2) }}</span>
                        </div>
                        <div class="product-actions">
                            @if($product->product_url)
                                <a href="{{ $product->product_url }}" target="_blank" class="btn btn-outline btn-block" data-i18n="product_details">View Details</a>
                            @endif
                            <a href="{{ route('request-quote', ['locale' => currentLocale(), 'product_url' => $product->product_url ?? '']) }}" class="btn btn-secondary btn-block" data-i18n="product_rfq">Request Quote</a>
                        </div>
                    </div>
                </div>
                @empty
                <!-- Default Product Card (shown when no products in database) -->
                <div class="product-card fade-in-up">
                    <div class="product-image">
                        <img src="product.png" alt="Product">
                        <span class="product-badge">Featured</span>
                    </div>
                    <div class="product-content">
                        <span class="product-category">Parts & Components</span>
                        <h3 class="product-title">Industrial Equipment</h3>
                        <p class="product-desc">High-quality industrial machinery and parts</p>
                        <div class="product-price-section">
                            <span class="product-price-label" data-i18n="product_original_price">Original Price</span>
                            <span class="product-price">USD $0.00</span>
                        </div>
                        <div class="product-actions">
                            <a href="{{ route('request-quote', ['locale' => currentLocale()]) }}" class="btn btn-secondary btn-block" data-i18n="product_rfq">Request Quote</a>
                        </div>
                    </div>
                </div>
                @endforelse
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('shop', ['locale' => currentLocale()]) }}" class="btn btn-primary btn-lg" data-i18n="products_view_all">View All Products</a>
            </div>
        </div>
        <div class="wave-divider wave-bottom"></div>
    </section>

    <!-- Request Quote Section -->
    <section id="request-quote" class="request-quote-section wave-background-full">
        <div class="wave-divider wave-top"></div>
        <div class="container">
            <div class="request-quote-cta-content fade-in-up">
                <h2 class="section-title" data-i18n="home_quote_title">Request a Quote</h2>
                <p class="section-subtitle" data-i18n="home_quote_subtitle">
                    Get competitive pricing for industrial equipment and parts. Fill out the form and our team will respond within 24 hours.
                </p>
                <ul class="request-quote-benefits">
                    <li data-i18n="home_quote_benefit1">✓ Customized pricing for your business</li>
                    <li data-i18n="home_quote_benefit2">✓ Access to worldwide suppliers</li>
                    <li data-i18n="home_quote_benefit3">✓ Expert technical support</li>
                    <li data-i18n="home_quote_benefit4">✓ Fast turnaround time</li>
                </ul>
                <div class="request-quote-button">
                    <a href="{{ route('request-quote', ['locale' => currentLocale()]) }}" class="btn btn-primary btn-lg" data-i18n="home_quote_button">Get Your Quote Now</a>
                </div>
            </div>
        </div>
        <div class="wave-divider wave-bottom"></div>
    </section>

    <!-- CTA Section with Wavy Background -->
    <section id="cta" class="cta-section wave-background-bottom">
        <div class="wave-divider wave-top"></div>
        <div class="container">
            <div class="cta-content fade-in-up">
                <h2 class="section-title-white" data-i18n="contact_title">Get In Touch</h2>
                <p class="section-subtitle text-white" data-i18n="contact_subtitle">Have questions? Contact our team for personalized assistance</p>
                <div class="cta-buttons">
                    <a href="{{ route('contact', ['locale' => currentLocale()]) }}" class="btn btn-secondary btn-lg" data-i18n="contact_cta">Contact Us</a>
                    <a href="{{ route('request-quote', ['locale' => currentLocale()]) }}" class="btn btn-outline-white btn-lg" data-i18n="contact_rfq">Request Quote</a>
                </div>
            </div>
        </div>
    </section>
@endsection
