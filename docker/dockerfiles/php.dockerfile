FROM php:8.3-fpm

WORKDIR /var/www/default

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install pcntl
RUN docker-php-ext-install bcmath
RUN apt update -y
RUN apt install git -y
RUN apt install -y zip libzip-dev
RUN docker-php-ext-install zip
RUN pecl install xdebug && docker-php-ext-enable xdebug
RUN pecl install redis && docker-php-ext-enable redis
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
COPY composer.* .
RUN composer install
RUN addgroup --gid 1000 www-group
RUN adduser www-data www-group

EXPOSE 9000
