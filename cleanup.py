import logging
import os
import sqlite3
import time
from datetime import datetime, timezone

logging.basicConfig(level=logging.DEBUG, filename='cleanup.log', filemode='w', format='%(asctime)s %(levelname)s: %(message)s', datefmt='%Y-%m-%d %H:%M:%S')

def deleteEntries():
    conn = sqlite3.connect('db/database.db')
    cursor = conn.cursor()
    files_in_folder = os.listdir("uploads/")
    cursor.execute("SELECT name FROM files")
    files_in_database = [row[0] for row in cursor.fetchall()]
    for filename in files_in_database:
        if filename not in files_in_folder:
            cursor.execute("DELETE FROM files WHERE name =?", (filename,))
            logging.info(f"Deleted entry for file: {filename}")
            conn.commit()
    cursor.close()
    conn.close()

def deleteFiles():
    conn = sqlite3.connect('db/database.db')
    cursor = conn.cursor()
    cursor.execute('SELECT * FROM files')
    files = cursor.fetchall()
    local_tz_offset = datetime.now(timezone.utc).astimezone().utcoffset().total_seconds()
    current_time = int(time.time() * 1000)
    for file in files:
        name = file[0]
        upload_time=file[1]
        delete_time = file[2]
        delete_time_local = delete_time + (local_tz_offset * 1000)
        upload_time_local = upload_time + (local_tz_offset * 1000)
        if current_time > delete_time_local and delete_time_local != upload_time_local and delete_time:
            file_path = os.path.join('uploads/', name)
            if os.path.exists(file_path):
                logging.info(file_path)
                print(f"Deleted file: {name} \t Delete time(tz): {delete_time_local} \t Delete time(utc): {delete_time}")
    cursor.close()
    conn.close()

if __name__ == '__main__':
    while True:
        deleteFiles()
        deleteEntries()
        time.sleep(60)
