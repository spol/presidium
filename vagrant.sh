#!/bin/bash

/vagrant/build.sh dev

rm -r /var/www
ln -s /vagrant/public /var/www