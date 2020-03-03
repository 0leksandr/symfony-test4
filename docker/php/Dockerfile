FROM php:7.4.1-fpm-alpine3.11
ENV USER _www

RUN apk update; \
    apk upgrade;
RUN docker-php-ext-install pdo pdo_mysql mysqli
RUN apk add composer yarn

#RUN apk add zlib-dev icu-dev g++
RUN apk add icu-dev
RUN docker-php-ext-configure intl && \
    docker-php-ext-install intl

RUN apk add sudo
RUN adduser --disabled-password ${USER} && \
    echo ${USER}:pass | chpasswd
#RUN apk add shadow
#RUN groupadd sudo
#RUN addgroup -S sudo
#RUN usermod -aG sudo ${USER}
RUN sed -e 's/# %wheel ALL=(ALL) NOPASSWD: ALL/%wheel ALL=(ALL) NOPASSWD: ALL/g' \
        -i /etc/sudoers
RUN sed -e 's/^wheel:\(.*\)/wheel:\1,'${USER}'/g' -i /etc/group

#RUN useradd -m ${USER}

USER ${USER}
