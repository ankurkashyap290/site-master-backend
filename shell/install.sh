#!/bin/bash

service apache2 start;

if [ ! -f /etc/apache2/sites-available/0000-site.conf ]; then
    cp /var/www/backend/shell/0000-site.conf /etc/apache2/sites-available/ \
      && sed -i "s/%API_SERVER_NAME%/$API_SERVER_NAME/g" /etc/apache2/sites-available/0000-site.conf \
      && sed -i "s/%FRONTEND_SERVER_NAME%/$FRONTEND_SERVER_NAME/g" /etc/apache2/sites-available/0000-site.conf \
      && a2ensite 0000-site \
      && service apache2 reload;
fi;

if [ ! -f .env ]; then
    cp $APP_ENV.env .env;
fi;

if [ "$TEST" = "true" ] || [ ! -d vendor ]; then
    composer install --no-suggest;
fi;

chown -R :www-data /var/www/backend/storage /var/www/backend/bootstrap/cache;
chown -R $(ls -lnd . | awk '{print $3}'):www-data /var/www/backend/vendor;
chmod -R g+w /var/www/backend/storage /var/www/backend/bootstrap/cache /var/www/backend/vendor;

if [ ! -f .installed ]; then
    if [ "$TEST" != "true" ]; then        
        php artisan migrate:install;
    fi;

    mkdir -p ~/.config/psysh
    chmod -R 755 ~/.config
fi;

if [ "$TEST" != "true" ]; then
    php artisan config:clear \
    && php artisan migrate \
    && php artisan view:clear \
    && php artisan cache:clear;

    if [ ! -f .installed ]; then
        php artisan db:seed \
        && touch .installed;
    fi;

    php artisan config:export;

    touch /var/spool/cron/crontabs/root;
    printf "* * * * *   root    cd /var/www/backend && php artisan schedule:run >> /dev/null 2>&1\n\n" > /etc/cron.d/php;
    cron -f;
fi;
