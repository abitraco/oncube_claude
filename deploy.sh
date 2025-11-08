#!/bin/bash

echo "🚀 ONCUBE GLOBAL 배포 스크립트"
echo "================================"

# 1. Composer 의존성 설치 확인
if [ ! -d "vendor" ]; then
    echo "📦 Composer 의존성 설치 중..."
    composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader
fi

# 2. 환경 파일 확인
if [ ! -f ".env" ]; then
    echo "📝 .env 파일 생성 중..."
    cp .env.example .env
fi

# 3. 애플리케이션 키 생성
if ! grep -q "APP_KEY=base64:" .env; then
    echo "🔑 애플리케이션 키 생성 중..."
    php artisan key:generate --ansi
fi

# 4. SQLite 데이터베이스 생성
if [ ! -f "database/database.sqlite" ]; then
    echo "💾 SQLite 데이터베이스 생성 중..."
    touch database/database.sqlite
fi

# 5. 스토리지 링크
echo "🔗 스토리지 링크 생성 중..."
php artisan storage:link 2>/dev/null || true

# 6. 캐시 클리어 및 최적화
echo "⚡ 캐시 최적화 중..."
php artisan optimize

# 7. 권한 설정
echo "🔒 권한 설정 중..."
chmod -R 775 storage bootstrap/cache 2>/dev/null || true

echo "✅ 배포 준비 완료!"
echo ""
echo "다음 단계:"
echo "1. git add ."
echo "2. git commit -m 'Laravel 11 setup complete'"
echo "3. git push origin main"
echo ""
echo "Render에서 자동으로 배포됩니다."
