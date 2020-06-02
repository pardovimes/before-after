FROM php:7.2-fpm
RUN pecl install apcu
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
WORKDIR /usr/src/app
COPY app /usr/src/app
RUN PATH=$PATH:/usr/src/apps/vendor/bin:bin
