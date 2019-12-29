#!/bin/sh
./bin/console doctrine:migrations:migrate --no-interaction
./bin/console doctrine:fixtures:load      --no-interaction
