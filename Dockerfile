# Use official PHP with Apache image
FROM php:8.1-apache

# Install mysqli extension
RUN docker-php-ext-install mysqli

# Copy all your code to Apache's root directory
COPY . /var/www/html/

# Enable Apache rewrite module if needed
RUN a2enmod rewrite
