FROM php:8.2-apache
WORKDIR /var/www/html
COPY . /var/www/html
COPY docker/php.ini /usr/local/etc/php/conf.d/php.ini
RUN apt update && apt install -y git zip unzip python3 python3-pip sqlite3 libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libzip-dev libsqlite3-dev
RUN docker-php-ext-install gd zip pdo_sqlite sqlite3 && a2enmod rewrite
RUN docker-php-ext-configure sqlite3 --with-sqlite3=/usr/local && docker-php-ext-install sqlite3
COPY cleanup.py /usr/src/app
WORKDIR /usr/src/app
CMD ["python3", "cleanup.py", "&"]
ENV MAX_FILESIZE 5M
VOLUME /var/www/html/uploads/
EXPOSE 80