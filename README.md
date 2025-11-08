# ONCUBE GLOBAL - B2B Industrial Equipment Platform

Laravel 11 기반의 산업용 장비 및 반도체 부품 B2B 플랫폼입니다.

## 🚀 배포 정보

- **플랫폼**: Render.com
- **프레임워크**: Laravel 11
- **PHP 버전**: 8.3
- **데이터베이스**: SQLite
- **웹서버**: Nginx + PHP-FPM

## 📋 주요 기능

- ✅ 다국어 지원 (영어, 한국어, 일본어, 중국어)
- ✅ RFQ (Request for Quote) 시스템
- ✅ 제품 카탈로그
- ✅ 반응형 웨이브 디자인
- ✅ Contact 폼

## 🛠 로컬 개발 환경 설정

### 1. 의존성 설치

```bash
composer install
```

### 2. 환경 설정

```bash
# .env 파일 생성
cp .env.example .env

# 애플리케이션 키 생성
php artisan key:generate

# SQLite 데이터베이스 생성
touch database/database.sqlite

# 스토리지 링크
php artisan storage:link
```

### 3. 개발 서버 실행

```bash
php artisan serve
```

브라우저에서 http://localhost:8000 접속

## 📦 배포 방법

### Render 자동 배포

1. GitHub 저장소에 푸시:
```bash
git add .
git commit -m "Laravel 11 setup"
git push origin main
```

2. Render 대시보드에서:
   - New Web Service 클릭
   - GitHub 저장소 연결
   - `render.yaml` 자동 감지
   - Deploy 시작

### 수동 배포 스크립트

```bash
chmod +x deploy.sh
./deploy.sh
```

## 🏗 프로젝트 구조

```
oncube/
├── app/                    # 애플리케이션 로직
├── bootstrap/              # 부트스트랩 파일
├── config/                 # 설정 파일
├── database/              # 데이터베이스
│   └── database.sqlite   # SQLite DB
├── public/                # 공개 디렉토리
│   ├── css/              # CSS 파일
│   ├── js/               # JavaScript 파일
│   ├── assets/           # 이미지 및 자산
│   └── index.php         # 엔트리 포인트
├── resources/
│   └── views/            # Blade 템플릿
│       ├── home.blade.php
│       ├── shop.blade.php
│       ├── about.blade.php
│       └── contact.blade.php
├── routes/
│   └── web.php           # 웹 라우트
├── storage/              # 스토리지
├── Dockerfile            # Docker 이미지
├── render.yaml           # Render 설정
└── composer.json         # PHP 의존성
```

## 🎨 디자인 시스템

- **Primary Color**: #002748 (Deep Blue)
- **Secondary Color**: #FFEC2D (Yellow)
- **Success Color**: #19BD0A (Green)
- **Wave Pattern**: SVG 기반 웨이브 배경

## 📞 연락처

**ONCUBE GLOBAL**
- Address: 98, Gasan digital 2-ro, Unit 2-209, IT Castle, Geumcheon-gu, Seoul 08506, Korea
- Tel: +82-10-4846-0846
- Fax: +82-504-476-0846
- Email: oncube2019@gmail.com
- Biz License: 416-19-94501

## 📄 라이선스

Proprietary - ONCUBE GLOBAL

## 🔧 기술 스택

- **Backend**: Laravel 11, PHP 8.3
- **Frontend**: HTML5, CSS3 (Vanilla), JavaScript (Vanilla)
- **Database**: SQLite
- **Deployment**: Docker, Render.com
- **Server**: Nginx, PHP-FPM

## 📚 문서

자세한 설정 가이드는 [LARAVEL_SETUP_GUIDE.md](LARAVEL_SETUP_GUIDE.md)를 참고하세요.

---

© 2025 ONCUBE GLOBAL. All rights reserved.
