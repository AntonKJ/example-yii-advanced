FROM php:7.4-fpm

# Install modules
RUN apt-get update && yes|apt-get install -y \
	apt-utils \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libicu-dev \
	libzip-dev \
	libonig-dev \
	libpq-dev \
	zlib1g-dev \
        wget \
        git 
#            --no-install-recommends

RUN apt-get update && yes|apt-get install -y libpq-dev

RUN docker-php-ext-install pdo pgsql pdo_mysql pdo_pgsql zip exif \
	&& docker-php-ext-configure gd \
	&& docker-php-ext-install gd 

RUN pecl install -o -f xdebug \
    && rm -rf /tmp/pear

COPY ./install-composer.sh /

RUN apt-get purge -y g++ \
    && apt-get autoremove -y \
    && rm -r /var/lib/apt/lists/* \
    && rm -rf /tmp/* \
    && sh /install-composer.sh \
    && rm /install-composer.sh

RUN usermod -u 1000 www-data

RUN no|pecl install -o -f redis \
&&  rm -rf /tmp/pear \
&&  docker-php-ext-enable redis

VOLUME /root/.composer

WORKDIR /home/yii2-advanced

RUN  apt-get -y update \
     && apt-get -y autoremove \
     && apt-get clean \
     && apt-get install -y p7zip \
     p7zip-full \
     unace \
     zip \
     unzip \
     xz-utils \
     sharutils \
     uudeview \
     mpack \
     arj \
     cabextract \
     file-roller \
     && rm -rf /var/lib/apt/lists/*

EXPOSE 9000
CMD ["php-fpm"]

FROM adminer
USER root
COPY login-password-less.php /var/www/html/login-password-less.php
#USER adminer # we run as root because of permissions problems on db file with the volume









