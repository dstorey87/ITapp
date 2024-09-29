# Use the official PHP image with Apache
FROM php:7.4-apache

# Install any required extensions or libraries
RUN apt-get update && apt-get install -y \
    curl \
    libpng-dev \
    mariadb-client \
    && docker-php-ext-install pdo pdo_mysql gd

# Enable Apache's mod_rewrite for SEO-friendly URLs or pretty URLs
RUN a2enmod rewrite

# Copy your custom Apache configuration
COPY ./my-php.conf /etc/apache2/sites-available/000-default.conf

# Copy your application files into the container
COPY ./html/ /var/www/html/

# Set permissions for the web server to access the files
RUN chown -R www-data:www-data /var/www/html

# Expose port 80 to make the web server accessible
EXPOSE 80
