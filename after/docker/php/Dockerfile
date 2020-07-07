FROM php:7.2-fpm
RUN pecl install apcu && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y git && \
    apt-get install zip unzip
WORKDIR /usr/src/app
COPY app /usr/src/app
RUN PATH=$PATH:/usr/src/apps/vendor/bin:bin
