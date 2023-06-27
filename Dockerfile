FROM php:8.1-apache
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
WORKDIR /var/www/html
RUN apt update && \
    apt install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    libsqlite3-dev \
    nano \
    curl && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install -j$(nproc) gd pdo pdo_sqlite mysqli zip && \
    apt autoremove && \
    apt autoclean
RUN a2enmod rewrite
COPY . /var/www/html
RUN mkdir /var/www/html/db /var/www/html/uploads
RUN chmod 777 /var/www/html/db /var/www/html/uploads
RUN php /var/www/html/createDB.php
EXPOSE 80
CMD ["apache2-foreground"]