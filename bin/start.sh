#!/bin/sh
composer install
yarn install
#docker-compose --file docker/docker-compose.yml up --build --abort-on-container-exit
docker-compose --file docker/docker-compose.yml up --build -d
docker exec -it test4-php ./bin/up.sh
docker-compose --file docker/docker-compose.yml stop
