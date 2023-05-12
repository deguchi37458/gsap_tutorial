# build command
# docker build -t vogaro:php7.0 -f php7.0-apache/Dockerfile .

# set the base image
FROM php:7.0-apache

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


# install the PHP extensions (GD, mbstring, zip)
# wordpress
# https://github.com/docker-library/wordpress/blob/1caade96b306d0ed12f5637196e8f0b1883330f5/php7.2/apache/Dockerfile
RUN set -ex; \
	\
	savedAptMark="$(apt-mark showmanual)"; \
	\
	apt-get update; \
	apt-get install -y --no-install-recommends \
		libjpeg-dev \
		libpng-dev \
		libfreetype6-dev \
	; \
	\
	docker-php-ext-configure gd --with-png-dir=/usr --with-jpeg-dir=/usr --with-freetype-dir=/usr; \
	docker-php-ext-install gd mbstring zip; \
	\
# reset apt-mark's "manual" list so that "purge --auto-remove" will remove all build dependencies
	apt-mark auto '.*' > /dev/null; \
	apt-mark manual $savedAptMark; \
	ldd "$(php -r 'echo ini_get("extension_dir");')"/*.so \
		| awk '/=>/ { print $3 }' \
		| sort -u \
		| xargs -r dpkg-query -S \
		| cut -d: -f1 \
		| sort -u \
		| xargs -rt apt-mark manual; \
	\
	apt-get purge -y --auto-remove -o APT::AutoRemove::RecommendsImportant=false; \
	rm -rf /var/lib/apt/lists/*
        

#install soap
RUN apt-get update && apt-get install -y \
        libxml2-dev
# install php extentions(soap)
RUN docker-php-ext-install soap


#install mysql client(to connect db container)
RUN apt-get update && apt-get install -y \
        default-mysql-client
# install php extentions(mysql)
RUN docker-php-ext-install pdo_mysql mysqli


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
