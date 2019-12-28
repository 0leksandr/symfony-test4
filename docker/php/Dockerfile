FROM php:7.4.1-fpm-alpine3.11
RUN apk update; \
    apk upgrade;
RUN docker-php-ext-install pdo pdo_mysql mysqli
RUN apk add composer yarn
