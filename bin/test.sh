#!/bin/bash
CURRENT_DIR=$PWD
PROJECT_DIR=$(dirname $0)/../
cd $PROJECT_DIR

# Test
echo "Running PHPUnit on guest VM"
appium &
./vendor/phpunit/phpunit/phpunit --testsuite "MBank"

cd $CURRENT_DIR
