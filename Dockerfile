# Use the official PHP image with Apache
FROM php:8.1-apache

# Install mysqli extension
RUN docker-php-ext-install mysqli

# Optional: Enable Apache rewrite module
RUN a2enmod rewrite

# Copy all files into Apache’s root directory
COPY . /var/www/html/

# Set correct permissions
RUN chown -R www-data:www-data /var/www/html
