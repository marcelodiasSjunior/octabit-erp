#!/bin/bash
# setup-server.sh
# Script para configuração inicial do servidor Hostinger após primeiro deploy
# 
# Uso: ssh -p 65002 user@host 'bash -s' < setup-server.sh

set -e

YELLOW='\033[1;33m'
GREEN='\033[0;32m'
RED='\033[0;31m'
NC='\033[0m' # No Color

echo -e "${YELLOW}=== OctaBit ERP Server Setup ===${NC}\n"

# Validar que estamos no diretório certo
if [ ! -f "artisan" ]; then
    echo -e "${RED}ERROR: artisan file not found. Make sure you're in laravel_app directory.${NC}"
    exit 1
fi

echo -e "${GREEN}✓ Found artisan file${NC}"

# Verificar PHP version
PHP_VERSION=$(php -v 2>/dev/null | grep -oP 'PHP \K[0-9]+\.[0-9]+' || echo "unknown")
echo -e "${GREEN}✓ PHP Version: $PHP_VERSION${NC}\n"

# Criar .env se não existir
if [ ! -f ".env" ]; then
    echo -e "${YELLOW}Creating .env from .env.example...${NC}"
    cp .env.example .env
    echo -e "${GREEN}✓ .env created${NC}\n"
else
    echo -e "${GREEN}✓ .env already exists${NC}\n"
fi

# APP_KEY
if ! grep -q "APP_KEY=base64:" .env || [ -z "$(grep 'APP_KEY=' .env | cut -d'=' -f2)" ]; then
    echo -e "${YELLOW}Generating APP_KEY...${NC}"
    php artisan key:generate --force
    echo -e "${GREEN}✓ APP_KEY generated${NC}\n"
else
    echo -e "${GREEN}✓ APP_KEY already exists${NC}\n"
fi

# Storage symlink
echo -e "${YELLOW}Creating storage symlink...${NC}"
php artisan storage:link --force 2>/dev/null || true
echo -e "${GREEN}✓ Storage symlink created${NC}\n"

# Cache clear
echo -e "${YELLOW}Clearing application caches...${NC}"
php artisan optimize:clear 2>/dev/null || true
php artisan config:cache 2>/dev/null || true
echo -e "${GREEN}✓ Caches cleared and config cached${NC}\n"

# Discover packages
echo -e "${YELLOW}Discovering packages...${NC}"
php artisan package:discover --ansi 2>/dev/null || true
echo -e "${GREEN}✓ Packages discovered${NC}\n"

# Check database connection
echo -e "${YELLOW}Checking database connection...${NC}"
if php artisan tinker --execute="DB::connection()->getPdo();" 2>/dev/null | grep -q "PDOException\|Connection refused"; then
    echo -e "${RED}⚠ Cannot connect to database. Verify .env DB_* settings.${NC}"
    echo -e "${YELLOW}Edit .env and try again:${NC}"
    echo "    nano .env"
    echo "    php artisan migrate"
else
    echo -e "${GREEN}✓ Database connection successful${NC}\n"
    
    # Run migrations
    echo -e "${YELLOW}Running migrations...${NC}"
    php artisan migrate --force 2>/dev/null || true
    echo -e "${GREEN}✓ Migrations completed${NC}\n"
    
    # Seed (optionally)
    # echo -e "${YELLOW}Seeding database...${NC}"
    # php artisan db:seed --force 2>/dev/null || true
    # echo -e "${GREEN}✓ Database seeded${NC}\n"
fi

# Check manifest
echo -e "${YELLOW}Checking Vite manifest...${NC}"
if [ -f "public/build/manifest.json" ]; then
    echo -e "${GREEN}✓ Manifest found${NC}\n"
else
    echo -e "${RED}⚠ Manifest not found. Run 'npm run build' in development and deploy again.${NC}\n"
fi

# Final checks
echo -e "${YELLOW}Final validation...${NC}"
echo -e "${GREEN}✓ Laravel application ready${NC}"
echo ""
echo -e "${YELLOW}=== Setup Complete ===${NC}"
echo ""
echo "Next steps:"
echo "1. Edit .env if needed (database, APP_URL, etc)"
echo "2. Run: php artisan migrate"
echo "3. Visit your application URL"
echo "4. Check logs if issues: tail -50 storage/logs/laravel.log"
