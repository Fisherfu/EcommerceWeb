

# Use the official PHP image with Apache
FROM php:8.2-apache

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy project files to Apache document root
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html/

# Set permissions (optional)
RUN chown -R www-data:www-data /var/www/html/

# Expose port 80
EXPOSE 80