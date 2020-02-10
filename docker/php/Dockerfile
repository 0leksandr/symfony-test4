FROM php:7.4.1-fpm-alpine3.11

RUN apk update; \
    apk upgrade;
RUN docker-php-ext-install pdo pdo_mysql mysqli
RUN apk add composer yarn

#RUN apk add zlib-dev icu-dev g++
RUN apk add icu-dev
RUN docker-php-ext-configure intl && \
    docker-php-ext-install intl
RUN useradd -m _www

USER _www
