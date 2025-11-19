# ONCUBE GLOBAL - B2B Industrial Equipment Platform

Laravel 11 기반의 산업용 장비 및 반도체 부품 B2B 유통 플랫폼

🌐 **Live Site**: [https://oncube.cloud](https://oncube.cloud)

## 📋 프로젝트 개요

ONCUBE GLOBAL은 산업용 기계 및 반도체 장비의 B2B 거래를 위한 웹 플랫폼입니다. 견적 요청 시스템(RFQ), 다국어 지원, 관리자 대시보드를 포함한 완전한 견적 관리 솔루션을 제공합니다.

### 주요 기능

- ✅ **견적 요청 시스템 (RFQ)**: 고객 견적 요청 및 관리
- ✅ **견적서 작성 도구**: 관리자용 견적서 빌더
- ✅ **다중 통화 지원**: USD, KRW (자동 VAT 계산 포함)
- ✅ **PDF 생성**: 전문적인 견적서 PDF 자동 생성
- ✅ **이메일 알림**: 고객 및 관리자 자동 알림
- ✅ **다국어 지원**: 영어, 한국어, 일본어, 중국어
- ✅ **관리자 대시보드**: 견적 요청 관리 및 추적
- ✅ **반응형 디자인**: 모바일 및 데스크톱 최적화

## 🚀 기술 스택

### Backend
- **Framework**: Laravel 11
- **PHP Version**: 8.3+
- **Database**: SQLite
- **PDF Generation**: mPDF

### Frontend
- **HTML5 / CSS3**: Vanilla CSS with modern design
- **JavaScript**: Vanilla JS for dynamic interactions
- **Font**: Malgun Gothic, Apple Gothic for Korean support

### DevOps & Deployment
- **Hosting**: Hostinger VPS
- **Containerization**: Docker + Docker Compose
- **Web Server**: Nginx + PHP-FPM
- **Deployment**: Docker Manager (Hostinger)

## 🛠 로컬 개발 환경 설정

### 1. 저장소 클론

```bash
git clone https://github.com/abitraco/oncube_claude.git
cd oncube_claude
```

### 2. 환경 설정

```bash
# .env 파일 생성
cp .env.example .env

# Composer 의존성 설치
composer install

# 애플리케이션 키 생성
php artisan key:generate

# SQLite 데이터베이스 파일 생성
touch database/database.sqlite

# 마이그레이션 실행
php artisan migrate

# 스토리지 심볼릭 링크 생성
php artisan storage:link
```

### 3. 환경 변수 설정

`.env` 파일에서 다음 항목들을 설정하세요:

```env
APP_NAME="ONCUBE GLOBAL"
APP_ENV=local
APP_URL=http://localhost:8000

# 데이터베이스
DB_CONNECTION=sqlite

# 메일 설정
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=your-email@gmail.com

# 관리자 인증
ADMIN_PASSWORD=your-secure-password
```

### 4. 개발 서버 실행

```bash
php artisan serve
```

브라우저에서 http://localhost:8000 접속

## 📦 프로덕션 배포

### Hostinger VPS (Docker Manager)

프로덕션 서버는 Hostinger VPS의 Docker Manager를 통해 배포됩니다.

#### 배포 URL

```
https://raw.githubusercontent.com/abitraco/oncube_claude/main/docker-compose.yml
```

#### 배포 단계

1. **Hostinger 패널 접속**
   - VPS 관리 패널 로그인
   - Docker Manager로 이동

2. **애플리케이션 생성**
   - "Create Application" 클릭
   - "Compose" 옵션 선택
   - Compose URL 입력: `https://raw.githubusercontent.com/abitraco/oncube_claude/main/docker-compose.yml`

3. **환경 변수 설정**
   ```env
   APP_KEY=base64:your-generated-key
   EBAY_CLIENT_ID=your-ebay-client-id
   EBAY_CLIENT_SECRET=your-ebay-client-secret
   EBAY_LEGACY_APP_ID=your-ebay-legacy-app-id
   ```

4. **Deploy 실행**

#### SSH를 통한 수동 배포

```bash
# 서버 접속
ssh root@72.61.118.53

# 프로젝트 디렉토리로 이동
cd /root/oncube_claude

# 최신 코드 가져오기
git pull origin main

# Docker 재배포
docker compose down
docker compose up -d --build
```

### 배포 후 확인

```bash
# 컨테이너 상태 확인
docker ps

# 로그 확인
docker logs oncube-web -f

# 애플리케이션 접속 테스트
curl https://oncube.cloud
```

## 🏗 프로젝트 구조

```
oncube_claude/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── QuoteRequestController.php      # 견적 요청 처리
│   │       └── Admin/
│   │           ├── QuoteBuilderController.php  # 견적서 작성
│   │           ├── QuoteRequestAdminController.php
│   │           └── DashboardController.php
│   └── QuoteRequest.php                        # 모델
├── database/
│   ├── migrations/                             # 데이터베이스 마이그레이션
│   └── database.sqlite                         # SQLite DB (gitignore)
├── public/
│   ├── assets/                                 # 이미지 및 정적 파일
│   ├── css/                                    # CSS 파일
│   └── js/                                     # JavaScript 파일
├── resources/
│   └── views/
│       ├── home.blade.php                      # 홈페이지
│       ├── admin/                              # 관리자 페이지
│       │   ├── dashboard.blade.php
│       │   ├── quote-builder.blade.php
│       │   ├── quote-review.blade.php
│       │   └── quote-history.blade.php
│       ├── emails/                             # 이메일 템플릿
│       │   ├── quote-customer.blade.php
│       │   └── quote-request-admin.blade.php
│       ├── pdf/                                # PDF 템플릿
│       │   └── quote-modern.blade.php
│       └── layouts/                            # 레이아웃
│           ├── admin.blade.php
│           └── email.blade.php
├── routes/
│   └── web.php                                 # 라우트 정의
├── storage/
│   └── app/
│       └── public/
│           └── quotes/                         # 생성된 PDF (gitignore)
├── docker-compose.yml                          # Docker Compose 설정
├── Dockerfile                                  # Docker 이미지 정의
├── nginx.conf                                  # Nginx 설정
└── composer.json                               # PHP 의존성
```

## 🎨 디자인 시스템

### 색상 팔레트

- **Primary**: `#002748` (Deep Blue) - 헤더, 버튼, 강조
- **Secondary**: `#FF6B00` (Orange) - 액센트, 링크
- **Success**: `#19BD0A` (Green) - 성공 메시지, 확인
- **Warning**: `#FFEC2D` (Yellow) - 경고, 알림
- **Background**: `#F8F9FA` (Light Gray) - 배경
- **Text**: `#333333` (Dark Gray) - 본문 텍스트

### 타이포그래피

- **한글**: Malgun Gothic, Apple Gothic, Dotum
- **영문**: Arial, sans-serif
- **헤딩**: Bold, 18-28pt
- **본문**: Regular, 9-14pt

## 📐 견적 시스템 워크플로우

### 1. 고객 견적 요청
1. 고객이 웹사이트에서 견적 요청 폼 제출
2. 시스템이 요청을 데이터베이스에 저장
3. 고객에게 확인 이메일 자동 발송
4. 관리자에게 알림 이메일 발송

### 2. 관리자 견적서 작성
1. 관리자 대시보드에서 요청 확인
2. Quote Builder에서 견적서 작성
   - 템플릿 선택 (English/Korean)
   - 항목 추가 및 가격 입력
   - 자동 통화 변환 및 VAT 계산 (한국 템플릿)
   - Terms & Conditions 설정

### 3. 견적서 검토 및 발송
1. 자동 PDF 생성 (미리보기)
2. 검토 후 고객에게 이메일 발송
3. 견적서 히스토리 저장
4. 상태 추적 (Pending → Quote Sent)

## 🔐 관리자 인증

관리자 페이지 접근:
- URL: `/admin/login`
- 비밀번호: `.env`의 `ADMIN_PASSWORD`로 설정
- 세션 기반 인증

## 📧 이메일 템플릿

### 고객용
- **견적 요청 확인**: 요청 접수 알림
- **견적서 발송**: PDF 첨부 견적서

### 관리자용
- **새 견적 요청 알림**: 고객 정보 및 요청 내역
- **견적서 발송 확인**: 발송 기록 사본

## 🌍 다국어 지원

지원 언어:
- 🇺🇸 English (`/en`)
- 🇰🇷 한국어 (`/ko`)
- 🇯🇵 日本語 (`/ja`)
- 🇨🇳 中文 (`/zh`)

언어 전환: 상단 네비게이션 바

## 📞 회사 정보

**ONCUBE GLOBAL (온큐브글로벌)**

- **주소**: 서울시 금천구 가산디지털2로 98, IT캐슬 2동 209호
- **전화**: +82-10-4846-0846
- **팩스**: +82-504-476-0846
- **이메일**: oncube2019@gmail.com
- **사업자등록번호**: 416-19-94501

## 📚 추가 문서

- [배포 가이드](DEPLOYMENT.md) - 상세한 배포 절차
- [Laravel 설정 가이드](LARAVEL_SETUP_GUIDE.md) - Laravel 설정 방법
- [Hostinger 배포](HOSTINGER_DEPLOY.md) - Hostinger 특화 가이드

## 🐛 문제 해결

### 일반적인 문제

**Q: PDF 생성이 실패합니다**
- A: `storage/app/mpdf` 디렉토리 권한 확인 (755)
- A: mPDF 라이브러리 설치 확인: `composer require mpdf/mpdf`

**Q: 이메일이 발송되지 않습니다**
- A: `.env`의 메일 설정 확인
- A: Gmail 앱 비밀번호 사용 (2단계 인증 필요)
- A: 로그 확인: `storage/logs/laravel.log`

**Q: Docker 컨테이너가 시작되지 않습니다**
- A: 로그 확인: `docker logs oncube-web`
- A: 포트 충돌 확인 (80, 443)
- A: 환경 변수 설정 확인

### 로그 확인

```bash
# Laravel 로그
tail -f storage/logs/laravel.log

# Docker 로그
docker logs oncube-web -f

# Nginx 로그
docker exec oncube-web tail -f /var/log/nginx/error.log
```

## 🤝 기여

프로젝트 개선을 위한 제안이나 버그 리포트는 GitHub Issues를 통해 제출해주세요.

## 📄 라이선스

Proprietary - ONCUBE GLOBAL

---

**최종 업데이트**: 2025년 1월
**버전**: 1.0.0
**유지보수**: ONCUBE GLOBAL Development Team

© 2025 ONCUBE GLOBAL. All rights reserved.
