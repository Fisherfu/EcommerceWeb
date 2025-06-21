#Use PHP 8.2 with Apache
FROM php:8.2-apache

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && docker-php-ext-install mysqli

# Copy app source code
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html/

# Set permissions (optional)
RUN chown -R www-data:www-data /var/www/html/

# Expose Apache port
EXPOSE 80
