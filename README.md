# FileShare

- [Requirements](#requirements)
- [Running instructions](#running-instructions)
  - [Debian service](#debian)
  - [Windows service](#windows)
    - [Web server](#web-server)
    - [Python script](#python-script)
  - [Docker](#docker)
- [Suggestions](#suggestions)
- [Donate](#donate)

![Preview](https://raw.githubusercontent.com/Toomas633/FileShare/main/.github/preview/preview.gif)

This is a simple file sharing website, that generates direct and/or download page links to files. Direct linking works for generating links for in config files or any other reason something would want to load something directly from web or if you don't want to check the downloaded file but get it instantly. Download page links are great for sharing files for easy download checking.

Features:

* One file per upload
* Random name toggle.
* File preview icons.
* Same file name check.
* Delete time slider form  1-12h, 24h or never.
* Easy link copy.
* Admin page.
  * Display timezone select.
  * Delete and download buttons.
  * File list with hyperlink to download page.
  * Generated link beginning for hosting behind a domain.
* Download page with download and delete buttons.
* Status messages and popups

Default password: Password.123

## Requirements

* Make sure you have PHP installed on your local machine. You can check this by running the command `php -v` in your terminal. If you don't have PHP installed, you can download it from the [official PHP website](https://www.php.net/).
* Install Python on your Windows machine if it is not already installed. You can download the latest version of Python from the official website at [https://www.python.org/downloads/](https://www.python.org/downloads/).
* Change the values of `post_max_size` and  `upload_max_filesize` in `php.ini` to a desired size amount, or bigger files can't be uploaded (defaults are 8M and 2M in the file, so the uploaded file can only be of size 2MB and less)
* Check that you have php-sqlite3 installed and enabled.
  * On debian run `sudo apt get php-sqlite3`, windows should have the .dll files included in the php folder.
  * Edit `php.ini` and uncomment `extension=pdo_sqlite` and `extension=sqlite3` and assign the php installation dir path to `sqlite3.extension_dir =`, for example `sqlite3.extension_dir = C:\php` on windows.

## Running instructions

- [Debian service](#debian)
- [Windows service](#windows)
  - [Web server](#web-server)
  - [Python script](#python-script)
- [Docker](#docker)

* Clone the GitHub repository to your local machine using the command `git clone https://github.com/Toomas633/FileShare.git` or download the zip from releases and unpack it to desired destination.
* Start a local server to access the website in your browser. You can do this by running the command `php -S localhost:8000` (or a different port number) in your terminal from the project directory.
* For timed file delete also run `cleanup.py` on the backround.
* Access the website in your browser. Once the server is running, you can access the website by navigating to [http://localhost:8000](http://localhost:8000) (or the appropriate URL) in your web browser.

### Debian

* Create a new systemd service file for your PHP website by running the command sudo nano /etc/systemd/system/mywebsite.service. Replace "mywebsite" with a descriptive name for your service.
* In the editor, paste the following code to define the service:

  ```
  [Unit]
  Description=My PHP Website
  After=network.target

  [Service]
  Type=simple
  ExecStart=/usr/bin/php -S localhost:8000 -t /path/to/website
  ExecStartPost=/usr/bin/python /path/to/cleanup.py
  Restart=always
  User=www-data
  Group=www-data

  [Install]
  WantedBy=multi-user.target
  ```

  Make sure to replace "My PHP Website" with a descriptive name for your website, "/path/to/website" and "/path/to/cleanup.py" with the path to the website files on your server leaving "cleanup.py" in place, and "localhost:8000" with the appropriate URL for your website.
* Save and close the file by pressing `CTRL+X`, then `Y`, then `ENTER`.
* Reload the systemd daemon to recognize the new service by running the command `sudo systemctl daemon-reload`.
* Start the new service by running the command `sudo systemctl start mywebsite`.
* Verify that the service is running properly by checking the status with the command `sudo systemctl status mywebsite`.
* If the service is running correctly, enable it to start at boot time by running the command `sudo systemctl enable mywebsite`.

### Windows

#### Web server

* Install XAMPP or WAMP server on your Windows machine. Both XAMPP and WAMP provide Apache and PHP pre-configured, making it easy to get a PHP website up and running quickly.
* Copy your PHP website files to the appropriate directory in the web server's document root folder. For example, if you are using XAMPP, copy your website files to the `C:\xampp\htdocs` folder.
* Open a web browser and navigate to your PHP website by entering the appropriate URL. For example, if you are using XAMPP, enter [http://localhost:8000](http://localhost:8000) in the browser address bar.

#### Python script

* Open the Task Scheduler by pressing the Windows key + R and entering `taskschd.msc` in the Run dialog box.
* In the Task Scheduler, click on "Create Task" in the right-hand panel.
* In the General tab, enter a name for the task and check the box next to "Run with highest privileges".
* In the Triggers tab, click "New" to create a new trigger. Select "At startup" under "Begin the task" and choose any other settings as desired.
* In the Actions tab, click "New" to create a new action. Select "Start a program" as the action type and enter the path to your Python interpreter followed by the path to your Python script. For example, if you are using Python 3 and your script is located in `C:\scripts`, the action would be:
  ```
  Program/script: C:\Python38\python.exe
  Add arguments: C:\scripts\myscript.py
  ```
* Click "OK" to save the action and then "OK" again to save the task.

That's it! Your Python script should now run in the background on system start in Windows. You can check that the task is running by opening the Task Manager and looking for the Python process.

### Docker

* Make sure you have Docker installed on your machine. You can download and install Docker from the official Docker website.
* Pull the image usin `docker pull ghcr.io/toomas633/fileshare:latest`. 
* Then run `docker run -d --restart always -p 8080:80 -e TZ=Europe/Tallinn -e MAX_FILESIZE=5M -v /host/path1:/var/www/html/uploads/ -v /host/path2:/var/www/html/db/ fileshare` to start the container. This command will run the "fileshare" Docker image in the background, map port 80 from the container to port 8080 on your host machine. Be sure to replace the `Europe/Tallinn` with your correct timezone, change the `MAX_FILESIZE=` to a desired ammount and point `/host/path1` to the folder you want the uploaded files to be saved and `/host/path2` to database folder so they are not lost on container update.
* Once the container is running, you can access the file sharing service by opening a web browser and navigating to `http://localhost:8080`.

Alternativelly create a `docker-compose.yml`, copy the contents under here and run it with `docker-compose up -d`.
```
version: '3.9'
services:
  fileshare:
    image: ghcr.io/toomas633/fileshare:latest
    container_name: fileshare
    ports:
      - "8080:80"
    environment:
      - TZ=Europe/Tallinn
      - MAX_FILESIZE=5M
    volumes:
      - /host/path1:/var/www/html/uploads/
      - /host/path2:/var/www/html/db/
    restart: always
```


## Suggestions

Suggestions are welcome and can be posted under the issues. Anything is welcome, including extra functionality, extra preview icons etc.

## Donate

Monero: `8Ajf5M6meNpL9TaHuDRbXjAH31LcQ9ge5BEiwMZjLaoiMDZRxaVy19FgbP4tbUKpKoeq1kqCvjyaTdmCMQGhekWoQ2KgVeV`

Bitcoin: `3NPFV9ivECdSgyCXeNk4h5Gm3q1xiDRnPV`

More options on [https://toomas633.com/donate/](https://toomas633.com/donate/)
