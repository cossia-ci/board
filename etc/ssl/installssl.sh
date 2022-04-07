#!/bin/bash
source ../shell/env.sh

cp -f ../../etc/shell/after.conf ../../etc/nginx/default.conf 
sed -i s/-EMAIL-/$EMAIL/g ./docker-compose.yml

docker-compose up --no-deps fcertbot
docker rm Certbot