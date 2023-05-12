# build command
# docker build -t vogaro:php5.6 -f php5.6-apache/Dockerfile .

# set the base image
FROM php:5.6-apache

# init
RUN apt-get clean

# install basic apps, one per line for better caching
RUN apt-get update && apt-get install -y \
        locales \
        zip \
        unzip \
        vim

# enable apache modules
RUN a2enmod include rewrite headers deflate expires


# install GD
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
	&& docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
	&& docker-php-ext-install -j$(nproc) gd

#install soap
RUN apt-get update && apt-get install -y \
        libxml2-dev
# install php extentions(soap)
RUN docker-php-ext-install soap


# install mysql client(to connect db container)
RUN apt-get update && apt-get install -y \
        default-mysql-client
# install php extentions
RUN docker-php-ext-install pdo_mysql mysqli


# install php extentions ssh2
RUN apt-get update && apt-get install -y \
        libssh2-1-dev \
        && pecl install ssh2 \
        && docker-php-ext-enable ssh2

# install pache2-utils for basic auth
RUN apt-get update && apt-get install apache2-utils -y


# enable mail service
# http://blog.gaiterjones.com/docker-php-sendmail-replacement-smtp/
RUN set -x \
    && DEBIAN_FRONTEND=noninteractive \
    && apt-get update && apt-get install -y --no-install-recommends msmtp
RUN mkdir /etc/msmtp
RUN touch /etc/msmtp/.msmtp.log
RUN chmod 600 /etc/msmtp/.msmtp.log
RUN chown www-data:www-data /etc/msmtp/.msmtp.log


# composerのインストール
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# https://getcomposer.org/doc/03-cli.md#composer-allow-superuser
ENV COMPOSER_ALLOW_SUPERUSER 1
# composerの参照を日本に設定
RUN composer config -g repos.packagist composer https://packagist.jp


# cleanup
RUN apt-get -qy autoremove


# 設定ファイルの設置
COPY ./php_assets/apache2.conf /etc/apache2/apache2.conf
COPY ./php_assets/php.ini /usr/local/etc/php/php.ini
COPY ./php_assets/entrypoint /etc/entrypoint


# timezone
ENV TZ Asia/Tokyo

CMD php /etc/entrypoint/bootstrap.php && apache2-foreground
