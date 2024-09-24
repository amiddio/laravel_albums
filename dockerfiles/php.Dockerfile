FROM php:8.1-fpm

WORKDIR /var/www/laravel

RUN apt update && apt upgrade -y mc git curl nodejs npm

RUN docker-php-ext-install pdo pdo_mysql bcmath  \
    && pecl install redis  \
    && docker-php-ext-enable redis

RUN echo 'memory_limit = 2048M' >> /usr/local/etc/php/conf.d/docker-php-memlimit.ini;

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
