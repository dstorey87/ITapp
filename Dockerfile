FROM php:7.4-apache

# Install required PHP extensions
RUN docker-php-ext-install mysqli

# Enable the mysqli extension
RUN docker-php-ext-enable mysqli

# Copy your php.ini if you have one (uncomment and adjust the path if needed)
# COPY path/to/your/php.ini /usr/local/etc/php/

# Make sure the document root is set properly
WORKDIR /var/www/html
