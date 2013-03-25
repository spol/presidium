#!/bin/bash

/vagrant/build.sh dev

cd /vagrant
php artisan migrate

cp /vagrant/config/apache/presidium.dev.conf /etc/apache2/sites-available/presidium.dev

a2ensite presidium.dev

service apache2 restart