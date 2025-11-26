FROM php:8.2-cli

# Install dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    git \
    curl

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy existing application directory contents
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Generate key (optional sa build, pero good practice)
RUN php artisan key:generate

# Expose port 10000 (Standard port ni Render)
EXPOSE 10000

# Start the application
CMD php artisan serve --host=0.0.0.0 --port=10000