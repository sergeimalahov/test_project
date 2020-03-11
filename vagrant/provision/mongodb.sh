#!/usr/bin/env bash

wget -qO - https://www.mongodb.org/static/pgp/server-3.6.asc | sudo apt-key add -
echo "deb [ arch=amd64,arm64 ] https://repo.mongodb.org/apt/ubuntu xenial/mongodb-org/3.6 multiverse" | sudo tee /etc/apt/sources.list.d/mongodb-org-3.6.list

sudo apt-get update
sudo apt-get install -y mongodb-org

sudo service mongod start
sudo systemctl daemon-reload
sudo systemctl enable mongod.service