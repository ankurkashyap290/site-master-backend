#!/bin/bash

if [ ! -d node_modules ]; then
    yarn add apidoc;
    node_modules/.bin/apidoc -i app/Http/Controllers/ -o public/apidoc/
fi;
