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

# Copy .env.example to .env
RUN cp .env.example .env

# Create production .env file with correct values
RUN echo "APP_ENV=production" > .env && \
    echo "APP_DEBUG=true" >> .env && \
    echo "APP_URL=https://bibliotheque-q26z.onrender.com" >> .env && \
    echo "APP_KEY=base64:BVuzj3q+sdFImlKKMXCBiM8lHD5xUrFpArR21VpFZCc=" >> .env && \
    echo "DB_CONNECTION=pgsql" >> .env && \
    echo "DB_HOST=ozsecivdrtwbrfjagwph.supabase.co" >> .env && \
    echo "DB_PORT=6543" >> .env && \
    echo "DB_DATABASE=postgres" >> .env && \
    echo "DB_USERNAME=postgres" >> .env && \
    echo "DB_PASSWORD=r%D.FaNQBdjRa@8" >> .env && \
    echo "DB_SSLMODE=require" >> .env && \
    echo "LOG_CHANNEL=stack" >> .env && \
    echo "SESSION_DRIVER=database" >> .env && \
    echo "SESSION_LIFETIME=120" >> .env

# Install application dependencies
RUN composer install --no-dev --optimize-autoloader

# Generate application key
RUN php artisan key:generate --force

# Set permissions
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html/storage
RUN chmod -R 755 /var/www/html/bootstrap/cache

# Expose port 80 and start PHP development server
EXPOSE 80

# Start PHP development server on port 80
CMD php artisan serve --host=0.0.0.0 --port=80 --verbose
