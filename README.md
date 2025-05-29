<img align="right" src="https://sonarcloud.io/api/project_badges/quality_gate?project=Toomas633_FileShare">
<img align="left" src="https://github.com/Toomas633/FileShare/actions/workflows/docker.yml/badge.svg">
<br>

# FileShare

- [Running instructions](#running-instructions)
  - [Docker](#docker)
  - [Manual install](#manual-install)
    - [Install script](#install-script)
    - [Manual](#manual)
  - [Nginx](#nginx)
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

Default password is Password.123, can be changed once logged into the settings page.

## Running instructions

- [Docker](#docker)
- [Manual install](#manual-install)
  - [Install script](#install-script)
  - [Manual](#manual)
- [Nginx](#nginx)

* Install PHP and Python (and add to system path on windows).
* Clone the GitHub repository to your local machine using the command `git clone https://github.com/Toomas633/FileShare.git` or download the zip from releases and unpack it to desired destination.
* Start a local server to access the website in your browser. You can do this by running the command `./start.sh` on debian in the terminal or run `start.bat` on windows.
* Access the website in your browser. Once the server is running, you can access the website by navigating to [http://localhost:8000](http://localhost:8000) (or the appropriate URL) in your web browser.

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
      - MAX_FILESIZE=100M #allowed uploaded file size
    volumes:
      - /host/path1:/var/www/html/uploads/ # volume or host dir to a folder where uploads will be held
      - /host/path2:/var/www/html/db/ # volume or host dir to a folder where the database will be held 
    restart: always
```

### Manual install

#### Install script

* Make sure you have wget installed with `sudo apt install wget`.
* Download the install script to the desired destination folder with `wget https://raw.githubusercontent.com/Toomas633/FileShare/update/examples/install.sh`.
* Enable running the script with `sudo chmod a+x install.sh`.
* Run the script and wait for it to finish setting everything up via `./install.sh`.
* Open a web browser and navigate to your PHP website by entering the appropriate URL. For example [http://localhost:8000](http://localhost:8000) in the browser address bar.

#### Manual

* Install required packages by running `sudo sudo apt install -y php php-gd php-sqlite3 php-curl libfreetype6-dev libjpeg62-turbo-dev libpng-dev libzip-dev zip unzip libsqlite3-dev curl git`.
* Clone the GitHub repository to your local machine using the command `git clone https://github.com/Toomas633/FileShare.git` or download the zip from releases and unpack it to desired destination.
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
  User=root
  Group=root

  [Install]
  WantedBy=multi-user.target
  ```

  Make sure to replace "/path/to/start.sh" with the path to the FileShare website folder that contains the start.sh file on your server.
  Save and close the file by pressing `CTRL+X`, then `Y`, then `ENTER`.
* Reload the systemd daemon to recognize the new service by running the command `sudo systemctl daemon-reload`.
* Start the new service by running the command `sudo systemctl start FileShare.service`.
* Verify that the service is running properly by checking the status with the command `sudo systemctl status FileShare.service`.
* If the service is running correctly, enable it to start at boot time by running the command `sudo systemctl enable FileShare.service`.
* Open a web browser and navigate to your PHP website by entering the appropriate URL. For example [http://localhost:8000](http://localhost:8000) in the browser address bar.

### Nginx

Example nginx configuration for reverse proxy

```
server {
  listen 443 ssl;
  server_name example.com;
    ssl_certificate /etc/letsencrypt/live/example.com/fullchain.pem; # managed by Certbot
    ssl_certificate_key /etc/letsencrypt/live/example.com/privkey.pem; # managed by Certbot

  location / {
    proxy_pass http://localhost:80;
    proxy_set_header Host $host;
    proxy_set_header X-Real-IP $remote_addr;
    proxy_set_header X-Forwarded-Proto $scheme;
    client_max_body_size 0;
    client_body_buffer_size 0;
  }

}

```

## Suggestions

Suggestions are welcome and can be posted under the issues. Anything is welcome, including extra functionality, extra preview icons etc.

## Donate

[toomas633.com/donate](https://toomas633.com/donate/)
