FROM php:8.3-cli-alpine

# Install system dependencies
RUN apk add --no-cache     curl     libpng-dev     libxml2-dev     zip     unzip     sqlite-dev     git

RUN docker-php-ext-install pdo pdo_sqlite bcmath gd

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy application files
COPY . /var/www/html

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Create necessary directories and set permissions
RUN mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs bootstrap/cache     && chmod -R 777 storage bootstrap/cache

ENV PORT=8080
EXPOSE 8080

# Production startup script ensuring APP_KEY and artisan serve on 0.0.0.0:$PORT
CMD ["sh", "-c", "php artisan key:generate --force && php artisan serve --host=0.0.0.0 --port=${PORT:-8080}"]
