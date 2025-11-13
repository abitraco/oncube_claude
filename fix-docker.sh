#!/bin/bash
# Hostinger VPS Docker Quick Fix Script

echo "=========================================="
echo "ONCUBE GLOBAL - Docker Quick Fix"
echo "=========================================="
echo ""

# Navigate to project directory
cd /opt || cd /tmp/hstgr-*-dckr-mgr 2>/dev/null

echo "1. Stopping any existing containers..."
docker compose down 2>/dev/null
docker stop $(docker ps -aq) 2>/dev/null
echo ""

echo "2. Checking if repository exists..."
if [ ! -d "oncube_claude" ]; then
    echo "Cloning repository..."
    git clone https://github.com/abitraco/oncube_claude.git
    cd oncube_claude
else
    echo "Repository exists, pulling latest changes..."
    cd oncube_claude
    git pull origin main
fi
echo ""

echo "3. Creating .env file if missing..."
if [ ! -f .env ]; then
    cat > .env << 'EOF'
APP_NAME="ONCUBE GLOBAL"
APP_ENV=production
APP_KEY=base64:REPLACE_WITH_GENERATED_KEY
APP_DEBUG=false
APP_URL=http://72.61.118.53

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=sqlite
DB_DATABASE=/app/database/database.sqlite

SESSION_DRIVER=file
SESSION_LIFETIME=120

EBAY_CLIENT_ID=
EBAY_CLIENT_SECRET=
EBAY_LEGACY_APP_ID=
EOF
    echo ".env file created. IMPORTANT: Update APP_KEY and eBay credentials!"
else
    echo ".env file already exists."
fi
echo ""

echo "4. Creating database directory..."
mkdir -p database
touch database/database.sqlite
chmod 666 database/database.sqlite
echo ""

echo "5. Building and starting Docker container..."
docker compose up -d --build
echo ""

echo "6. Waiting for container to start..."
sleep 5
echo ""

echo "7. Checking container status..."
docker compose ps
echo ""

echo "8. Showing container logs..."
docker compose logs --tail 30
echo ""

echo "9. Testing local web server..."
sleep 3
curl -I http://localhost 2>&1 | head -5
echo ""

echo "=========================================="
echo "Setup Complete!"
echo ""
echo "Next steps:"
echo "1. Update .env file with proper APP_KEY"
echo "   Generate key: docker compose exec oncube-app php artisan key:generate --show"
echo ""
echo "2. Open firewall ports (if needed):"
echo "   ufw allow 80/tcp"
echo "   ufw allow 443/tcp"
echo ""
echo "3. Test website:"
echo "   http://72.61.118.53"
echo "=========================================="
