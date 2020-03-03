#!/bin/sh
#docker-compose --file docker/docker-compose.yml up --build --abort-on-container-exit
docker-compose --file docker/docker-compose.yml up --build -d \
  && "$(dirname "$0")"/container.sh ./bin/up.sh
docker-compose --file docker/docker-compose.yml stop
