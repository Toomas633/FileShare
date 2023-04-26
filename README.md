# FileShare

<img align="right" src="https://sonarcloud.io/api/project_badges/quality_gate?project=Toomas633_FileShare">
<img align="right" src="https://github.com/Toomas633/FileShare/actions/workflows/docker.yml/badge.svg">

- [Requirements](#requirements)
- [Running instructions](#running-instructions)
  - [Debian service](#debian)
  - [Windows service](#windows)
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
* Responsive css

Default password: Password.123

## Requirements

* Make sure you have PHP installed on your local machine. You can check this by running the command `php -v` in your terminal. If you don't have PHP installed, you can download it from the [official PHP website](https://www.php.net/).
* Install Python on your Windows machine if it is not already installed. You can download the latest version of Python from the official website at [https://www.python.org/downloads/](https://www.python.org/downloads/).
* Change the values of `post_max_size` and  `upload_max_filesize` in `php.ini` to a desired size amount, or bigger files can't be uploaded (defaults are 8M and 2M in the file, so the uploaded file can only be of size 2MB and less)
* Check that you have php-sqlite3 and php-curl installed and enabled.
  * On debian run `sudo apt install php-sqlite3 php-curl`, windows should have the .dll files included in the php folder.
  * Edit `php.ini` and uncomment `extension=pdo_sqlite`, `extension=sqlite3`, `extension=curl` and assign the php installation dir path to `sqlite3.extension_dir =`, for example `sqlite3.extension_dir = C:\php` on windows.
* Check that you have pytz and datetime install for python by running `pip install pytz datetime`.

## Running instructions

- [Debian service](#debian)
- [Windows service](#windows)
- [Docker](#docker)

* Install PHP and Python (and add to system path on windows).
* Clone the GitHub repository to your local machine using the command `git clone https://github.com/Toomas633/FileShare.git` or download the zip from releases and unpack it to desired destination.
* Start a local server to access the website in your browser. You can do this by running the command `php -S localhost:8000` (or a different port number) in your terminal from the project directory.
* For timed file delete also run `cleanup.py` on the backround.
* Access the website in your browser. Once the server is running, you can access the website by navigating to [http://localhost:8000](http://localhost:8000) (or the appropriate URL) in your web browser.

### Debian

* Create a new systemd service file for your PHP website by running the command `sudo nano /etc/systemd/system/FileShare.service`.
* In the editor, paste the following code to define the service or run `sudo wget https://raw.githubusercontent.com/Toomas633/FileShare/main/examples/FileShare.service` in `cd /etc/systemd/system/`:

  ```
  [Unit]
  Description=FileShare Website
  After=network.target

  [Service]
  Type=simple
  ExecStart=/path/to/start.sh
  Restart=always
  User=www-data
  Group=www-data

  [Install]
  WantedBy=multi-user.target
  ```

  Make sure to replace "/path/to/start.sh" with the path to the FileShare website folder that contains the start.sh file on your server.
  Save and close the file by pressing `CTRL+X`, then `Y`, then `ENTER`.
* Reload the systemd daemon to recognize the new service by running the command `sudo systemctl daemon-reload`.
* Start the new service by running the command `sudo systemctl start mywebsite`.
* Verify that the service is running properly by checking the status with the command `sudo systemctl status FileShare.service`.
* If the service is running correctly, enable it to start at boot time by running the command `sudo systemctl enable FileShare.service`.

### Windows

* Install PHP and Python and add them to your windows system path.
* Copy your PHP website files to the appropriate directory.
* Enable running it in the background (or just doubleclick to run once in a dialog box)
  * Open the Task Scheduler by pressing the Windows key + R, typing "taskschd.msc" and hitting Enter.
  * Click on the "Create Task" option in the Actions pane on the right-hand side of the window.
  * In the "General" tab of the "Create Task" dialog box, enter a name for the task in the "Name" field.
  * In the "Security options" section, select the user account you want to run the task under.
  * Click on the "Triggers" tab and click "New".
  * In the "New Trigger" dialog box, select "At startup" from the "Begin the task" drop-down menu.
  * Click "OK" to save the trigger.
  * Click on the "Actions" tab and click "New".
  * In the "New Action" dialog box, select "Start a program" from the "Action" drop-down menu.
  * In the "Program/script" field, enter the full path to the `start.bat` file.
  * Click "OK" twice to save the action and task.
* Open a web browser and navigate to your PHP website by entering the appropriate URL. For example [http://localhost:8000](http://localhost:8000) in the browser address bar.

### Docker

Create a `docker-compose.yml`, copy the contents under here and run it with `docker-compose up -d` (or download the .yml from `https://raw.githubusercontent.com/Toomas633/FileShare/main/examples/docker-compose.yml` and edit it).

```
version: '3.9'
services:
  fileshare:
    image: ghcr.io/toomas633/fileshare:latest #or version number instead of latest
    container_name: fileshare #container name, can be set different
    ports:
      - "8080:80" #map port 8080 from host to 80 on container
    environment:
      - TZ=Europe/London #default timezone for the container and on first database creation
      - MAX_FILESIZE=5M #allowed uploaded file size
      - PASSWORD=Password.123 #password for settings page login, set your own or change it on the page
    volumes:
      - /host/path1:/var/www/html/uploads/ # volume or host dir to a folder where uploads will be held
      - /host/path2:/var/www/html/db/ # volume or host dir to a folder where the database will be held 
    restart: always
```

## Suggestions

Suggestions are welcome and can be posted under the issues. Anything is welcome, including extra functionality, extra preview icons etc.

## Donate

[toomas633.com/donate](https://toomas633.com/donate/)
