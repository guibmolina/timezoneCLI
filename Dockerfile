FROM alpine:3.14
COPY . /usr/src/timezoneCLI
WORKDIR /usr/src/timezoneCLI
RUN apk add --no-cache php8
RUN ln -s /usr/bin/php8 /usr/bin/php
RUN chmod +x timezone.php
