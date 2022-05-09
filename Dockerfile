FROM alpine:3.14
ADD https://github.com/guibmolina/timezoneCLI/archive/refs/heads/master.zip /tmp/timezonecli.zip
RUN  cd /tmp \
    && unzip -q timezonecli.zip -d ./ \
    && cd ../usr/local/ \
    && mkdir timezonecli/ \
    && cp -r ../../tmp/timezoneCLI-master/* timezonecli/ \
    && rm -rf ../../tmp/timezonecli.zip ../../tmp/timezoneCLI-master
RUN apk add --no-cache php8
RUN ln -s /usr/bin/php8 /usr/bin/php
WORKDIR /usr/local/timezonecli
RUN chmod +x timezone.php
