# Use PHP 8.4 CLI as base image
FROM php:8.4-cli

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    libpq-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath zip pdo_pgsql pgsql

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy existing application directory contents
COPY . /var/www/html

# Install application dependencies
RUN composer install --no-dev --optimize-autoloader

# Create empty .env file for key generation
RUN touch .env

# Generate application key
RUN php artisan key:generate --force

# Set permissions
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html/storage
RUN chmod -R 755 /var/www/html/bootstrap/cache

# Expose port 8080
EXPOSE 8080

# Create startup script
RUN echo '#!/bin/bash' > /start.sh && \
    echo 'echo "Starting Laravel on port 8080..."' >> /start.sh && \
    echo 'php artisan serve --host=0.0.0.0 --port=8080' >> /start.sh && \
    chmod +x /start.sh

# Start the application
CMD ["/start.sh"]
