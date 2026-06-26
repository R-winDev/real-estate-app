FROM php:8.3-fpm

ARG UID=1000
ARG GID=1000

RUN docker-php-ext-install pdo_mysql mysqli bcmath

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN usermod -u $UID www-data && groupmod -g $GID www-data

WORKDIR /var/www/html
