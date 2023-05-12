# build command
# docker build -t vogaro:php5.3 -f php5.3-apache/Dockerfile .

FROM ubuntu:12.04
MAINTAINER kent koyama <koyama@vogaro.co.jp>

VOLUME ["/var/www/html"]
WORKDIR /var/www/html

ENV PHP_VERSION 5.3.10
# PHP 5.3 + Apache で必要なパッケージをインストール
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
      apache2 \
      libapache2-mod-php5 \
      php5 \
      php5-cli \
      php5-gd \
      php5-mcrypt \
      php5-mysql \
      php5-pgsql \
      php5-curl \
      mysql-client \
      curl

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

# enable apache modules
COPY ./php5.3-apache/assets/default /etc/apache2/sites-available/default
RUN a2enmod include rewrite headers deflate expires
RUN service apache2 restart
COPY ./php5.3-apache/assets/run /usr/local/bin/run
RUN chmod +x /usr/local/bin/run
COPY ./php5.3-apache/assets/php.ini /etc/php5/cli/php.ini
COPY ./php_assets/entrypoint /etc/entrypoint

CMD php /etc/entrypoint/bootstrap.php && bash /usr/local/bin/run
