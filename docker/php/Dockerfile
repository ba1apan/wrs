FROM php:7.4-fpm
RUN apt-get update
RUN apt-get install libzip-dev zlib1g-dev libpng-dev libpq-dev libxml2-dev curl libonig-dev -y
RUN docker-php-ext-install pdo_pgsql zip gd mbstring soap
RUN apt-get install git -y
RUN apt-get install wget -y
RUN wget -O /usr/local/bin/codecept https://codeception.com/releases/4.1.20200323/codecept.phar && chmod a+x /usr/local/bin/codecept

RUN yes | pecl install xdebug-2.9.4 \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini

