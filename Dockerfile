FROM php:7.4-apache

# Install required PHP extensions
RUN docker-php-ext-install mysqli

# Enable Apache modules
RUN a2enmod rewrite

# Set ServerName to avoid the warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Copy custom VirtualHost configuration
COPY ./my-php.conf /etc/apache2/sites-available/000-default.conf

# Copy the .htaccess file to ensure rewrite rules are persistent
COPY ./html/.htaccess /var/www/html/.htaccess

# Expose port 80
EXPOSE 80

CMD ["apache2-foreground"]
