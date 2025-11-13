# Hostinger VPS Troubleshooting Guide

## Server Access Information
- **IP**: 72.61.118.53
- **Hostname**: srv1125520.hstgr.cloud
- **User**: root
- **Password**: @@Kgl835490

## Issue: Website Not Accessible After Docker Deploy

### Step 1: Access Server

#### Option A: Hostinger Web Terminal (Recommended)
1. Go to Hostinger dashboard
2. Click on your VPS
3. Click "Open Web Terminal" or "Access"
4. Login with root credentials

#### Option B: SSH from Windows PowerShell
```powershell
ssh root@72.61.118.53
# Enter password: @@Kgl835490
```

---

### Step 2: Run Diagnostic Script

```bash
# Download and run diagnostic
curl -sL https://raw.githubusercontent.com/abitraco/oncube_claude/main/diagnose-docker.sh | bash
```

OR manually check:

```bash
# Check Docker status
docker ps -a

# Check container logs
docker logs $(docker ps -a -q --filter name=oncube) --tail 50

# Check if web server responds locally
curl http://localhost
curl http://localhost:80

# Check ports
netstat -tlnp | grep -E ':(80|443)'

# Check firewall
ufw status
```

---

### Step 3: Common Issues & Fixes

#### Issue 1: Container Not Running
```bash
cd /opt
git clone https://github.com/abitraco/oncube_claude.git
cd oncube_claude
docker compose up -d --build
```

#### Issue 2: Port Conflict
```bash
# Find what's using port 80
netstat -tlnp | grep :80

# Kill the process or change docker-compose.yml port
docker compose down
# Edit docker-compose.yml to use port 8080:80
docker compose up -d
```

#### Issue 3: Firewall Blocking
```bash
# Allow HTTP/HTTPS
ufw allow 80/tcp
ufw allow 443/tcp
ufw reload
ufw status
```

#### Issue 4: .env File Missing
```bash
cd /opt/oncube_claude
cp .env.production .env

# Generate APP_KEY
docker compose exec oncube-app php artisan key:generate

# Or manually generate:
docker run --rm webdevops/php-nginx:8.3-alpine sh -c "php -r \"echo 'base64:' . base64_encode(random_bytes(32)) . PHP_EOL;\""
```

#### Issue 5: Permission Issues
```bash
cd /opt/oncube_claude
chmod -R 777 storage database writable
docker compose restart
```

#### Issue 6: Container Exiting Immediately
```bash
# Check logs for errors
docker compose logs -f

# Common fix: recreate container
docker compose down
docker compose up -d --force-recreate
```

---

### Step 4: Quick Fix (Nuclear Option)

```bash
# Stop everything
docker stop $(docker ps -aq)
docker rm $(docker ps -aq)

# Clean slate
cd /opt
rm -rf oncube_claude
git clone https://github.com/abitraco/oncube_claude.git
cd oncube_claude

# Create .env
cat > .env << 'EOF'
APP_NAME="ONCUBE GLOBAL"
APP_ENV=production
APP_KEY=base64:REPLACE_WITH_YOUR_KEY
APP_DEBUG=false
APP_URL=http://72.61.118.53
LOG_CHANNEL=stack
LOG_LEVEL=error
DB_CONNECTION=sqlite
DB_DATABASE=/app/database/database.sqlite
SESSION_DRIVER=file
SESSION_LIFETIME=120
EOF

# Create database
mkdir -p database
touch database/database.sqlite

# Build and run
docker compose up -d --build

# Wait and check
sleep 10
docker compose ps
docker compose logs
curl -I http://localhost
```

---

### Step 5: Verify Website is Working

```bash
# Test locally on server
curl http://localhost
curl http://localhost/en/home

# Check from outside
curl http://72.61.118.53
```

Then open in browser:
- http://72.61.118.53
- http://72.61.118.53/en/home
- http://72.61.118.53/ko/home

---

### Step 6: If Still Not Working

**Get detailed logs:**
```bash
# Container logs
docker compose logs --tail 100

# Laravel logs (if container is running)
docker compose exec oncube-app cat /app/storage/logs/laravel.log

# Check if Apache/Nginx is running inside container
docker compose exec oncube-app ps aux

# Test PHP
docker compose exec oncube-app php -v
```

**Check Docker Compose file:**
```bash
cd /opt/oncube_claude
cat docker-compose.yml
```

Should show:
- Port mapping: `80:80`
- No `version:` line
- Service name: `oncube-app`

---

### Useful Commands Reference

```bash
# Start/Stop/Restart
docker compose up -d
docker compose down
docker compose restart

# View logs
docker compose logs -f
docker compose logs --tail 50

# Execute commands inside container
docker compose exec oncube-app php artisan config:cache
docker compose exec oncube-app php artisan route:list

# Check status
docker compose ps
docker stats

# Rebuild
docker compose up -d --build --force-recreate

# Remove everything
docker compose down -v
docker system prune -a
```

---

### Emergency Contact

If nothing works, provide this information:
1. Output of: `docker compose ps`
2. Output of: `docker compose logs --tail 50`
3. Output of: `curl -v http://localhost`
4. Output of: `netstat -tlnp | grep 80`

---

## Hostinger-Specific Notes

- Docker Manager path: Usually `/tmp/hstgr-*-dckr-mgr/`
- To see Docker Manager deployments: `docker compose ls`
- Dashboard URL: https://hpanel.hostinger.com/vps
