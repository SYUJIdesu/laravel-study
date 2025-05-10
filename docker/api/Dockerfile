FROM php:8.4-fpm

ENV TZ Asia/Tokyo

RUN apt-get update && \
  apt-get install -y git unzip libzip-dev libicu-dev libonig-dev && \
  docker-php-ext-install intl pdo_mysql zip bcmath

# Node.jsとnpmをインストール
RUN apt-get update && \
  apt-get install -y curl gnupg && \
  curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
  apt-get install -y nodejs && \
  npm install -g npm

COPY ./docker/api/php.ini /usr/local/etc/php/php.ini
COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# # Copy source code
COPY src .
# RUN composer install