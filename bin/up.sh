#!/bin/sh
composer install && \
yarn install && \
"$(dirname "$0")"/symfony.sh self:update -y && \
"$(dirname "$0")"/parallel_commands.sh -n "
    $(dirname "$0")/symfony.sh serve
    yarn encore dev --watch
"
