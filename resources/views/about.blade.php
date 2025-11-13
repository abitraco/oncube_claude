@extends('layouts.app')

@section('title', 'About Us - ONCUBE GLOBAL')
@section('meta_description', 'Learn about ONCUBE GLOBAL - Your trusted partner for industrial and semiconductor equipment, parts, and services worldwide')

@section('content')
    <!-- About Hero with Wave -->
    <section class="about-hero wave-background-top">
        <div class="container">
            <h1 class="hero-title fade-in-up" data-i18n="about_hero_title">About ONCUBE GLOBAL</h1>
            <p class="hero-subtitle fade-in-up delay-1" data-i18n="about_hero_subtitle">Your Trusted Partner in Industrial & Semiconductor Solutions</p>
        </div>
        <div class="wave-divider wave-bottom"></div>
    </section>

    <!-- Company Overview -->
    <section class="about-content-section">
        <div class="container">
            <div class="about-intro fade-in-up">
                <h2 class="section-title">Leading the Industry Forward</h2>
                <p class="section-text">
                    ONCUBE GLOBAL is a premier provider of industrial and semiconductor equipment services, parts, and solutions.
                    With a customer-centric approach and commitment to excellence, we empower businesses worldwide to achieve
                    operational success through innovative technology, quality components, and unparalleled technical support.
                </p>
            </div>

            <div class="about-grid">
                <!-- Mission -->
                <div class="about-card fade-in-up">
                    <div class="about-card-icon">
                        <svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="30" cy="30" r="28" fill="#EDF3F6" stroke="#002748" stroke-width="2"/>
                            <path d="M30 15 L35 25 L45 27 L37 35 L39 45 L30 40 L21 45 L23 35 L15 27 L25 25 Z" fill="#FFEC2D"/>
                        </svg>
                    </div>
                    <h3>Our Mission</h3>
                    <p>
                        To drive global industrial and semiconductor success by delivering customized solutions through our
                        expansive network of technical resources and localized quality parts. We bridge the gap between innovation
                        and practical application, ensuring our clients stay ahead in competitive markets.
                    </p>
                </div>

                <!-- Expertise -->
                <div class="about-card fade-in-up delay-1">
                    <div class="about-card-icon">
                        <svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="15" y="15" width="30" height="30" rx="4" fill="#002748"/>
                            <circle cx="30" cy="30" r="8" fill="#FFEC2D"/>
                            <rect x="25" y="10" width="10" height="8" rx="2" fill="#003B5C"/>
                            <rect x="25" y="42" width="10" height="8" rx="2" fill="#003B5C"/>
                            <rect x="10" y="25" width="8" height="10" rx="2" fill="#003B5C"/>
                            <rect x="42" y="25" width="8" height="10" rx="2" fill="#003B5C"/>
                        </svg>
                    </div>
                    <h3>Our Expertise</h3>
                    <p>
                        Specializing in industrial and semiconductor equipment manufacturing, we offer comprehensive solutions
                        with competitive pricing and rapid response times. Our expertise extends to 8" PVD equipment composition,
                        maintenance, and precision part assembly for critical semiconductor applications.
                    </p>
                </div>

                <!-- Team -->
                <div class="about-card fade-in-up delay-2">
                    <div class="about-card-icon">
                        <svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="20" cy="20" r="8" fill="#002748"/>
                            <circle cx="40" cy="20" r="8" fill="#003B5C"/>
                            <circle cx="30" cy="35" r="8" fill="#FFEC2D"/>
                            <path d="M12 45 Q20 40 28 45" fill="#002748"/>
                            <path d="M32 45 Q40 40 48 45" fill="#003B5C"/>
                        </svg>
                    </div>
                    <h3>Our Team</h3>
                    <p>
                        Every project is managed by experienced sales professionals and skilled engineers who provide tailored
                        solutions and exceptional service. Our team's deep technical knowledge ensures that each client receives
                        the right solution at the right time, backed by industry-leading support.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="why-choose-section wave-background-full">
        <div class="wave-divider wave-top"></div>
        <div class="container">
            <h2 class="section-title fade-in-up">Why Choose ONCUBE GLOBAL?</h2>
            <p class="section-subtitle fade-in-up delay-1">Excellence in Every Aspect of Our Service</p>

            <div class="features-grid">
                <div class="feature-card fade-in-up">
                    <div class="feature-icon">
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="20" cy="20" r="18" fill="#FFEC2D"/>
                            <path d="M15 20 L18 23 L25 16" stroke="#002748" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h3 class="feature-title">Quality Assurance</h3>
                    <p class="feature-text">Premium quality parts and equipment rigorously tested to meet international standards</p>
                </div>

                <div class="feature-card fade-in-up delay-1">
                    <div class="feature-icon">
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="20" cy="20" r="18" fill="#FFEC2D"/>
                            <path d="M12 20 L20 12 L28 20 L20 28 Z" fill="#002748"/>
                        </svg>
                    </div>
                    <h3 class="feature-title">Fast Response</h3>
                    <p class="feature-text">Quick turnaround times with efficient logistics and responsive customer service</p>
                </div>

                <div class="feature-card fade-in-up delay-2">
                    <div class="feature-icon">
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="20" cy="20" r="18" fill="#FFEC2D"/>
                            <rect x="15" y="15" width="10" height="10" fill="#002748"/>
                            <circle cx="20" cy="20" r="3" fill="#FFEC2D"/>
                        </svg>
                    </div>
                    <h3 class="feature-title">Competitive Pricing</h3>
                    <p class="feature-text">Cost-effective solutions without compromising on quality or service excellence</p>
                </div>

                <div class="feature-card fade-in-up">
                    <div class="feature-icon">
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="20" cy="20" r="18" fill="#FFEC2D"/>
                            <circle cx="20" cy="20" r="12" stroke="#002748" stroke-width="2" fill="none"/>
                            <circle cx="20" cy="20" r="6" fill="#002748"/>
                        </svg>
                    </div>
                    <h3 class="feature-title">Global Network</h3>
                    <p class="feature-text">Worldwide reach with localized support and technical resources in key markets</p>
                </div>

                <div class="feature-card fade-in-up delay-1">
                    <div class="feature-icon">
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="20" cy="20" r="18" fill="#FFEC2D"/>
                            <path d="M10 20 L15 15 L20 20 L25 15 L30 20" stroke="#002748" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M10 25 L15 20 L20 25 L25 20 L30 25" stroke="#002748" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h3 class="feature-title">Technical Expertise</h3>
                    <p class="feature-text">Professional engineers with deep industry knowledge and hands-on experience</p>
                </div>

                <div class="feature-card fade-in-up delay-2">
                    <div class="feature-icon">
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="20" cy="20" r="18" fill="#FFEC2D"/>
                            <path d="M20 10 L25 18 L33 19 L26 26 L28 34 L20 30 L12 34 L14 26 L7 19 L15 18 Z" fill="#002748"/>
                        </svg>
                    </div>
                    <h3 class="feature-title">Customized Solutions</h3>
                    <p class="feature-text">Tailored services designed to meet your specific industrial requirements</p>
                </div>
            </div>
        </div>
        <div class="wave-divider wave-bottom"></div>
    </section>

    <!-- Specialization Section -->
    <section class="specialization-section">
        <div class="container">
            <h2 class="section-title fade-in-up">Our Specializations</h2>

            <div class="specialization-grid">
                <div class="specialization-card fade-in-up">
                    <div class="specialization-number">01</div>
                    <h3>8" PVD Equipment</h3>
                    <p>
                        Expert composition and maintenance of 8-inch Physical Vapor Deposition (PVD) equipment for
                        semiconductor manufacturing. Our specialized team ensures optimal performance and longevity
                        of your critical production equipment.
                    </p>
                </div>

                <div class="specialization-card fade-in-up delay-1">
                    <div class="specialization-number">02</div>
                    <h3>Part Assembly</h3>
                    <p>
                        Precision part assembly services for industrial and semiconductor applications. We maintain
                        strict quality control standards throughout the assembly process, ensuring perfect integration
                        and reliable operation.
                    </p>
                </div>

                <div class="specialization-card fade-in-up delay-2">
                    <div class="specialization-number">03</div>
                    <h3>Equipment Services</h3>
                    <p>
                        Comprehensive service packages including installation, calibration, preventive maintenance,
                        and emergency repairs. Our 24/7 support ensures minimal downtime and maximum productivity
                        for your operations.
                    </p>
                </div>

                <div class="specialization-card fade-in-up delay-3">
                    <div class="specialization-number">04</div>
                    <h3>Quality Parts Supply</h3>
                    <p>
                        Extensive inventory of genuine and certified replacement parts for industrial and semiconductor
                        equipment. Fast delivery and competitive pricing backed by comprehensive warranty coverage.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Commitment Section -->
    <section class="commitment-section wave-background-bottom">
        <div class="container">
            <div class="commitment-content fade-in-up">
                <h2 class="section-title">Our Commitment to Excellence</h2>
                <p class="commitment-text">
                    ONCUBE GLOBAL is dedicated to continuous advancement in service quality and product innovation.
                    We invest heavily in research, development, and staff training to ensure we deliver cutting-edge
                    solutions that meet the evolving needs of the semiconductor and industrial sectors.
                </p>
                <p class="commitment-text">
                    Our commitment extends beyond transactions—we build lasting partnerships with our clients. By
                    understanding your unique challenges and goals, we provide strategic support that contributes to
                    your long-term success and competitive advantage in the global marketplace.
                </p>
                <p class="commitment-text">
                    As we continue to grow, we remain focused on our core values: quality, reliability, innovation,
                    and customer satisfaction. We strive to achieve excellence in every interaction, delivering
                    advanced services and premium products on time, every time.
                </p>
                <div class="commitment-cta">
                    <a href="{{ route('contact', ['locale' => currentLocale()]) }}" class="btn btn-primary btn-lg">Partner With Us</a>
                    <a href="{{ route('shop', ['locale' => currentLocale()]) }}" class="btn btn-outline btn-lg">Browse Products</a>
                </div>
            </div>
        </div>
        <div class="wave-divider wave-bottom"></div>
    </section>

    <!-- Request Quote Section -->
    <section id="request-quote" class="request-quote-section wave-background-bottom">
        <div class="wave-divider wave-top"></div>
        <div class="container">
            <div class="request-quote-content">
                <div class="request-quote-text fade-in-up">
                    <h2 class="section-title">Start Your Partnership</h2>
                    <p class="section-subtitle">
                        Ready to experience the ONCUBE GLOBAL difference? Request a quote and discover how we can support your business.
                    </p>
                    <ul class="request-quote-benefits">
                        <li>✓ Trusted by global manufacturers</li>
                        <li>✓ Customized B2B solutions</li>
                        <li>✓ Technical expertise & support</li>
                        <li>✓ Long-term partnership focus</li>
                    </ul>
                </div>
                <div class="request-quote-form-wrapper fade-in-up delay-1">
                    @include('partials.request-quote-form')
                </div>
            </div>
        </div>
    </section>
@endsection
