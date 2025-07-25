FROM php:8.2-fpm

# Instala dependências
RUN apt-get update && apt-get install -y \
    git zip unzip libzip-dev libpng-dev libonig-dev libxml2-dev curl \
    && docker-php-ext-install pdo pdo_mysql zip mbstring exif pcntl bcmath

# Instala Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copia e instala dependências PHP
COPY backend /var/www
RUN composer install

# Garante permissões corretas
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage
