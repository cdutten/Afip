FROM php:7.3.0RC1-fpm-stretch

RUN apt-get update \
	&& apt install --no-install-recommends --no-install-suggests -y apt-transport-https lsb-release ca-certificates wget libxml2-dev git-core \
    && docker-php-ext-install soap \
    && docker-php-ext-configure soap \
	&& php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
	&& php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
	&& php composer-setup.php \
	&& php -r "unlink('composer-setup.php');" \
	&& mv composer.phar /usr/local/bin/composer \
    && mkdir -p /secret
WORKDIR /var/www/html/

EXPOSE 9000
CMD ["php-fpm"]