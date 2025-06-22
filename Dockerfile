# Use official PHP-Apache image (includes Apache pre-installed)
FROM php:8.2-apache

# Install PHP extensions required (mysqli)
RUN docker-php-ext-install mysqli

# Enable Apache rewrite module if your app uses .htaccess
RUN a2enmod rewrite

# Set the working directory
WORKDIR /var/www/html

# Copy all project files into container
COPY . /var/www/html/

# Fix permissions (optional, improves security)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose the default web port (required by Render)
EXPOSE 80
