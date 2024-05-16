FROM php:7.4-cli

# Copy files
COPY . /usr/src/kocuj-di

# Update system packages
RUN apt-get update

# Install system requirements
RUN apt-get install -y --no-install-recommends \
    apt-utils

# Install PHP requirements
RUN apt-get install -y --no-install-recommends \
    libxml2-dev \
    && docker-php-ext-install \
    opcache

# Install XDebug
RUN pecl install xdebug-3.1.6
RUN docker-php-ext-enable xdebug

# Install Composer requirements
RUN apt-get install -y --no-install-recommends \
    git \
    libzip-dev \
    && docker-php-ext-install \
    intl \
    zip

# Change working directory
WORKDIR /usr/src/kocuj-di

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

# Commands to execute during "up"
CMD composer install \
    && bash
