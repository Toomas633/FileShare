FROM php:7.4-apache
WORKDIR /var/www/html
COPY . /var/www/html
COPY docker/php.ini /usr/local/etc/php/conf.d/php.ini
RUN apt update && apt install -y python3 python3-pip sqlite3
RUN docker-php-ext-install gd zip pdo_sqlite sqlite3 && a2enmod rewrite php7.4-sqlite3
RUN docker-php-ext-configure sqlite3 --with-sqlite3=/usr/local && docker-php-ext-install sqlite3 
COPY cleanup.py /usr/src/app
WORKDIR /usr/src/app
CMD ["python3", "cleanup.py", "&"]
ENV MAX_FILESIZE 5M
VOLUME /var/www/html/uploads/
EXPOSE 80