#!/bin/sh
docker exec -it test4-mysql mysql \
    --user=testuser \
    --password=testpassword \
    --database=testdb \
    --execute="$1"
