# ONCUBE GLOBAL - Hostinger VPS Deployment Guide

## Server Information
- **Hostname**: srv1125520.hstgr.cloud
- **IPv4**: 72.61.118.53
- **IPv6**: 2a02:4780:5e:1e1b::1
- **SSH User**: root

## Quick Deployment via Hostinger Docker Manager

### 1. Docker Manager Setup
In Hostinger Dashboard > Docker Manager:
- **Compose URL**: `https://github.com/abitraco/oncube_claude`
- The system will automatically detect and use `docker-compose.yml`

### 2. Environment Variables (Set in Docker Manager UI)
```
APP_KEY=base64:YOUR_GENERATED_APP_KEY
EBAY_CLIENT_ID=your_ebay_client_id
EBAY_CLIENT_SECRET=your_ebay_client_secret
EBAY_LEGACY_APP_ID=your_ebay_legacy_app_id
```

### 3. After Deployment
The website will be available at:
- **HTTP**: http://72.61.118.53
- **HTTPS**: Configure SSL certificate (see below)

---

## Manual SSH Deployment (Alternative)

### Step 1: Connect to VPS
```bash
ssh root@72.61.118.53
```

### Step 2: Clone Repository
```bash
cd /opt
git clone https://github.com/abitraco/oncube_claude.git
cd oncube_claude
```

### Step 3: Create .env File
```bash
cp .env.production .env
nano .env
```

Update these values:
- `APP_KEY` - Generate with: `php artisan key:generate --show`
- `EBAY_CLIENT_ID`, `EBAY_CLIENT_SECRET`, `EBAY_LEGACY_APP_ID`

### Step 4: Create Database
```bash
mkdir -p database
touch database/database.sqlite
chmod 664 database/database.sqlite
```

### Step 5: Build and Run
```bash
docker compose up -d --build
```

### Step 6: Check Status
```bash
docker compose ps
docker compose logs -f
```

---

## SSL Certificate Setup (Let's Encrypt)

### Option 1: Using Certbot with Nginx Proxy
```bash
# Install Certbot
apt update && apt install -y certbot

# Stop container temporarily
docker compose down

# Get certificate (replace with your domain)
certbot certonly --standalone -d yourdomain.com -d www.yourdomain.com

# Update docker-compose.yml to mount certificates
# Restart container
docker compose up -d
```

### Option 2: Using Cloudflare (Recommended)
1. Add domain to Cloudflare
2. Point A record to: 72.61.118.53
3. Enable Cloudflare proxy (orange cloud)
4. SSL/TLS mode: Full (or Flexible)

---

## Useful Commands

### View Logs
```bash
docker compose logs -f oncube-app
```

### Restart Container
```bash
docker compose restart
```

### Update Code
```bash
git pull origin main
docker compose up -d --build
```

### Clear Cache
```bash
docker compose exec oncube-app php artisan cache:clear
docker compose exec oncube-app php artisan config:clear
docker compose exec oncube-app php artisan route:clear
docker compose exec oncube-app php artisan view:clear
```

### Database Backup
```bash
docker compose exec oncube-app tar czf /tmp/backup.tar.gz /app/database /app/storage
docker cp oncube-web:/tmp/backup.tar.gz ./backup-$(date +%Y%m%d).tar.gz
```

---

## Firewall Configuration

```bash
# Allow HTTP/HTTPS
ufw allow 80/tcp
ufw allow 443/tcp
ufw allow 22/tcp
ufw enable
```

---

## Monitoring

### Check Container Health
```bash
docker compose ps
docker stats oncube-web
```

### Check Disk Space
```bash
df -h
docker system df
```

### Clean Up Docker
```bash
docker system prune -a --volumes
```

---

## Troubleshooting

### Container won't start
```bash
docker compose logs oncube-app
docker compose down
docker compose up -d --build
```

### Permission issues
```bash
docker compose exec oncube-app chown -R application:application /app/storage /app/database
docker compose exec oncube-app chmod -R 775 /app/storage /app/database
```

### Website shows 500 error
```bash
docker compose exec oncube-app php artisan config:cache
docker compose exec oncube-app php artisan route:cache
docker compose logs -f oncube-app
```

---

## Performance Optimization

### Enable OPcache (Already configured in Dockerfile)
Check status:
```bash
docker compose exec oncube-app php -i | grep opcache
```

### Database Optimization
```bash
docker compose exec oncube-app php artisan optimize
```

---

## Support
For issues, check:
1. Docker logs: `docker compose logs -f`
2. Laravel logs: `docker compose exec oncube-app cat /app/storage/logs/laravel.log`
3. GitHub Issues: https://github.com/abitraco/oncube_claude/issues
