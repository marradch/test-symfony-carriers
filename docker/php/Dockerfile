FROM php:8.3-fpm

WORKDIR /var/www/backend

RUN apt-get update && apt-get install -y \
    git unzip curl libpq-dev libzip-dev \
    libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-install pdo_pgsql zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
