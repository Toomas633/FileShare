<?php
// Database configuration settings
define('DB_HOST', 'localhost');
define('DB_NAME', 'my_database');
define('DB_USER', 'my_username');
define('DB_PASSWORD', 'my_password');

// Site configuration settings
define('SITE_NAME', 'My Website');
define('SITE_URL', 'http://www.mywebsite.com');
define('DEFAULT_TIMEZONE', 'America/New_York');
define('MaxSize', '5M');


// Other configuration settings
ini_set('display_errors', 1);
ini_set('upload_max_filesize', MaxSize);
ini_set('post_max_size', MaxSize);
error_reporting(E_ALL & ~E_WARNING & ~E_DEPRECATED);

// Additional constants or variables as needed...
