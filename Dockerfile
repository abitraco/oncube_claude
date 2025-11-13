# ---------- Stage 1: Composer ----------
FROM composer:2 AS vendor
WORKDIR /app

# Copy composer files
COPY composer.json ./

# Install dependencies and generate lock file
RUN composer update \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --no-progress \
    --no-scripts \
    --no-autoloader

# Copy application code
COPY . .

# Generate optimized autoloader
RUN composer dump-autoload --optimize --no-dev

# ---------- Stage 2: Runtime (Nginx + PHP-FPM in one) ----------
FROM webdevops/php-nginx:8.3-alpine

# 기본 설정
ENV WEB_DOCUMENT_ROOT=/app/public
ENV PHP_DISPLAY_ERRORS=0
ENV PHP_MEMORY_LIMIT=512M
ENV PHP_MAX_EXECUTION_TIME=60

# 필요한 PHP 확장 설치
RUN apk add --no-cache \
    php83-pdo \
    php83-pdo_sqlite \
    php83-sqlite3 \
    php83-session \
    php83-tokenizer \
    php83-xml \
    php83-xmlwriter \
    php83-fileinfo \
    php83-intl \
    php83-bcmath \
    php83-opcache \
    php83-mbstring \
    php83-curl \
    curl

# 앱 복사
WORKDIR /app
COPY --from=vendor /app /app

# Custom Nginx configuration
COPY nginx.conf /opt/docker/etc/nginx/vhost.conf

# 필요한 디렉토리 생성
RUN mkdir -p \
    /app/storage/framework/cache \
    /app/storage/framework/sessions \
    /app/storage/framework/views \
    /app/storage/logs \
    /app/bootstrap/cache \
    /app/database \
    /app/writable

# 퍼미션 설정
RUN chown -R application:application /app \
 && chmod -R 775 /app/storage /app/bootstrap/cache /app/database /app/writable

# SQLite 데이터베이스 생성
RUN touch /app/database/database.sqlite \
 && chown application:application /app/database/database.sqlite \
 && chmod 664 /app/database/database.sqlite

# Laravel 환경 변수 설정
ENV APP_ENV=production
ENV APP_DEBUG=false
ENV LOG_CHANNEL=stderr

# 기본 CMD는 이미지에서 Nginx+PHP-FPM가 함께 기동됨
