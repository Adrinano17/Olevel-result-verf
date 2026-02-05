#!/bin/bash

echo "========================================"
echo "O-Level Result Verification System Setup"
echo "========================================"
echo ""

echo "[1/6] Installing PHP dependencies..."
composer install
if [ $? -ne 0 ]; then
    echo "ERROR: Composer install failed!"
    exit 1
fi
echo ""

echo "[2/6] Checking .env file..."
if [ ! -f .env ]; then
    echo "Creating .env file from .env.example..."
    cp .env.example .env
    echo ""
    echo "IMPORTANT: Please edit .env file and configure:"
    echo "  - Database credentials"
    echo "  - API keys"
    echo "  - Other settings"
    echo ""
    read -p "Press enter to continue..."
else
    echo ".env file already exists."
fi
echo ""

echo "[3/6] Generating application key..."
php artisan key:generate
echo ""

echo "[4/6] Creating storage link..."
php artisan storage:link
echo ""

echo "[5/6] Installing frontend dependencies..."
npm install
echo ""

echo "[6/6] Setup complete!"
echo ""
echo "NEXT STEPS:"
echo "1. Edit .env file with your database credentials"
echo "2. Create your database: CREATE DATABASE olevel_verification;"
echo "3. Run migrations: php artisan migrate"
echo "4. Start server: php artisan serve"
echo ""
echo "For detailed instructions, see QUICK_START.md"
echo ""




