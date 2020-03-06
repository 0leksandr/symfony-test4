#!/bin/sh
#docker-compose --file docker/docker-compose.yml up --build --abort-on-container-exit
echo "Starting..." &&
    rootdir="$(dirname "$0")"/.. &&
    mkdir -p "$rootdir"/var &&
    docker-compose --file "$rootdir"/docker/docker-compose.yml up --build -d &&
    "$(dirname "$0")"/container.sh ./bin/up.sh &&
    echo "Done"
docker-compose --file docker/docker-compose.yml stop
