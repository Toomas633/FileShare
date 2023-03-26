FROM php:7.4-apache
WORKDIR /var/www/html
COPY . /var/www/html
COPY docker/php.ini /usr/local/etc/php/conf.d/php.ini
RUN apt update && apt install -y apt-utils
RUN apt install -y git zip unzip libpng-dev libjpeg-dev libfreetype6-dev libpq-dev libonig-dev libzip-dev python3 python3-pip php7.4-sqlite3 sqlite3 libsqlite3-dev
RUN docker-php-ext-install gd zip pgsql pdo pdo_pgsql sqlite3 && a2enmod rewrite
RUN docker-php-ext-configure sqlite3 --with-sqlite3=/usr/local && docker-php-ext-install sqlite3 
COPY cleanup.py /usr/src/app
WORKDIR /usr/src/app
CMD ["python3", "cleanup.py", "&"]
ENV MAX_FILESIZE 5M
VOLUME /var/www/html/uploads/
EXPOSE 80