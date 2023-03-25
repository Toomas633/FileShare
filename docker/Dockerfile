FROM php:8.1-apache
WORKDIR /var/www/html
COPY . /var/www/html
COPY php.ini /usr/local/etc/php/conf.d/php.ini
RUN apt get update && apt install -y python3 python3-pip php-sqlite3 sqlite3
RUN docker-php-ext-install pdo_mysql mysqli gd zip pdo_sqlite sqlite3 && a2enmod rewrite
RUN docker-php-ext-configure sqlite3 --with-sqlite3=/usr/local && docker-php-ext-install sqlite3
COPY cleanup.py /usr/src/app
WORKDIR /usr/src/app
ENV MAX_FILESIZE 5M
VOLUME /var/www/html/uploads/
CMD ["python3", "cleanup.py", "&"]
EXPOSE 80