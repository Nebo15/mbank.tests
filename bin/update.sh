#!/bin/bash
CURRENT_DIR=$PWD
PROJECT_DIR=$(dirname $0)/../
cd $PROJECT_DIR

BRANCH=$(git rev-parse --abbrev-ref HEAD)
echo "Updating ${BRANCH} branch"
git pull origin $BRANCH

echo "Updating composer dependencies"
composer install

cd $CURRENT_DIR
