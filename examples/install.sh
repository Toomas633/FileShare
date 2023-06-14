#!/bin/bash

echo -n "Installing..."
terminal_width=$(tput cols)
padding_length=$((terminal_width - 10))
printf "%*s" $padding_length ""
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

sudo apt update > /dev/null
sudo apt install -y php php-curl php-sqlite3 php-gd > /dev/null

git clone https://github.com/Toomas633/FileShare.git > /dev/null
cd FileShare

sudo mv examples/FileShare.service /etc/systemd/system/ > /dev/null
sudo sed -i "s|ExecStart=/path/to/start.sh|ExecStart=$(pwd)/start.sh|" /etc/systemd/system/FileShare.service
sudo systemctl daemon-reload > /dev/null
sudo systemctl start FileShare.service > /dev/null
sudo systemctl enable FileShare.service > /dev/null

service_status=$(sudo systemctl is-active FileShare.service)

kill $!
echo "\rDone!"
if [[ "$service_status" == "active" ]]; then
    echo -e "\e[32mService is running. \e[0m🟢"
else
    echo -e "\e[31mService is not running. \e[0m🔴"
fi