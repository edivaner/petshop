FROM php:8.3-fpm

# Instala dependências do sistema
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    curl \
    git \
    libzip-dev \
    libpq-dev \
    libfreetype6-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install

EXPOSE 9000
CMD ["php-fpm"]

# # Copiando configuracoes do INI do Xdebug caminho INI: /usr/local/etc/php/conf.d/xdebug.ini
# COPY ./docker/php/xdebug.ini "${PHP_INI_DIR}/conf.d/xdebug.ini"

# # Install xdebug
# RUN pecl install xdebug && docker-php-ext-enable xdebug