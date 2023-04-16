#!/bin/bash
cd "$(dirname "$0")"
function cleanup {
  echo "Cleaning up child processes"
  pkill -P $$
}
trap 'cleanup' SIGTERM
php createDB.php > FileShare.log &
php -S 0.0.0.0:8000 > FileShare.log &
python3 cleanup.py > cleanup.log &
wait