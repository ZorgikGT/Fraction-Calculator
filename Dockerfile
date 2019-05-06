FROM php:7.2-fpm-alpine3.8

RUN apk add --update curl-dev libxml2-dev &&  \
    docker-php-ext-install iconv zip opcache && \
    rm /var/cache/apk/*

RUN curl -sS https://getcomposer.org/installer | php -- --filename=composer --install-dir=/bin

WORKDIR "/application/"
COPY . ./

EXPOSE 80

CMD ["php", "-S", "0.0.0.0:80", "-t", "./public"]