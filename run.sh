#!/bin/bash
vagrant up
./bin/update.sh

echo "Waiting for NFS folder to be updated"
sleep 5

echo "Telling guest VM to run tests"
vagrant ssh --command "cd /vagrant && ./bin/test.sh"
