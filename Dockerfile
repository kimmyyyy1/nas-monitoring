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

# 6. Create .env file (Need ito para sa build process)
RUN cp .env.example .env

# 7. Install Laravel libraries
RUN composer install --no-dev --optimize-autoloader

# 8. Generate key
RUN php artisan key:generate

# 9. Expose port 10000
EXPOSE 10000

# 10. Start the application (ITO ANG BINAGO NATIN)
# Nilagyan natin ng 'config:clear' para siguradong basahin niya ang Render Environment Variables
# Nilagyan din natin ng 'migrate --force' para automatic na gumawa ng tables
CMD sh -c "php artisan config:clear && php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=10000"