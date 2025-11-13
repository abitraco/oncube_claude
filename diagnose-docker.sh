#!/bin/bash
# Hostinger VPS Docker Service Diagnostic Script
# Run this on your VPS server

echo "=========================================="
echo "ONCUBE GLOBAL - Docker Service Diagnostics"
echo "=========================================="
echo ""

# 1. Check if Docker is running
echo "1. Checking Docker service status..."
systemctl status docker --no-pager | head -20
echo ""

# 2. List all containers
echo "2. Listing all Docker containers..."
docker ps -a
echo ""

# 3. Check Docker Compose status
echo "3. Checking Docker Compose projects..."
docker compose ls
echo ""

# 4. Check container logs (if container exists)
echo "4. Checking container logs..."
if docker ps -a | grep -q oncube; then
    echo "Found ONCUBE container. Showing logs:"
    docker logs --tail 50 $(docker ps -a | grep oncube | awk '{print $1}')
else
    echo "No ONCUBE container found."
    echo "Checking all running containers:"
    docker ps
fi
echo ""

# 5. Check ports
echo "5. Checking open ports..."
netstat -tlnp | grep -E ':(80|443|8000)\s'
echo ""

# 6. Check if port 80/443 is accessible
echo "6. Testing web server locally..."
curl -I http://localhost 2>&1 | head -10
echo ""

# 7. Check firewall rules
echo "7. Checking firewall rules..."
if command -v ufw &> /dev/null; then
    ufw status
elif command -v iptables &> /dev/null; then
    iptables -L -n | grep -E '(80|443)'
fi
echo ""

# 8. Check disk space
echo "8. Checking disk space..."
df -h | grep -E '(Filesystem|/$|/var)'
echo ""

# 9. Check Docker networks
echo "9. Checking Docker networks..."
docker network ls
echo ""

# 10. Check if project directory exists
echo "10. Checking project directories..."
ls -la /opt/oncube_claude/ 2>/dev/null || echo "Project not in /opt/oncube_claude"
ls -la /tmp/hstgr-*-dckr-mgr/ 2>/dev/null | head -20 || echo "No Hostinger Docker Manager temp dirs"
echo ""

echo "=========================================="
echo "Diagnostic complete!"
echo "=========================================="
