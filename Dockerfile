FROM php:8.2-apache

# Install mysqli extension
RUN docker-php-ext-install mysqli

# Copy source files to Apache root
COPY . /var/www/html/

# Set correct permissions
RUN chown -R www-data:www-data /var/www/html

# Enable Apache rewrite module if needed
RUN a2enmod rewrite
