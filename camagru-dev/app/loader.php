<?php

require_once 'config/config.php';
require_once 'config/database.php';
require_once 'config/setup.php';


/*
require_once 'libs/Controller.php';
require_once 'libs/Core.php';
require_once 'libs/Database.php';
*/


spl_autoload_register(function($class)
{
    require_once 'libs/'.$class.'.php';
});
