FROM php:8-apache

WORKDIR /var/www/html

COPY . .

RUN rm ./script/api-path.js
RUN mv ./script/api-path.js.docker ./script/api-path.js

EXPOSE 80
