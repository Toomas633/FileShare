#!/bin/bash
cd "$(dirname "$0")"
function cleanup {
  echo "Cleaning up child processes"
  pkill -P $$
}
trap 'cleanup' SIGTERM
php -c FileShare_Debian.ini createDB.php > FileShare.log &
sleep 15 && php -c FileShare_Debian.ini -S 0.0.0.0:8000 > FileShare.log &
python3 cleanup.py > cleanup.log &
wait