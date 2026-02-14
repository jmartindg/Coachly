# syntax=docker/dockerfile:1
# Build stage: frontend assets with Vite
FROM node:20-alpine AS frontend
WORKDIR /app
COPY package.json package-lock.json* ./
RUN npm ci
COPY . .
RUN npm run build

# Build stage: PHP dependencies
FROM composer:2 AS composer
WORKDIR /app
COPY . .
RUN composer install --no-dev --optimize-autoloader

# Production stage: nginx + PHP-FPM
FROM richarvey/nginx-php-fpm:3.1.6

COPY --from=composer /app /var/www/html
COPY --from=frontend /app/public/build /var/www/html/public/build

# Image config
ENV SKIP_COMPOSER=1
ENV WEBROOT=/var/www/html/public
ENV PHP_ERRORS_STDERR=1
ENV RUN_SCRIPTS=1
ENV REAL_IP_HEADER=1

# Laravel config
ENV APP_ENV=production
ENV APP_DEBUG=false
ENV LOG_CHANNEL=stderr
ENV COMPOSER_ALLOW_SUPERUSER=1

CMD ["/start.sh"]
