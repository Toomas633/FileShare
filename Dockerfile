FROM ubuntu:20.04
ENV MAX_FILESIZE 5M
ENV TZ=Europe/Tallinn
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
VOLUME /var/www/html/uploads/
RUN apt update && apt upgrade -y
RUN apt install -y \
    php \
    php-sqlite3 \ 
    sqlite3 \
    libsqlite3-dev \
    python3 \
    python3-pip \
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
COPY cleanup.py /usr/local/bin
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
RUN chmod +x /usr/local/bin/cleanup.py
WORKDIR /var/www/html
EXPOSE 80
CMD ["/usr/bin/supervisord", "-n"]