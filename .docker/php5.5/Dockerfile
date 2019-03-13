FROM php:5.5-apache

MAINTAINER Katenkka

RUN docker-php-ext-install pdo pdo_mysql mysqli mysql
RUN a2enmod rewrite
RUN service apache2 restart
