#!/bin/sh
"$(dirname "$0")"/parallel_commands.sh "$(dirname "$0")/symfony.sh serve" "yarn encore dev --watch"
#yarn encore dev --watch
