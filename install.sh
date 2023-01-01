#!/bin/bash
# chmod a+x install.sh
# sh install.sh
source ./etc/ssl/env.sh
#------------------------------------------
# 폴더 퍼미션 변경
#------------------------------------------
chmod -R 777 ./web/public
chmod -R 777 ./web/writable
chmod -R 777 ./etc/letsencrypt

install_nas(){
    #------------------------------------------
    # 혹시 모를 DB 내용 있을까 지워버림
    #------------------------------------------
    rm -rf ./database/
    mkdir ./database/
    #------------------------------------------
    # 도커 컴포저 나스용 가져와서 복사
    #------------------------------------------
    cp -f ./etc/shell/nas-compose.yml ./docker-compose.yml
    #------------------------------------------
    # 도커컴포저 변경
    #------------------------------------------
    sed -i s/-WEBPORT-/$WEBPORT/g ./docker-compose.yml
    sed -i s/-SSLPORT-/$SSLPORT/g ./docker-compose.yml
    sed -i s/-DBPORT-/$DBPORT/g ./docker-compose.yml
    sed -i s/-DOMAIN-/$DOMAIN/g ./docker-compose.yml
    sed -i s/-PROJECT-/${PROJECT^^}/g ./docker-compose.yml
    sed -i s/-DBNAME-/$DBNAME/g ./docker-compose.yml
    sed -i s/-DBPASSWORD-/$DBPASSWORD/g ./docker-compose.yml
    #------------------------------------------
    # 설정파일 나스용 가져와서 복사
    #------------------------------------------
    cp -f ./etc/shell/nas.env ./web/.env
    #------------------------------------------
    # CI .env 변경
    #------------------------------------------
    sed -i s/-DBPORT-/$DBPORT/g ./web/.env
    sed -i s/-DBNAME-/$DBNAME/g ./web/.env
    sed -i s/-DBPASSWORD-/$DBPASSWORD/g ./web/.env
    #------------------------------------------
    # nginx 설정
    #------------------------------------------
    cp -f ./etc/shell/before.conf ./etc/nginx/default.conf 
    #------------------------------------------
    # 도커컴포저 실행
    #------------------------------------------
    docker-compose up -d --build
    echo "docker exec -i ${PROJECT^^}-Mariadb mysql -uroot -p$DBPASSWORD --default-character-set=utf8mb4 $DBNAME < ./etc/shell/sql.sql"
    exit;
}

install_server(){
    #------------------------------------------
    # 도커 컴포저 나스용 가져와서 복사
    #------------------------------------------
    cp -f ./etc/shell/sever-compose.yml ./docker-compose.yml
    #------------------------------------------
    # 도커컴포저 변경
    #------------------------------------------
    sed -i s/-DOMAIN-/$DOMAIN/g ./docker-compose.yml
    sed -i s/-DBNAME-/$DBNAME/g ./docker-compose.yml
    sed -i s/-DBPASSWORD-/$DBPASSWORD/g ./docker-compose.yml

    #------------------------------------------
    # 설정파일 나스용 가져와서 복사
    #------------------------------------------
    cp -f ./etc/shell/server.env ./web/.env
    #------------------------------------------
    # CI .env 변경
    #------------------------------------------
    sed -i s/-DBNAME-/$DBNAME/g ./web/.env
    sed -i s/-DBPASSWORD-/$DBPASSWORD/g ./web/.env

    #------------------------------------------
    # 도커컴포저 실행
    #------------------------------------------
    docker-compose up -d --build

    #------------------------------------------
    # 나머지 잡다한
    #------------------------------------------
    SHELL_PATH=`pwd -P`
    chmod a+x $SHELL_PATH/etc/ssl/install.sh
    chmod a+x $SHELL_PATH/etc/ssl/cron.sh
    rm ./docker-compose.yml
    rm ./install.sh
    echo "cd $SHELL_PATH/etc/ssl"
    exit;
}

set_docker(){
    #------------------------------------------
    # 컴포즈 설치
    #------------------------------------------
    curl -L "https://github.com/docker/compose/releases/download/2.14.0/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
    chmod +x /usr/local/bin/docker-compose

    #------------------------------------------
    # 도커설치
    #------------------------------------------
    yum install -y yum-utils
    yum-config-manager --add-repo https://download.docker.com/linux/centos/docker-ce.repo
    yum install docker-ce docker-ce-cli containerd.io
    systemctl enable docker
    systemctl start docker

    docker-compose --version
    exit;
}

PS3='선택하세요: '
select serch in nas server
do
    case $serch in
        nas) install_nas;;
        docker) set_docker;;
        server) install_server;;
        *) echo "알맞는 숫자를 입력하세요" ;;
    esac
done
exit;;