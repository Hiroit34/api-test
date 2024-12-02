# Usa un'immagine PHP-FPM con base Alpine
FROM php:8.2-fpm-alpine

# Installa solo le dipendenze necessarie per Laravel e MySQL
RUN apk add --no-cache \
    bash \
    mysql-client \
    oniguruma-dev \
    libzip-dev \
    curl-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip

# Installa Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Imposta la directory di lavoro
WORKDIR /var/www/html

# Copia i file dell'applicazione Laravel
COPY ../ /var/www/html

# Imposta i permessi corretti per storage e bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Espone la porta 9000 per PHP-FPM
EXPOSE 9000

CMD ["php-fpm"]
