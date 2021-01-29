FROM php:7.4.10-apache

ENV APACHE_DOCUMENT_ROOT=/var/www/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN a2enmod rewrite headers remoteip

RUN apt-get update \
    && apt-get install -y git zip unzip
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

WORKDIR /var/www

COPY artisan artisan

COPY composer.json composer.lock ./

RUN composer install --no-autoloader

# build theme
COPY webpack.mix.js ./
COPY resources ./resources
COPY public ./public

COPY bootstrap ./bootstrap
COPY storage ./storage

RUN chown www-data:www-data -R storage bootstrap

COPY routes ./routes
COPY database ./database
COPY config ./config
COPY app ./app
COPY phpunit.xml ./phpunit.xml

RUN composer dump-autoload --optimize
