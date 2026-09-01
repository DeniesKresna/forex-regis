FROM composer:2.8 AS vendor
WORKDIR /app
COPY composer.json ./
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --no-scripts

FROM php:8.4-cli
WORKDIR /var/www/html
RUN docker-php-ext-install pdo_mysql
COPY --from=vendor /app/vendor ./vendor
COPY --from=vendor /app/vendor /opt/vendor
COPY . .
RUN mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache
COPY docker/entrypoint.sh /usr/local/bin/entrypoint
RUN chmod +x /usr/local/bin/entrypoint
EXPOSE 8000
ENTRYPOINT ["entrypoint"]
