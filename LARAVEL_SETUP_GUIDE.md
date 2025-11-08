# ONCUBE GLOBAL - Laravel 11 변환 가이드

## 1. Laravel 11 프로젝트 생성

현재 디렉토리에서 Laravel 11 프로젝트를 생성합니다:

```bash
# 임시 디렉토리에 Laravel 설치
composer create-project laravel/laravel:^11.0 temp-laravel

# Laravel 파일들을 현재 디렉토리로 복사
cp -r temp-laravel/app ./
cp -r temp-laravel/bootstrap ./
cp -r temp-laravel/config ./
cp -r temp-laravel/database ./
cp -r temp-laravel/routes ./
cp -r temp-laravel/storage ./
cp temp-laravel/.env.example ./
cp temp-laravel/server.php ./public/index.php

# 정리
rm -rf temp-laravel
```

## 2. 디렉토리 구조

프로젝트 구조는 다음과 같습니다:

```
oncube_claude/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── WebController.php
│   └── ...
├── bootstrap/
│   ├── app.php
│   └── cache/
├── config/
│   ├── app.php
│   └── ...
├── database/
│   ├── migrations/
│   └── database.sqlite
├── public/
│   ├── index.php
│   ├── css/
│   ├── js/
│   ├── assets/
│   └── product.png
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       ├── home.blade.php
│       ├── shop.blade.php
│       ├── about.blade.php
│       └── contact.blade.php
├── routes/
│   └── web.php
├── storage/
│   ├── framework/
│   ├── logs/
│   └── app/
├── .env.example
├── .env
├── composer.json
├── composer.lock
├── Dockerfile
└── render.yaml
```

## 3. Routes 설정 (routes/web.php)

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebController;

Route::get('/', [WebController::class, 'home'])->name('home');
Route::get('/home', [WebController::class, 'home'])->name('home.html');
Route::get('/shop', [WebController::class, 'shop'])->name('shop');
Route::get('/about', [WebController::class, 'about'])->name('about');
Route::get('/contact', [WebController::class, 'contact'])->name('contact');
Route::post('/contact', [WebController::class, 'submitContact'])->name('contact.submit');

// Health check for Render
Route::get('/health', function () {
    return response()->json(['status' => 'ok'], 200);
});
```

## 4. Controller 생성 (app/Http/Controllers/WebController.php)

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function shop()
    {
        return view('shop');
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }

    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'workEmail' => 'required|email',
            'companyName' => 'required|string|max:255',
            'numEmployees' => 'required|string',
            'industry' => 'required|string',
            'phoneNumber' => 'nullable|string',
            'jobTitle' => 'nullable|string',
            'message' => 'nullable|string',
        ]);

        // TODO: 이메일 발송 또는 DB 저장 로직 추가

        return response()->json(['success' => true, 'message' => 'Thank you! We will get back to you soon.']);
    }
}
```

## 5. Blade 템플릿 변환

### 5.1 레이아웃 파일 (resources/views/layouts/app.blade.php)

```blade
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('description', 'ONCUBE GLOBAL - Your trusted partner for industrial machinery')">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ONCUBE GLOBAL')</title>

    <!-- Design System Styles -->
    <link rel="stylesheet" href="{{ asset('css/design-system.css') }}">
    <link rel="stylesheet" href="{{ asset('css/waves.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('css/b2b-styles.css') }}">
    @stack('styles')
</head>
<body>
    @include('partials.navigation')

    @yield('content')

    @include('partials.footer')

    <!-- Scripts -->
    <script src="{{ asset('js/language.js') }}"></script>
    <script src="{{ asset('js/cart.js') }}"></script>
    <script src="{{ asset('js/animations.js') }}"></script>
    @stack('scripts')
</body>
</html>
```

### 5.2 내비게이션 파일 (resources/views/partials/navigation.blade.php)

```blade
<!-- Navigation -->
<nav class="nav">
    <div class="container">
        <div class="nav-content">
            <a href="{{ route('home') }}" class="logo">
                <img src="{{ asset('assets/logo.svg') }}" alt="ONCUBE GLOBAL" style="height: 50px;">
            </a>
            <ul class="nav-links">
                <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home*') ? 'active' : '' }}" data-i18n="nav_home">Home</a></li>
                <li><a href="{{ route('shop') }}" class="{{ request()->routeIs('shop') ? 'active' : '' }}" data-i18n="nav_shop">Shop</a></li>
                <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}" data-i18n="nav_about">About Us</a></li>
                <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}" data-i18n="nav_contact">Contact Us</a></li>
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
```

### 5.3 Footer 파일 (resources/views/partials/footer.blade.php)

```blade
<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="footer-content-grid">
            <div class="footer-column">
                <img src="{{ asset('assets/logo.svg') }}" alt="ONCUBE GLOBAL" style="height: 50px; margin-bottom: var(--space-4);">
                <p>Your trusted partner for industrial machinery, equipment & parts worldwide.</p>
            </div>

            <div class="footer-column">
                <h4 data-i18n="footer_quick_links">Quick Links</h4>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}" data-i18n="nav_home">Home</a></li>
                    <li><a href="{{ route('shop') }}" data-i18n="nav_shop">Shop</a></li>
                    <li><a href="{{ route('about') }}" data-i18n="nav_about">About Us</a></li>
                    <li><a href="{{ route('contact') }}" data-i18n="nav_contact">Contact Us</a></li>
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
            <p data-i18n="footer_copyright">&copy; {{ date('Y') }} ONCUBE GLOBAL. All rights reserved.</p>
        </div>
    </div>
</footer>
```

## 6. 환경 설정 (.env)

```.env
APP_NAME="ONCUBE GLOBAL"
APP_ENV=production
APP_KEY=base64:생성필요
APP_DEBUG=false
APP_URL=https://oncube-global.onrender.com

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=sqlite

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120
```

## 7. 배포 준비

### 7.1 SQLite 데이터베이스 생성

```bash
touch database/database.sqlite
```

### 7.2 권한 설정

```bash
chmod -R 775 storage bootstrap/cache
```

### 7.3 최적화 명령어

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 8. Render 배포 단계

1. GitHub 저장소에 모든 파일 푸시
2. Render 대시보드에서 "New Web Service" 클릭
3. GitHub 저장소 연결
4. render.yaml이 자동으로 감지됨
5. 환경 변수에서 APP_KEY 생성:
   ```bash
   php artisan key:generate --show
   ```
6. Deploy 시작

## 9. 로컬 테스트

```bash
# Composer 의존성 설치
composer install

# 환경 파일 복사
cp .env.example .env

# 애플리케이션 키 생성
php artisan key:generate

# 데이터베이스 생성
touch database/database.sqlite

# 개발 서버 실행
php artisan serve
```

## 10. 주요 변경사항

1. **HTML → Blade**: 모든 `.html` 파일을 `.blade.php`로 변환
2. **URL 변경**:
   - `home.html` → `{{ route('home') }}`
   - `shop.html` → `{{ route('shop') }}`
   - etc.
3. **Asset 경로**: `css/style.css` → `{{ asset('css/style.css') }}`
4. **폼 처리**: Contact 폼에 CSRF 토큰 추가 필요
5. **AJAX 요청**: Laravel API 엔드포인트 사용

## 11. 추가 개선 사항

- Contact 폼 제출 시 이메일 발송 (Laravel Mail 사용)
- 제품 데이터 DB 저장 및 관리자 페이지
- 다국어 지원 강화 (Laravel Localization)
- RFQ (Request for Quote) 시스템 구현
- 관리자 대시보드 추가
