#!/bin/bash
source ../shell/env.sh
SHELL_PATH=`pwd -P`

cp -f ../../etc/shell/after.conf ../../etc/nginx/default.conf 
sed -i s/-DOMAIN-/$DOMAIN/g ../../etc/nginx/default.conf 

sed -i s/-EMAIL-/$EMAIL/g ./docker-compose.yml
sed -i s/-DOMAIN-/$DOMAIN/g ./docker-compose.yml

docker-compose up --no-deps fcertbot
docker rm Certbot

crontab -e 0 0 1 * * $SHELL_PATH/ssh.sh