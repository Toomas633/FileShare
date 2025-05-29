#!/bin/bash
cd "$(dirname "$0")"
function cleanup {
  echo "Cleaning up child processes"
  pkill -P $$
}
trap 'cleanup' SIGTERM
php -c FileShare.ini createDB.php > FileShare.log &
sleep 5 && php -c FileShare.ini -S 0.0.0.0:8000 > FileShare.log &
wait