#!/bin/bash

echo "Installing... "
spinner() {
    local spin='-\|/'
    local i=0
    local count=0
    local limit=50

    while [ $count -lt $limit ]; do
        printf "\b${spin:i++%${#spin}:1}"
        sleep 0.1
        count=$((count + 1))
    done
}

spinner &

sudo apt update > /dev/null 2>&1
sudo apt install -y php php-gd php-sqlite3 php-curl libfreetype6-dev libjpeg-dev libpng-dev libzip-dev zip unzip libsqlite3-dev curl git > /dev/null 2>&1

git clone https://github.com/Toomas633/FileShare.git > /dev/null 2>&1
cd FileShare
sudo chmod -R a+rw .

sudo mv examples/FileShare.service /etc/systemd/system/ > /dev/null 2>&1
sudo sed -i "s|ExecStart=/path/to/start.sh|ExecStart=$(pwd)/start.sh|" /etc/systemd/system/FileShare.service
sudo systemctl daemon-reload > /dev/null 2>&1
sudo systemctl start FileShare.service > /dev/null 2>&1
sudo systemctl enable FileShare.service > /dev/null 2>&1

service_status=$(sudo systemctl is-active FileShare.service)

kill $!
echo "Done!"
if [[ "$service_status" == "active" ]]; then
    echo -e "Service is running. \e[32m🟢\e[0m"
else
    echo -e "Service is not running. \e[31m🔴\e[0m"
fi