FROM php:7.3-apache

MAINTAINER Katenkka

RUN docker-php-ext-install pdo pdo_mysql
RUN a2enmod rewrite
RUN service apache2 restart
