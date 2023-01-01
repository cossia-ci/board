#!/bin/bash
SHELL_PATH=`pwd -P`
/usr/local/bin/docker-compose -f $SHELL_PATH/docker-compose.yml up --no-deps certbot
docker rm Certbot
docker restart Nginx