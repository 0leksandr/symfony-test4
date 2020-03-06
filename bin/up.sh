#!/bin/sh
echo "Up..." &&
    composer install &&
    yarn install &&
    "$(dirname "$0")"/symfony.sh self:update -y &&
    "$(dirname "$0")"/db-load.sh &&
    "$(dirname "$0")"/parallel.sh -n "
        $(dirname "$0")/symfony.sh serve
        yarn encore dev --watch
    " &&
    echo "Done"
