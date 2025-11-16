# DEPLOYMENT.md

This file contains deployment instructions and server configuration for ONCUBE GLOBAL.

## Server Information

**Hostinger VPS**
- IP: 72.61.118.53
- User: root
- Password: @@@Kgl835490 (legacy, use SSH key instead)
- Domain: oncube.cloud

## SSH Key Authentication

### Local SSH Key
- Location: `C:\Users\chance\.ssh\id_ed25519`
- Public Key: `ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIMnozzGE7s5obHfT+JCVgGDixARj+cbmPmiOhaF5VcLo chance@abitra.co`

### Server Setup (One-time)

1. **Add SSH public key to server** (if not already done):
```bash
ssh root@72.61.118.53
mkdir -p ~/.ssh
chmod 700 ~/.ssh
echo "ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIMnozzGE7s5obHfT+JCVgGDixARj+cbmPmiOhaF5VcLo chance@abitra.co" >> ~/.ssh/authorized_keys
chmod 600 ~/.ssh/authorized_keys
```

2. **Test SSH key authentication**:
```bash
ssh -i C:\Users\chance\.ssh\id_ed25519 root@72.61.118.53
```

### Windows SSH Config (Optional)

Create or edit `C:\Users\chance\.ssh\config`:
```
Host oncube-vps
    HostName 72.61.118.53
    User root
    IdentityFile C:\Users\chance\.ssh\id_ed25519
    ServerAliveInterval 60
    ServerAliveCountMax 3
```

After this setup, you can simply use:
```bash
ssh oncube-vps
```

## Deployment Process

### Quick Deployment (CSS/JS/View changes only)

For static files and template changes that don't require Docker rebuild:

```bash
ssh root@72.61.118.53 "cd /root/oncube_claude && git pull origin main"
```

### Full Deployment (Code/Config changes)

For PHP code, dependencies, or Dockerfile changes:

```bash
# Pull latest code and rebuild containers
ssh root@72.61.118.53 "cd /root/oncube_claude && git pull origin main && docker compose down && docker compose up -d --build"
```

### One-line Deployment Script

```bash
# Quick deploy (no rebuild)
ssh root@72.61.118.53 "cd /root/oncube_claude && git pull origin main && docker compose restart"

# Full deploy (with rebuild)
ssh root@72.61.118.53 "cd /root/oncube_claude && git pull origin main && docker compose down && docker compose up -d --build"
```

## Common Deployment Tasks

### 1. Deploy Latest Changes
```bash
cd c:\Users\chance\Downloads\DEV_LOCAL\oncube_claude
git add .
git commit -m "Your commit message"
git push origin main
ssh root@72.61.118.53 "cd /root/oncube_claude && git pull origin main && docker compose restart"
```

### 2. Run Database Migrations
```bash
ssh root@72.61.118.53 "cd /root/oncube_claude && docker compose exec -T oncube-app php artisan migrate --force"
```

### 3. Clear Cache
```bash
ssh root@72.61.118.53 "cd /root/oncube_claude && docker compose exec -T oncube-app php artisan cache:clear"
```

### 4. View Logs
```bash
ssh root@72.61.118.53 "cd /root/oncube_claude && docker compose logs oncube-app --tail 50 -f"
```

### 5. Check Container Status
```bash
ssh root@72.61.118.53 "cd /root/oncube_claude && docker compose ps"
```

### 6. Restart Containers
```bash
ssh root@72.61.118.53 "cd /root/oncube_claude && docker compose restart"
```

## Docker Architecture

**Container Name**: oncube-web
**Image**: oncube_claude-oncube-app
**Base**: webdevops/php-nginx:8.3-alpine
**Ports**:
- 80 (HTTP)
- 443 (HTTPS)

**Volumes**:
- SSL certificates: `/etc/letsencrypt` → `/etc/letsencrypt`

**Environment Variables**:
- Set in `.env` file on server
- Required: `APP_ENV`, `APP_KEY`, `EBAY_CLIENT_ID`, `EBAY_CLIENT_SECRET`, `ADMIN_PASSWORD`

## Database

**Type**: SQLite
**Location**: `/app/database/database.sqlite` (inside container)
**Backup**: Included in git repository storage folder

## SSL/HTTPS

Certificates are managed outside Docker via Let's Encrypt:
- Certificate location: `/etc/letsencrypt/live/oncube.cloud/`
- Auto-renewal: Configured on host system

## Troubleshooting

### Site returns 500 error
```bash
# Check logs
ssh root@72.61.118.53 "cd /root/oncube_claude && docker compose logs oncube-app --tail 100"

# Check if migrations are needed
ssh root@72.61.118.53 "cd /root/oncube_claude && docker compose exec -T oncube-app php artisan migrate:status"
```

### Images not showing
```bash
# Verify storage link exists
ssh root@72.61.118.53 "cd /root/oncube_claude && docker compose exec -T oncube-app ls -la /app/public/storage"

# Recreate storage link if needed
ssh root@72.61.118.53 "cd /root/oncube_claude && docker compose exec -T oncube-app php artisan storage:link"
```

### Docker container won't start
```bash
# Check container logs
ssh root@72.61.118.53 "cd /root/oncube_claude && docker compose logs oncube-app"

# Rebuild from scratch
ssh root@72.61.118.53 "cd /root/oncube_claude && docker compose down && docker compose up -d --build --no-cache"
```

## Automated Deployment Commands for Claude

When deploying to production, Claude should use these commands:

**Standard deployment**:
```bash
ssh root@72.61.118.53 "cd /root/oncube_claude && git pull origin main && docker compose restart"
```

**Full rebuild deployment**:
```bash
ssh root@72.61.118.53 "cd /root/oncube_claude && git pull origin main && docker compose down && docker compose up -d --build"
```

**Health check**:
```bash
curl -s -o /dev/null -w "%{http_code}" https://oncube.cloud/health
```

## File Locations on Server

- Application: `/root/oncube_claude`
- Nginx config: `/root/oncube_claude/nginx.conf`
- Environment: `/root/oncube_claude/.env`
- Logs: `docker compose logs`
- SSL certs: `/etc/letsencrypt/live/oncube.cloud/`

## Git Workflow

1. **Local development**:
   - Work on: `https://oncube_claude.test/` (Laravel Herd)
   - Branch: `main`

2. **Commit changes**:
   ```bash
   git add .
   git commit -m "Description"
   git push origin main
   ```

3. **Deploy to production**:
   ```bash
   ssh root@72.61.118.53 "cd /root/oncube_claude && git pull origin main && docker compose restart"
   ```

## Important Notes

- **Always test locally first** before deploying to production
- **Database changes** require running migrations after deployment
- **Dockerfile changes** require full rebuild (use `--build` flag)
- **Static files** (CSS/JS) are cached - do hard refresh to see changes
- **SSH key** is preferred over password authentication for security

## Emergency Rollback

If deployment fails, rollback to previous commit:

```bash
ssh root@72.61.118.53 "cd /root/oncube_claude && git log --oneline -5"
# Note the previous commit hash
ssh root@72.61.118.53 "cd /root/oncube_claude && git reset --hard <commit-hash> && docker compose restart"
```
