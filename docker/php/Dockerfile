FROM php:7.4.1-fpm-alpine3.11

RUN apk update
RUN docker-php-ext-install pdo pdo_mysql mysqli
RUN apk add composer yarn

RUN apk add icu-dev && \
    docker-php-ext-configure intl && \
    docker-php-ext-install intl

ENV USER _www
RUN adduser --disabled-password ${USER}
#RUN apk add sudo && \
#    echo ${USER}:pass | chpasswd && \
#    sed -e 's/# %wheel ALL=(ALL) NOPASSWD: ALL/%wheel ALL=(ALL) NOPASSWD: ALL/g' \
#        -i /etc/sudoers && \
#    sed -e 's/^wheel:\(.*\)/wheel:\1,'${USER}'/g' -i /etc/group

USER ${USER}
