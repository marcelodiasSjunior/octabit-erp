#!/usr/bin/env bash
set -e

echo "╔══════════════════════════════════════╗"
echo "║      OctaBit ERP — Setup Script      ║"
echo "╚══════════════════════════════════════╝"
echo ""

# Copy .env if not present
if [ ! -f .env ]; then
    cp .env.example .env
    echo "✓ .env criado a partir de .env.example"
fi

# Install PHP dependencies
echo "→ Instalando dependências PHP..."
composer install

# Generate app key
echo "→ Gerando APP_KEY..."
php artisan key:generate

# Run migrations
echo "→ Executando migrations..."
php artisan migrate --force

# Seed initial data
echo "→ Inserindo dados iniciais..."
php artisan db:seed --force

echo ""
echo "╔══════════════════════════════════════╗"
echo "║  Setup concluído! Acesse o sistema:  ║"
echo "║  http://localhost:8080               ║"
echo "║                                      ║"
echo "║  Usuário: admin@octabit.tech         ║"
echo "║  Senha:   password                   ║"
echo "╚══════════════════════════════════════╝"
