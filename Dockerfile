FROM ubuntu:20.04
LABEL org.opencontainers.image.source=https://github.com/Toomas633/FileShare
LABEL org.opencontainers.image.description="File share website"
LABEL org.opencontainers.image.licenses=GPL-3.0
LABEL org.opencontainers.image.authors=Toomas633
ENV MAX_FILESIZE 5M
ENV TZ=Europe/Tallinn
ENV PASSWORD=Password.123
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
VOLUME /var/www/html/uploads/
VOLUME /var/www/html/db/
RUN apt update
RUN apt install -y \
    php \
    php-cli \
    php-fpm \
    php-sqlite3 \ 
    sqlite3 \
    libsqlite3-dev \
    python3 \
    python3-pip \
    python-is-python3 \
    git \
    zip \
    unzip \
    libzip-dev \ 
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \ 
    libpq-dev \
    libonig-dev \
    supervisor
COPY docker/php.ini /usr/local/etc/php/conf.d/php.ini
COPY . /var/www/html
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
RUN chmod +x /var/www/html/cleanup.py
WORKDIR /var/www/html
EXPOSE 80
CMD ["/usr/bin/supervisord", "-n"]