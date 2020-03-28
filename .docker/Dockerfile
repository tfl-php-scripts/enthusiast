FROM composer:1.6
FROM php:7.1-apache

MAINTAINER Scripts.robotess.net

RUN docker-php-ext-install pdo pdo_mysql
RUN apt-get update &&\
    apt-get install --no-install-recommends --assume-yes --quiet ca-certificates curl git &&\
    rm -rf /var/lib/apt/lists/*

RUN curl -Lsf 'https://storage.googleapis.com/golang/go1.8.3.linux-amd64.tar.gz' | tar -C '/usr/local' -xvzf -
ENV PATH /usr/local/go/bin:$PATH
RUN go get github.com/mailhog/mhsendmail
RUN cp /root/go/bin/mhsendmail /usr/bin/mhsendmail

RUN touch /usr/local/etc/php/php.ini
RUN echo 'sendmail_path = /usr/bin/mhsendmail --smtp-addr mailhog:1025' >> /usr/local/etc/php/php.ini
RUN echo 'display_errors = on' >> /usr/local/etc/php/php.ini \
    && echo 'log_errors = off' >> /usr/local/etc/php/php.ini

RUN yes | pecl install xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_handler=dbgp" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_port=9002" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_connect_back=0" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_host=172.17.0.1" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.idekey = Docker" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.default_enable = 0" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.profiler_enable = 1" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=1" >> /usr/local/etc/php/conf.d/xdebug.ini

RUN a2enmod rewrite
RUN service apache2 restart

RUN mkdir -p /app/public/images
RUN chmod -R 777 /app/public/images

WORKDIR /app

COPY --from=0 /usr/bin/composer /usr/bin/composer
# https://getcomposer.org/doc/03-cli.md#composer-allow-superuser
ENV COMPOSER_ALLOW_SUPERUSER 1
RUN composer global require "hirak/prestissimo:^0.3" --prefer-dist --no-progress --no-suggest --classmap-authoritative
