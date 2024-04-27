FROM php:8

RUN apt-get update -y && apt-get install -y openssl zip unzip git
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-install pdo_mysql && docker-php-ext-enable pdo_mysql

WORKDIR /api
COPY . .

RUN mv .env.docker .env
RUN composer install && php artisan key:generate

ENTRYPOINT ["/api/startAPI.sh"]

EXPOSE 8000
