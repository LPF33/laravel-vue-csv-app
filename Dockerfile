FROM ubuntu:22.04

ENV TZ=UTC

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apt-get update \
    && apt-get install -y curl ca-certificates zip unzip git supervisor sqlite3 libcap2-bin libpng-dev libapache2-mod-php\
    && apt-get install -y php8.1-cli php8.1-dev php8.1-curl \
    && php -r "readfile('https://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer \
    && curl -sLS https://deb.nodesource.com/setup_16.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

WORKDIR /usr/app
COPY ./ /usr/app

RUN composer install --no-dev
RUN composer run-script post-root-package-install & composer run-script post-create-project-cmd
RUN npm install
RUN npm run build

EXPOSE 8000

CMD php artisan serve --host=0.0.0.0 --port=8000