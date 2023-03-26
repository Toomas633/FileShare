FROM php:8.2-apache
WORKDIR /var/www/html
COPY . /var/www/html
COPY docker/php.ini /usr/local/etc/php/conf.d/php.ini
RUN apt update && apt install apt-utils && apt upgrade -y
RUN apt install -y git zip unzip libpng-dev libjpeg-dev libfreetype6-dev libpq-dev libonig-dev libzip-dev python3 python3-pip sqlite3 libsqlite3-dev
RUN docker-php-ext-install pgsql pdo pdo_pgsql pdo_sqlite sqlite3 && a2enmod rewrite
COPY cleanup.py /usr/src/app
WORKDIR /usr/src/app
ENV MAX_FILESIZE 5M
VOLUME /var/www/html/uploads/
EXPOSE 80
CMD ["python3", "cleanup.py", "&"]