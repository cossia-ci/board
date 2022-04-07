#!/bin/bash
source ./env.sh
chmod -R 777 ../../web/public
chmod -R 777 ../../web/writable
chmod -R 777 ../../etc/letsencrypt
cp -f ../../etc/shell/before.conf ../../etc/nginx/default.conf 

# nginx
sed -i s/-DOMAIN-/$DOMAIN/g ../../etc/nginx/default.conf 

# docker-compose
sed -i s/-SSLPORT-/$SSLPORT/g ./docker-compose.yml
sed -i s/-WEBPORT-/$WEBPORT/g ./docker-compose.yml
sed -i s/-DOMAIN-/$DOMAIN/g ./docker-compose.yml
sed -i s/-DBPORT-/$DBPORT/g ./docker-compose.yml
sed -i s/-MYSQL_DATABASE-/$MYSQL_DATABASE/g ./docker-compose.yml
sed -i s/-MYSQL_ROOT_PASSWORD-/$MYSQL_ROOT_PASSWORD/g ./docker-compose.yml
sed -i s/-MYSQL_USER-/$MYSQL_USER/g ./docker-compose.yml
sed -i s/-MYSQL_PASSWORD-/$MYSQL_PASSWORD/g ./docker-compose.yml
sed -i s/-EMAIL-/$EMAIL/g ./docker-compose.yml
sed -i s/-PROJECT-/$PROJECT/g ./docker-compose.yml

# Database.php
sed -i s/-DBPORT-/$DBPORT/g ../../web/app/Config/Database.php
sed -i s/-MYSQL_ROOT_PASSWORD-/$MYSQL_ROOT_PASSWORD/g ../../web/app/Config/Database.php
sed -i s/-MYSQL_DATABASE-/$MYSQL_DATABASE/g ../../web/app/Config/Database.php

docker-compose up -d --build
docker exec -it $PROJECT-PHP service cron start
# docker exec -it $PROJECT-PHP echo "$(hostname -i)\t$(hostname) $(hostname).localhost" >> /etc/hosts
# docker exec -it $PROJECT-PHP service sendmail start