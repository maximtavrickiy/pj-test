FROM php:7.3-fpm

RUN docker-php-ext-install mysqli

RUN apt-get update -qq \
    && apt-get install -qy --no-install-recommends \
        git \
        openssl \
        librecode0 \
        uuid-dev \
        libmagickwand-dev \
        libsasl2-dev \
        imagemagick \
        libmagickwand-dev \
        libmagickcore-dev \
        libsqlite3-0 \
        libxml2 \
        && pecl install xdebug-2.7.1 \
        && docker-php-ext-enable xdebug


RUN apt-get update -qq \
    && apt-get install -qy --no-install-recommends \
        autoconf \
        file \
        g++ \
        gcc \
        libc-dev \
        make \
        cmake \
        curl \
        pkg-config \
        libtool \
        tar \
        libmcrypt-dev \
        libpng-dev \
        zip \
        unzip \
        wget \
        libzip-dev


RUN mkdir /var/log/php


RUN apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql

RUN docker-php-ext-install \
        gd \
        mysqli \
        pdo \
        pdo_pgsql \
        pgsql \
        pdo_mysql \
        mbstring \
        tokenizer \
        opcache \
        exif \
        zip \
        soap

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- \
        --filename=composer \
        --install-dir=/usr/local/bin && \
        echo "alias composer='composer'" >> /root/.bashrc && \
        composer

ADD ./php.ini /usr/local/etc/php/php.ini
