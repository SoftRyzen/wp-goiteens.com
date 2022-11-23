#!/bin/bash

# composer install
composer install

# cd to them
cd web/app/themes/goit-global 

# Build app
composer install && yarn install && yarn build
