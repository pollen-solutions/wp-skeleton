FROM composer:latest as expose

RUN composer global require beyondcode/expose

ENTRYPOINT ["/tmp/vendor/bin/expose"]