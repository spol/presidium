#!/bin/bash

# Setup MySQL

	DEBIAN_FRONTEND=noninteractive apt-get -y install mysql-server

	# Create DB
	mysqladmin create presidium

	# Create application user.
	mysql -uroot -e "GRANT ALL PRIVILEGES ON presidium.* TO 'presidium'@'localhost' IDENTIFIED BY 'presidium'"

	# Change Root password.
	mysqladmin -uroot password ys45eY2fJq6a7uq


# install apache/php

	apt-get -y install apache2
	apt-get -y install php5
	apt-get -y install php5-mcrypt
	apt-get -y install php5-mysqlnd

	a2enmod rewrite
	a2enmod vhost_alias
	a2enmod ssl

	echo "ServerName localhost" >> /etc/apache2/conf.d/name

# Setup environment

	if [ "$#" -eq 0 ]
	then
		read -e -p "Enter Environment name: " env
	else
		env=$1
	fi

	# Set ENVIRONMENT variable for apache.
	if grep --quiet "^export ENVIRONMENT=" /etc/apache2/envvars; then
		# replace
		sed -i "s/^export ENVIRONMENT=.*$/export ENVIRONMENT=$env/g" /etc/apache2/envvars
	else
		#insert
		echo "export ENVIRONMENT=$env" >> /etc/apache2/envvars
	fi

	# Set ENVIRONMENT variable for users.
	if grep --quiet "^ENVIRONMENT=" /etc/environment; then
		# replace
		sed -i "s/^ENVIRONMENT=.*$/ENVIRONMENT=$env/g" /etc/environment
	else
		#insert
		echo "ENVIRONMENT=$env" >> /etc/environment
	fi

	# Tell apache to pass the ENVIRONMENT env variable through to PHP.
	echo "PassEnv ENVIRONMENT" > /etc/apache2/conf.d/passenv-environment.local.conf

	service apache2 restart
