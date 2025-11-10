<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="footer-content-grid">
            <div class="footer-column">
                <img src="{{ asset('assets/logo.png') }}" alt="ONCUBE GLOBAL" style="height: 55px; margin-bottom: var(--space-4); object-fit: contain;">
                <p>Your trusted partner for industrial machinery, equipment & parts worldwide.</p>
            </div>

            <div class="footer-column">
                <h4 data-i18n="footer_quick_links">Quick Links</h4>
                <ul class="footer-links">
                    <li><a href="{{ route('home', ['locale' => currentLocale()]) }}" data-i18n="nav_home">Home</a></li>
                    <li><a href="{{ route('shop', ['locale' => currentLocale()]) }}" data-i18n="nav_shop">Shop</a></li>
                    <li><a href="{{ route('about', ['locale' => currentLocale()]) }}" data-i18n="nav_about">About Us</a></li>
                    <li><a href="{{ route('contact', ['locale' => currentLocale()]) }}" data-i18n="nav_contact">Contact Us</a></li>
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
            <p>&copy; 2025 ONCUBE GLOBAL. All rights reserved.</p>
        </div>
    </div>
</footer>

<!-- Common Scripts -->
<script src="{{ asset('js/mobile-menu.js') }}"></script>
<script src="{{ asset('js/language.js') }}"></script>
<script src="{{ asset('js/animations.js') }}"></script>
