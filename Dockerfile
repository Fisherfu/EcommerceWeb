

# Dockerfile for PHP + Apache + MySQLi
FROM php:8.2-apache

# Enable Apache mod_rewrite
RUN a2enmod rewrite

RUN docker-php-ext-install mysqli

# Install mysqli extension
RUN docker-php-ext-install mysqli

# Copy project files to Apache document root
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html/

# Fix permissions (optional)
RUN chown -R www-data:www-data /var/www/html/

# Expose port 80
EXPOSE 80
