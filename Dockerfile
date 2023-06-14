FROM ubuntu:20.04
LABEL org.opencontainers.image.source=https://github.com/Toomas633/FileShare
LABEL org.opencontainers.image.description="File share website"
LABEL org.opencontainers.image.licenses=GPL-3.0
LABEL org.opencontainers.image.authors=Toomas633
ENV MAX_FILESIZE 100M
ENV TZ=Europe/London
ENV PASSWORD=Password.123
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo 'Europe/London' > /etc/timezone
VOLUME /var/www/html/uploads/
VOLUME /var/www/html/db/
RUN apt update
RUN apt install -y \
    php \
    php-gd \
    php-cli \
    php-sqlite3 \ 
    php-curl \
    libgd-dev \
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
    supervisor \
    nano
RUN pip install datetime pytz
COPY . /var/www/html
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
RUN chmod +x /var/www/html/cleanup.py
RUN mkdir /var/www/html/db /var/www/html/uploads
RUN chmod 777 /var/www/html/db /var/www/html/uploads
WORKDIR /var/www/html
EXPOSE 8000
CMD ["/usr/bin/supervisord", "-n"]