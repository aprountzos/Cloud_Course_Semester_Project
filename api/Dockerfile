    FROM php:7.3-apache
    RUN apt-get update && apt-get upgrade -y
    RUN apt-get install -y openssl libssl-dev libcurl4-openssl-dev 
    RUN pecl install mongodb && docker-php-ext-enable mongodb
    RUN echo "extension=mongodb.so" > /usr/local/etc/php/conf.d/mongodb.ini
    EXPOSE 80