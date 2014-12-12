#!/bin/sh

CORE_PATH='/var/services/web/bonus-card/'

cd ${CORE_PATH}

chown -R web:users web/bundles
chown -R web:users app/cache
chown -R web:users app/logs
