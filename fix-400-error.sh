#!/bin/bash
# Fix 400 Bad Request Error for ONCUBE GLOBAL

echo "=========================================="
echo "Fixing 400 Bad Request Error"
echo "=========================================="
echo ""

# Find the docker compose directory
if [ -d "/tmp/hstgr-"*"-dckr-mgr" ]; then
    cd /tmp/hstgr-*-dckr-mgr/
    echo "Found Hostinger Docker Manager directory"
elif [ -d "/opt/oncube_claude" ]; then
    cd /opt/oncube_claude
    echo "Found /opt/oncube_claude directory"
else
    echo "Project directory not found!"
    exit 1
fi

echo "Current directory: $(pwd)"
echo ""

# Check current container status
echo "1. Current container status:"
docker compose ps
echo ""

# Check logs for errors
echo "2. Recent container logs:"
docker compose logs --tail 20
echo ""

# Common 400 Bad Request fixes
echo "3. Applying fixes..."

# Fix 1: Ensure APP_KEY is set
echo "Checking .env file..."
if [ ! -f .env ]; then
    echo "Creating .env file..."
    cat > .env << 'EOF'
APP_NAME="ONCUBE GLOBAL"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=http://72.61.118.53

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=sqlite
DB_DATABASE=/app/database/database.sqlite

SESSION_DRIVER=file
SESSION_LIFETIME=120
SESSION_SECURE_COOKIE=false
SESSION_SAME_SITE=lax

EBAY_CLIENT_ID=
EBAY_CLIENT_SECRET=
EBAY_LEGACY_APP_ID=
EOF
fi

# Generate APP_KEY if missing
if grep -q "APP_KEY=$" .env || grep -q "APP_KEY=base64:placeholder" .env; then
    echo "Generating APP_KEY..."
    NEW_KEY=$(docker compose exec -T oncube-app php artisan key:generate --show 2>/dev/null)
    if [ -z "$NEW_KEY" ]; then
        # Container might not be running, generate key differently
        NEW_KEY="base64:$(openssl rand -base64 32)"
    fi
    sed -i "s|APP_KEY=.*|APP_KEY=$NEW_KEY|g" .env
    echo "APP_KEY generated: $NEW_KEY"
fi
echo ""

# Fix 2: Clear all Laravel caches
echo "4. Clearing Laravel caches..."
docker compose exec -T oncube-app php artisan config:clear 2>/dev/null
docker compose exec -T oncube-app php artisan cache:clear 2>/dev/null
docker compose exec -T oncube-app php artisan route:clear 2>/dev/null
docker compose exec -T oncube-app php artisan view:clear 2>/dev/null
echo ""

# Fix 3: Fix file permissions
echo "5. Fixing file permissions..."
docker compose exec -T oncube-app chown -R application:application /app/storage /app/database /app/writable 2>/dev/null
docker compose exec -T oncube-app chmod -R 775 /app/storage /app/database /app/writable 2>/dev/null
echo ""

# Fix 4: Restart container
echo "6. Restarting container..."
docker compose restart
echo ""

# Wait for container to be ready
echo "7. Waiting for container to start..."
sleep 5
echo ""

# Fix 5: Rebuild cache
echo "8. Rebuilding Laravel cache..."
docker compose exec -T oncube-app php artisan config:cache 2>/dev/null
docker compose exec -T oncube-app php artisan route:cache 2>/dev/null
echo ""

# Test the web server
echo "9. Testing web server..."
sleep 3
HTTP_CODE=$(curl -s -o /dev/null -w "%{http_code}" http://localhost)
echo "HTTP Response Code: $HTTP_CODE"

if [ "$HTTP_CODE" = "200" ]; then
    echo "✓ Success! Web server is responding correctly."
elif [ "$HTTP_CODE" = "500" ]; then
    echo "✗ Still getting 500 error. Check logs below."
elif [ "$HTTP_CODE" = "400" ]; then
    echo "✗ Still getting 400 error. May need manual configuration."
else
    echo "✗ Unexpected response: $HTTP_CODE"
fi
echo ""

# Show recent logs
echo "10. Recent logs after restart:"
docker compose logs --tail 30
echo ""

echo "=========================================="
echo "Diagnostic URLs:"
echo "  http://72.61.118.53"
echo "  http://72.61.118.53/en/home"
echo ""
echo "If still not working, check:"
echo "  1. docker compose logs -f"
echo "  2. docker compose exec oncube-app cat /app/storage/logs/laravel.log"
echo "=========================================="
