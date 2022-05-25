FROM php:7.4.8-fpm-buster

RUN pecl install xdebug && docker-php-ext-enable xdebug
COPY ./xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
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


RUN apt-get update && apt-get install -y  \
    librabbitmq-dev \
    libssh-dev \
    && docker-php-ext-install opcache bcmath sockets \
    && pecl install amqp \
    && docker-php-ext-enable amqp

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

# splitter
RUN apt-get update \
    && apt-get install -y --no-install-recommends libldap2-dev \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/ \
    && docker-php-ext-install ldap
RUN apt-get update \
    && apt-get install -y --no-install-recommends mariadb-client \
    && rm -rf /var/lib/apt/lists/* \
RUN docker-php-ext-install pdo mysqli pdo_mysql
RUN apt-get update \
    && apt-get install -y --no-install-recommends libpng-dev \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install gd

RUN apt-get update && \
    apt-get install -y libxml2-dev &&\
    docker-php-ext-install soap

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

ARG USER_ID=1000
ARG GROUP_ID=1000
RUN userdel -f www-data \
    && if getent group www-data ; then groupdel www-data; fi \
    && groupadd -g ${GROUP_ID} www-data \
    && useradd -l -u ${USER_ID} -g www-data www-data \
    && install -d -m 0755 -o www-data -g www-data /home/www-data

RUN chown --changes --silent --no-dereference --recursive --from=33:33 ${USER_ID}:${GROUP_ID}  \
    /home/www-data  \
    /var/run/php-fpm \
    /var/lib/php/sessions \
    /var/www || true

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=1.10.10

USER www-data

RUN composer global require "phpmetrics/phpmetrics"
ENV PATH="~/.composer/vendor/bin:${PATH}"
