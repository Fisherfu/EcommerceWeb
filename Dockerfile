# Use official PHP + Apache image
FROM php:7.4-apache

# Enable Apache mod_rewrite (optional, for .htaccess)
RUN a2enmod rewrite

# Copy project files into web root
COPY . /var/www/html/

# Set proper permissions (optional)
RUN chown -R www-data:www-data /var/www/html

# Expose port for Render (Render maps it to 10000)
EXPOSE 80
