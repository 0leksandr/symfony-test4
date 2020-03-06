#!/bin/sh
#    "$(dirname "$0")"/console doctrine:database:create --no-interaction &&
echo "Loading DB..." &&
    "$(dirname "$0")"/console doctrine:migrations:migrate --no-interaction &&
    (
        "$(dirname "$0")"/console doctrine:query:sql --force-fetch -- "
            SELECT SUM(TABLE_ROWS)
            FROM INFORMATION_SCHEMA.TABLES
            WHERE
                TABLE_SCHEMA='testdb'
                AND TABLE_NAME != 'migration_versions'
        " | grep 'string(1) "0"' &&
            "$(dirname "$0")"/console doctrine:fixtures:load --no-interaction ||
            echo "Fixtures skipped"
    )
