<!-- Navigation -->
<nav class="nav">
    <div class="container">
        <div class="nav-content">
            <a href="{{ route('home', ['locale' => currentLocale()]) }}" class="logo">
                <img src="{{ asset('assets/logo.svg') }}" alt="ONCUBE GLOBAL" style="height: 50px;">
            </a>
            <button class="mobile-menu-toggle" aria-label="Toggle menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <ul class="nav-links">
                <li><a href="{{ route('home', ['locale' => currentLocale()]) }}" class="{{ request()->routeIs('home') ? 'active' : '' }}" data-i18n="nav_home">Home</a></li>
                <li><a href="{{ route('shop', ['locale' => currentLocale()]) }}" class="{{ request()->routeIs('shop') || request()->routeIs('shop.motors') ? 'active' : '' }}" data-i18n="nav_shop">Shop</a></li>
                <li><a href="{{ route('about', ['locale' => currentLocale()]) }}" class="{{ request()->routeIs('about') ? 'active' : '' }}" data-i18n="nav_about">About Us</a></li>
                <li><a href="{{ route('contact', ['locale' => currentLocale()]) }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}" data-i18n="nav_contact">Contact Us</a></li>
                <li class="language-selector" style="display: flex !important; flex-direction: row !important; flex-wrap: nowrap !important;">
                    @php $currentLang = currentLocale(); @endphp
                    <a href="{{ route(Route::currentRouteName(), array_merge(Route::current()->parameters(), ['locale' => 'en'])) }}" class="lang-btn lang-selector {{ $currentLang === 'en' ? 'active' : '' }}" data-lang="en" style="white-space: nowrap; {{ $currentLang === 'en' ? 'background: transparent !important; border: 2px solid --primary-900; font-weight: 700 !important;' : '' }}">EN</a>
                    <a href="{{ route(Route::currentRouteName(), array_merge(Route::current()->parameters(), ['locale' => 'ko'])) }}" class="lang-btn lang-selector {{ $currentLang === 'ko' ? 'active' : '' }}" data-lang="ko" style="white-space: nowrap; {{ $currentLang === 'ko' ? 'background: transparent !important; border: 2px solid --primary-900; font-weight: 700 !important;' : '' }}">한</a>
                    <a href="{{ route(Route::currentRouteName(), array_merge(Route::current()->parameters(), ['locale' => 'ja'])) }}" class="lang-btn lang-selector {{ $currentLang === 'ja' ? 'active' : '' }}" data-lang="ja" style="white-space: nowrap; {{ $currentLang === 'ja' ? 'background: transparent !important; border: 2px solid --primary-900; font-weight: 700 !important;' : '' }}">日</a>
                    <a href="{{ route(Route::currentRouteName(), array_merge(Route::current()->parameters(), ['locale' => 'zh'])) }}" class="lang-btn lang-selector {{ $currentLang === 'zh' ? 'active' : '' }}" data-lang="zh" style="white-space: nowrap; {{ $currentLang === 'zh' ? 'background: transparent !important; border: 2px solid --primary-900; font-weight: 700 !important;' : '' }}">中</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
