FROM php:8.3-fpm-alpine

# Install system dependencies & PHP extensions
RUN apk add --no-cache \
    nginx \
    supervisor \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    sqlite-dev \
    git

RUN docker-php-ext-install pdo pdo_sqlite bcmath gd opcache

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy application files
COPY . /var/www/html

# Install PHP dependencies without dev
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Create necessary directories and set permissions
RUN mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs bootstrap/cache \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Copy minimal Nginx & Supervisor configuration
RUN echo "events { worker_connections 1024; } \
http { \
    include /etc/nginx/mime.types; \
    default_type application/octet-stream; \
    sendfile on; \
    keepalive_timeout 65; \
    server { \
        listen 8080 default_server; \
        server_name _; \
        root /var/www/html/public; \
        index index.php index.html; \
        location / { \
            try_files \$uri \$uri/ /index.php?\$query_string; \
        } \
        location ~ \.php\$ { \
            fastcgi_pass 127.0.0.1:9000; \
            fastcgi_index index.php; \
            fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name; \
            include fastcgi_params; \
        } \
        location ~ /\.(?!well-known).* { \
            deny all; \
        } \
    } \
}" > /etc/nginx/nginx.conf

RUN echo "[supervisord] \
nodaemon=true \
\
[program:php-fpm] \
command=php-fpm -F \
autostart=true \
autorestart=true \
stdout_logfile=/dev/stdout \
stdout_logfile_maxbytes=0 \
stderr_logfile=/dev/stderr \
stderr_logfile_maxbytes=0 \
\
[program:nginx] \
command=nginx -g 'daemon off;' \
autostart=true \
autorestart=true \
stdout_logfile=/dev/stdout \
stdout_logfile_maxbytes=0 \
stderr_logfile=/dev/stderr \
stderr_logfile_maxbytes=0" > /etc/supervisord.conf

EXPOSE 8080

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
