FROM php:8.2-cli

# 1. Install dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    libpq-dev 

# 2. Install PHP Extensions
RUN docker-php-ext-install pdo pdo_pgsql zip

# 3. Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. Set working directory
WORKDIR /var/www

# 5. Copy files
COPY . .

# --- ITO ANG IMPORTANTE: Gumawa ng .env file bago mag-install ---
RUN cp .env.example .env

# 6. Install Laravel libraries
RUN composer install --no-dev --optimize-autoloader

# 7. Generate key
RUN php artisan key:generate

# 8. Expose port 10000
EXPOSE 10000

# 9. Start the application
CMD php artisan serve --host=0.0.0.0 --port=10000