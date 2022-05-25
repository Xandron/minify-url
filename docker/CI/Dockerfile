FROM php:7.4-fpm-buster

RUN apt-get update \
#    && apt-get install git curl zip unzip rsync -y \
#    && curl http://repo.dev.rozetka.com.ua/devops/vault-1.3.2 --output /bin/vault --silent \
    && chmod a+x /bin/vault \
    && git config --global core.sshCommand 'ssh -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no' \
    && rm -rf /var/lib/apt/lists/*
#RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=1.10.10
#RUN curl http://repo.dev.rozetka.com.ua/devops/deployer.phar-6.8.0 --output /bin/dep --silent \
    && chmod a+x /bin/dep
RUN mkdir -p /root/.ssh