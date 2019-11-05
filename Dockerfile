FROM php:7.2-fpm
WORKDIR /var/www/html
RUN apt-get update && apt-get install -y git curl unzip
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer
RUN composer config -g github-oauth.github.com TOKEN_GITHUB
RUN composer global require "fxp/composer-asset-plugin:^1.2.0"
RUN docker-php-ext-configure pdo_mysql --with-pdo-mysql=mysqlnd \
    && docker-php-ext-configure mysqli --with-mysqli=mysqlnd \
    && docker-php-ext-install pdo_mysql