#!/bin/bash

echo "Starting..."
echo

bar_length=50
sleep_duration=0.1

progress_bar() {
    local duration=$1
    local total_length=$2
    local elapsed=0
    local progress=0
    local bar=""

    while [ $elapsed -lt $duration ]; do
        elapsed=$((elapsed + 1))
        progress=$((elapsed * 100 / duration))
        completed_length=$((progress * total_length / 100))
        bar=$(printf "[%-${total_length}s] %d%%" $(printf "#%.0s" $(seq 1 $completed_length)) $progress)
        printf "\r%s" "$bar"
        sleep $sleep_duration
    done

    printf "\n\n"
}

progress_duration=5

progress_bar $progress_duration $bar_length

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

echo "Done!"
if [[ "$service_status" == "active" ]]; then
    echo -e "\e[32mService is running. \e[0m🟢"
else
    echo -e "\e[31mService is not running. \e[0m🔴"
fi