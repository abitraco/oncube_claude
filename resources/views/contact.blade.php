<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Contact ONCUBE GLOBAL - Get in touch with our team for industrial and semiconductor equipment solutions">
    <title>Contact Us - ONCUBE GLOBAL</title>

    <!-- Design System Styles -->
    <link rel="stylesheet" href="{{ asset('css/design-system.css') }}">
    <link rel="stylesheet" href="{{ asset('css/waves.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('css/b2b-styles.css') }}">
</head>
<body>
    @include('partials.header')

    <!-- Contact Hero -->
    <section class="contact-hero-section wave-background-top">
        <div class="container">
            <div class="contact-hero-content">
                <div class="contact-hero-text fade-in-up">
                    <h1 class="contact-hero-title">Let's talk.</h1>
                    <p class="contact-hero-subtitle">
                        ONCUBE GLOBAL is the easiest way to source industrial and semiconductor equipment,
                        parts, and services directly for your business – solutions that just work.
                    </p>
                    <p class="contact-hero-intro">Talk to our team today to:</p>
                    <ul class="contact-hero-list">
                        <li>Understand how our products may fit in your business needs</li>
                        <li>Discover the capabilities and get answers to your questions</li>
                        <li>Get a customized quote for your business requirements</li>
                    </ul>

                    <div class="trusted-by-section">
                        <p class="trusted-by-title">Trusted by:</p>
                        <div class="trusted-logos">
                            <div class="trusted-logo-item">
                                <svg width="80" height="30" viewBox="0 0 80 30" fill="none">
                                    <rect x="5" y="8" width="70" height="14" rx="2" fill="#002748"/>
                                    <text x="40" y="20" font-size="12" fill="#fff" text-anchor="middle" font-weight="bold">PARTNER 1</text>
                                </svg>
                            </div>
                            <div class="trusted-logo-item">
                                <svg width="80" height="30" viewBox="0 0 80 30" fill="none">
                                    <rect x="5" y="8" width="70" height="14" rx="2" fill="#002748"/>
                                    <text x="40" y="20" font-size="12" fill="#fff" text-anchor="middle" font-weight="bold">PARTNER 2</text>
                                </svg>
                            </div>
                            <div class="trusted-logo-item">
                                <svg width="80" height="30" viewBox="0 0 80 30" fill="none">
                                    <rect x="5" y="8" width="70" height="14" rx="2" fill="#002748"/>
                                    <text x="40" y="20" font-size="12" fill="#fff" text-anchor="middle" font-weight="bold">PARTNER 3</text>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="contact-form-wrapper fade-in-up delay-1">
                    <form class="contact-form" id="contactForm" onsubmit="handleContactSubmit(event)">
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label" for="firstName">First name<span class="form-required">*</span></label>
                                <input type="text" id="firstName" name="firstName" class="form-input" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="lastName">Last name<span class="form-required">*</span></label>
                                <input type="text" id="lastName" name="lastName" class="form-input" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="workEmail">Work Email<span class="form-required">*</span></label>
                            <input type="email" id="workEmail" name="workEmail" class="form-input" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="companyName">Company name<span class="form-required">*</span></label>
                            <input type="text" id="companyName" name="companyName" class="form-input" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="numEmployees">Number of employees<span class="form-required">*</span></label>
                            <select id="numEmployees" name="numEmployees" class="form-select" required>
                                <option value="">Please Select</option>
                                <option value="1-10">1-10</option>
                                <option value="11-50">11-50</option>
                                <option value="51-200">51-200</option>
                                <option value="201-500">201-500</option>
                                <option value="501-1000">501-1,000</option>
                                <option value="1000+">1,000+</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="industry">Industry<span class="form-required">*</span></label>
                            <select id="industry" name="industry" class="form-select" required>
                                <option value="">Please Select</option>
                                <option value="semiconductor">Semiconductor Manufacturing</option>
                                <option value="heavy-equipment">Heavy Equipment</option>
                                <option value="automotive">Automotive</option>
                                <option value="aerospace">Aerospace</option>
                                <option value="healthcare">Healthcare & Medical Devices</option>
                                <option value="food-service">Food Service</option>
                                <option value="agriculture">Agriculture</option>
                                <option value="manufacturing">General Manufacturing</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <div class="form-row">
                            <div class="form-group" style="flex: 0 0 120px;">
                                <label class="form-label" for="countryCode">Phone</label>
                                <select id="countryCode" name="countryCode" class="form-select">
                                    <option value="+39">🇮🇹 +39</option>
                                    <option value="+1">🇺🇸 +1</option>
                                    <option value="+82">🇰🇷 +82</option>
                                    <option value="+81">🇯🇵 +81</option>
                                    <option value="+86">🇨🇳 +86</option>
                                    <option value="+44">🇬🇧 +44</option>
                                    <option value="+49">🇩🇪 +49</option>
                                </select>
                            </div>
                            <div class="form-group" style="flex: 1;">
                                <label class="form-label" for="phoneNumber">&nbsp;</label>
                                <input type="tel" id="phoneNumber" name="phoneNumber" class="form-input" placeholder="Phone number">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="jobTitle">Job title</label>
                            <input type="text" id="jobTitle" name="jobTitle" class="form-input">
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="message">Message</label>
                            <textarea id="message" name="message" class="form-textarea" rows="4" placeholder="Tell us about your needs..."></textarea>
                        </div>

                        <div class="form-privacy">
                            <p>
                                <strong>ONCUBE GLOBAL</strong> is committed to protecting and respecting your privacy.
                            </p>
                        </div>

                        <div class="form-checkbox-group">
                            <label class="checkbox-label-inline">
                                <input type="checkbox" name="newsletter">
                                <span>I'd like to occasionally receive other communications from ONCUBE GLOBAL, such as content and product news.</span>
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg btn-block">Send</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="wave-divider wave-bottom"></div>
    </section>

    <!-- Contact Information Cards -->
    <section class="contact-info-section">
        <div class="container">
            <h2 class="section-title fade-in-up">Get in Touch</h2>
            <div class="contact-info-grid">
                <div class="contact-info-card fade-in-up">
                    <div class="contact-info-card-icon">
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="20" cy="20" r="18" fill="#FFEC2D"/>
                            <path d="M12 14 L20 20 L28 14" stroke="#002748" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <rect x="10" y="12" width="20" height="16" rx="2" stroke="#002748" stroke-width="2" fill="none"/>
                        </svg>
                    </div>
                    <h3>Email Us</h3>
                    <p>oncube2019@gmail.com</p>
                </div>

                <div class="contact-info-card fade-in-up delay-1">
                    <div class="contact-info-card-icon">
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="20" cy="20" r="18" fill="#FFEC2D"/>
                            <path d="M14 14 L16 12 C16.5 11.5 17.5 11.5 18 12 L20 14 C20.5 14.5 20.5 15.5 20 16 L18 18 C18 18 18 20 20 22 C22 24 24 24 24 24 L26 22 C26.5 21.5 27.5 21.5 28 22 L30 24 C30.5 24.5 30.5 25.5 30 26 L28 28 C27 29 25 29 22 27 C19 25 15 21 13 18 C11 15 11 13 12 12" stroke="#002748" stroke-width="2" fill="none"/>
                        </svg>
                    </div>
                    <h3>Call Us</h3>
                    <p>Tel: +82-10-4846-0846</p>
                    <p>Fax: +82-504-476-0846</p>
                </div>

                <div class="contact-info-card fade-in-up delay-2">
                    <div class="contact-info-card-icon">
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="20" cy="20" r="18" fill="#FFEC2D"/>
                            <path d="M20 10 C16 10 12 13 12 17 C12 23 20 30 20 30 C20 30 28 23 28 17 C28 13 24 10 20 10 Z" stroke="#002748" stroke-width="2" fill="none"/>
                            <circle cx="20" cy="17" r="3" fill="#002748"/>
                        </svg>
                    </div>
                    <h3>Visit Us</h3>
                    <p>98, Gasan digital 2-ro, Unit 2-209</p>
                    <p>IT Castle, Geumcheon-gu</p>
                    <p>Seoul 08506, Korea</p>
                </div>
            </div>
        </div>
    </section>

    @include('partials.footer')

    <!-- Page-specific Scripts -->
    <script src="{{ asset('js/cart.js') }}"></script>
    <script>
        function handleContactSubmit(event) {
            event.preventDefault();

            const formData = new FormData(event.target);
            const data = Object.fromEntries(formData);

            console.log('Contact form submitted:', data);

            // Show success notification
            showContactNotification('Thank you! We will get back to you soon.');

            // Reset form
            event.target.reset();
        }

        function showContactNotification(message) {
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed;
                top: 100px;
                right: 20px;
                background-color: var(--primary-900);
                color: var(--white);
                padding: var(--space-4) var(--space-6);
                border-radius: var(--radius-lg);
                box-shadow: var(--shadow-xl);
                z-index: 10000;
                animation: slideIn 0.3s ease-out;
            `;
            notification.textContent = message;
            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.animation = 'slideOut 0.3s ease-out';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }
    </script>
</body>
</html>
