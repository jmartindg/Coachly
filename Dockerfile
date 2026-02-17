FROM composer:2 AS vendor

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --no-interaction \
    --no-progress \
    --prefer-dist \
    --optimize-autoloader \
    --no-scripts


FROM node:22-alpine AS assets

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci

COPY resources ./resources
COPY public ./public
COPY vite.config.js ./
RUN npm run build


FROM php:8.4-cli-alpine

WORKDIR /var/www/html

RUN apk add --no-cache icu-dev oniguruma-dev sqlite-dev postgresql-dev \
    && docker-php-ext-install intl mbstring pdo pdo_mysql pdo_sqlite pdo_pgsql

COPY . .
COPY --from=vendor /app/vendor ./vendor
COPY --from=assets /app/public/build ./public/build

RUN mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache database \
    && chown -R nobody:nogroup storage bootstrap/cache \
    && chmod -R ug+rwx storage bootstrap/cache

ENV APP_ENV=production
ENV APP_DEBUG=false
ENV LOG_CHANNEL=stderr

EXPOSE 10000

CMD ["sh", "-c", "touch database/database.sqlite && php artisan migrate --force && php artisan icons:cache --no-interaction && php artisan serve --host=0.0.0.0 --port=${PORT:-10000}"]
