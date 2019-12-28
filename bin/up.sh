#!/bin/sh
#./bin/parallel_commands.sh "./bin/symfony.sh serve" "yarn encore dev --watch"
./bin/parallel_commands.sh "php -S 0.0.0.0:8000 -t ./public/" "yarn encore dev --watch"
#./bin/parallel_commands.sh "yarn encore dev --watch"
