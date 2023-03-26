FROM php:7.4-apache
WORKDIR /var/www/html
COPY . /var/www/html
COPY docker/php.ini /usr/local/etc/php/conf.d/php.ini
RUN apt update
RUN apt install -y git zip unzip libpng-dev libjpeg-dev libfreetype6-dev libpq-dev libonig-dev libzip-dev python3 python3-pip sqlite3 libsqlite3-dev
RUN docker-php-ext-install pgsql pdo pdo_pgsql pdo_sqlite sqlite3 && a2enmod rewrite
RUN docker-php-ext-configure sqlite3 pdo_sqlite
COPY cleanup.py /usr/src/app
WORKDIR /usr/src/app
CMD ["python3", "cleanup.py", "&"]
ENV MAX_FILESIZE 5M
VOLUME /var/www/html/uploads/
EXPOSE 80