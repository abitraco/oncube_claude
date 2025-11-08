# ---------- Stage 1: Composer ----------
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --no-progress
COPY . .
RUN composer install --no-dev --no-interaction --prefer-dist --no-progress \
 && php artisan package:discover --ansi || true

# ---------- Stage 2: Runtime (Nginx + PHP-FPM in one) ----------
FROM webdevops/php-nginx:8.3-alpine

# 기본 설정
ENV WEB_DOCUMENT_ROOT=/app/public
ENV PHP_DISPLAY_ERRORS=0
ENV PHP_MEMORY_LIMIT=512M
ENV PHP_MAX_EXECUTION_TIME=60

# 필요한 확장
RUN apk add --no-cache \
    php83-pgsql php83-pdo_pgsql php83-intl php83-bcmath php83-opcache

# 앱 복사
WORKDIR /app
COPY --from=vendor /app /app

# 퍼미션(캐시/세션/로그)
RUN mkdir -p /app/storage/framework/{cache,sessions,views} /app/bootstrap/cache \
 && chown -R application:application /app/storage /app/bootstrap/cache \
 && chmod -R 775 /app/storage /app/bootstrap/cache

# SQLite 데이터베이스 생성
RUN touch /app/database/database.sqlite \
 && chown application:application /app/database/database.sqlite

# 빌드 최적화
RUN php artisan optimize || true

# 헬스체크용
HEALTHCHECK --interval=30s --timeout=3s --start-period=40s \
  CMD curl -f http://localhost/health || exit 1

# 기본 CMD는 이미지에서 Nginx+PHP-FPM가 함께 기동됨
