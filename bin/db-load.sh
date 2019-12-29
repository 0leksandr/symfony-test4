#!/bin/sh
"$(dirname "$0")"/console doctrine:migrations:migrate --no-interaction
"$(dirname "$0")"/console doctrine:fixtures:load --no-interaction
