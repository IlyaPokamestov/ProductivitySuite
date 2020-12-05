FROM composer:2.0 as builder
WORKDIR /var/www/app
COPY . .
RUN composer install --optimize-autoloader --ignore-platform-reqs --no-interaction --no-scripts

FROM php:7.4-fpm
WORKDIR /var/www/productivity_suite
RUN apt-get update && apt-get install -y \
            libicu-dev \
            libpq-dev \
        && rm -rf /var/lib/apt/lists/* \
        && docker-php-ext-configure opcache --enable-opcache \
        && docker-php-ext-configure intl \
        && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
        && docker-php-ext-install -j$(nproc) opcache pdo pdo_pgsql pgsql intl
ENV APP_ENV=prod APP_DEBUG=0
COPY --from=builder /var/www/app ./

# Configure PHP.
RUN cp ./docker/configuration/opcache.ini /usr/local/etc/php/conf.d/opcache.ini && \
    cp ./docker/configuration/php.ini /usr/local/etc/php/conf.d/php.ini

RUN php bin/console cache:warmup && chmod 777 -R var/

# RUN yes | pecl install xdebug \
#    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
#    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
#    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini
