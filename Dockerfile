FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Copy existing application directory contents
COPY . /var/www

# Set permissions
RUN chown -R www-data:www-data /var/www

# Laravel environment setup
RUN composer install --no-interaction --prefer-dist --optimize-autoloader && \
    php artisan key:generate && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache
