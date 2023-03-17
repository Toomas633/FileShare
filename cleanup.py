import json
import os
import time
from datetime import datetime, timezone  

def deletefiles():
    with open('db/database.json', 'r') as file:
        data = json.load(file)
    files = data['files']
    local_tz_offset = datetime.now(timezone.utc).astimezone().utcoffset().total_seconds()
    current_time = int(round(time.time() * 1000))
    for file in files:
        delete_time_local = file['deleteTime'] + (local_tz_offset * 1000)
        upload_time_local = file.get('uploadTime', 0) + (local_tz_offset * 1000)
        if current_time > delete_time_local and delete_time_local != upload_time_local and file.get('deleteTime'):
            file_path = os.path.join('uploads', file['name'])
            if os.path.exists(file_path):
                os.remove(file_path)
                files.remove(file)
            else:
                files.remove(file)
    with open('db/database.json', 'w') as file:
        json.dump(data, file, indent=4)

if __name__ == '__main__' :
    while True:
        deletefiles()
        time.sleep(60)