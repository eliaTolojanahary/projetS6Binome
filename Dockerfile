FROM php:8.2-apache


RUN apt-get update \
    && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo_mysql


RUN a2enmod rewrite


COPY . /var/www/html


RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf


EXPOSE 8080


CMD ["apache2-foreground"]
