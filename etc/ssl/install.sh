#!/bin/bash
# chmod a+x install.sh
# chmod a+x cron.sh
source ./env.sh
cp -f ../../etc/shell/after.conf ../../etc/nginx/default.conf 
sed -i s/-DOMAIN-/$DOMAIN/g ../../etc/nginx/default.conf 
sed -i s/-EMAIL-/$EMAIL/g ./docker-compose.yml
sed -i s/-DOMAIN-/$DOMAIN/g ./docker-compose.yml
docker-compose up --no-deps fcertbot
docker rm Certbot
docker restart Nginx
crontab -l > addcrontab
SHELL_PATH=`pwd -P`
echo "0 0 1,15 * * $SHELL_PATH/cron.sh > /home/sh.log 2>&1" >> addcrontab
crontab addcrontab
rm addcrontab
rm ./install.sh
# crontab 확인