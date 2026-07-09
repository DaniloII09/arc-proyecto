FROM php:8.2-apache

RUN a2enmod rewrite

COPY index.php /var/www/html/index.php
COPY .htaccess /var/www/html/.htaccess

ENV APP_VERSION=dev
ENV DEPLOYED_AT=unknown

EXPOSE 80