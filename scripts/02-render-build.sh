#!/bin/bash
set -e

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Caching views..."
php artisan view:cache

echo "Running migrations..."
php artisan migrate --force

echo "Creating storage link..."
php artisan storage:link 2>/dev/null || true
