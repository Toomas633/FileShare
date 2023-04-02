import logging
import os
import sqlite3
import time
from datetime import datetime

import pytz

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
    current_time = int(datetime.now(pytz.timezone('UTC')).timestamp() * 1000)
    for file in files:
        name = file[0]
        upload_time=file[1]
        delete_time = file[2]
        if current_time > delete_time and delete_time != upload_time:
            file_path = os.path.join('uploads/', name)
            if os.path.exists(file_path):
                logging.info(f"Deleted file: {name} \t Delete time in db(utc): {delete_time}")
                os.remove(file_path)
    cursor.close()
    conn.close()

if __name__ == '__main__':
    while True:
        deleteFiles()
        deleteEntries()
        time.sleep(60)
