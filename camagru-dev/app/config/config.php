<?php

define ('APPROOT', dirname(dirname(__FILE__)));
define ('URLROOT', 'http://'.$_SERVER['HTTP_HOST']);
define ('SITENAME', 'Camagru');

//database params

define('DB_HOST', 'db');
define('DB_USER', 'root');
define('DB_PASSWD', 'myrootpass');
define('DB_NAME', 'camagru_db'); 
// the default port is 6033
define('DB_PORT', '3306');