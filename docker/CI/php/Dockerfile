FROM php:7.4.8-fpm

ADD ./php.ini /usr/local/etc/php/php.ini

RUN apt-get update --fix-missing \
    && mkdir -p /usr/share/man/man1 \
    && mkdir -p /usr/share/man/man7 \
    && apt-get install -y --no-install-recommends \
        libpq-dev postgresql-client libonig-dev wget unzip re2c mc git locales iputils-ping \
        git ssh-client zlib1g-dev  libssl-dev  libzip-dev \
        apt-transport-https ca-certificates \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install pdo pdo_pgsql pdo_mysql bcmath mbstring

RUN apt-get update && \
apt-get install -y libxml2-dev &&\
rm -rf /var/lib/apt/lists/* &&\
docker-php-ext-install soap

ENV ACCEPT_EULA=Y
RUN apt-get update && apt-get install -y  nginx
COPY ./astro-question-api.conf /etc/nginx/sites-enabled/astro-question-api.conf

# install php pcntl
RUN docker-php-ext-install pcntl

# install php extensions for codeception
RUN docker-php-ext-install \
    bcmath \
    zip \
    sockets

#redis
RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis

RUN apt-get update \
    && apt-get install -y --no-install-recommends mariadb-client \
    && rm -rf /var/lib/apt/lists/* \
RUN docker-php-ext-install pdo mysqli pdo_mysql

# setting right locale
RUN sed -i -e 's/# en_US.UTF-8 UTF-8/en_US.UTF-8 UTF-8/' /etc/locale.gen \
    && echo 'LANG="en_US.UTF-8"'>/etc/default/locale \
    && dpkg-reconfigure --frontend=noninteractive locales \
    && update-locale LANG=en_US.UTF-8
ENV LANG en_US.UTF-8

RUN ln -snf /usr/share/zoneinfo/Europe/Kiev /etc/localtime \
    && echo "Europe/Kiev" > /etc/timezone \
    && dpkg-reconfigure -f noninteractive tzdata

RUN git config --global http.sslverify false


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=1.10.10

RUN composer global require "phpmetrics/phpmetrics"
ENV PATH="~/.composer/vendor/bin:${PATH}"

# vault
RUN apt-get update \
    && apt-get install git curl zip unzip rsync -y \
    && curl http://repo.dev.rozetka.com.ua/devops/vault-1.3.2 --output /bin/vault --silent \
    && chmod a+x /bin/vault \
    && git config --global core.sshCommand 'ssh -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no' \
    && rm -rf /var/lib/apt/lists/*
RUN mkdir -p /root/.ssh
