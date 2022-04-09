# Cossia Boara

## 방화벽 포트 열기
- `firewall-cmd --zone=public --add-port=80/tcp --permanent`
- `firewall-cmd --zone=public --add-port=443/tcp --permanent`
- `firewall-cmd --reload`

## git 설치
- `yum install -y git`

## 도커 설치
- `yum install yum-utils`
- `yum-config-manager --add-repo https://download.docker.com/linux/centos/docker-ce.repo`
- `yum install -y docker-ce docker-ce-cli containerd.io`
- `systemctl enable docker`
- `systemctl start docker`

## 컴포즈 설치
- `curl -L "https://github.com/docker/compose/releases/download/1.28.2/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose`
- `chmod +x /usr/local/bin/docker-compose`
- `systemctl restart docker`

## 복사
- `git clone https://github.com/cossia-ci/board.git [./|절대경로]`
- `rm -r .git`

## 설치 및 사용법
- [유튜브](https://studio.youtube.com/channel/UCZxmOJr9p1wU3uLK7Cybxkw/playlists)
- [코시아보드](https://cossia.kr)

## 책임 및 의무
- 사용중 발생하는 오류 및 모든 상황은 사용자가 책임 집니다.
- 본인 사용, 본인 수정 사용, 판매, 수정 판매 모두 가능합니다.
- 단, 수정 후 재 배포는 금합니다. 이를 어길시 민 형사상의 손해를 볼 수 있습니다.