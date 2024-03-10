#!/bin/zsh

/usr/local/sbin/php-fpm -F &
exec /usr/sbin/httpd -kstart -DFOREGROUND -f /etc/apache2/httpd.conf "$@"