#!/bin/sh

if [ ! $1 ]
then
    docker-compose exec --user $(ls -lnd . | awk '{print $3}') app bash
else
    docker-compose exec --user $(ls -lnd . | awk '{print $3}') app $@
fi
