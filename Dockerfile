# Use the official PHP image with Apache
FROM php:7.2-apache

# Enable mod_rewrite for Apache
RUN a2enmod rewrite

# Install mysqli extension
RUN docker-php-ext-install mysqli

# Copy project files into the container
COPY . /var/www/html/

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Set permissions for the web directory
RUN chown -R www-data:www-data /var/www/html

# Expose port 80 for the web server
EXPOSE 80

# Run Apache in the foreground
CMD ["apache2-foreground"]
