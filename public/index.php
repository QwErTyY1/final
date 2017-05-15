<?php

define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);

define('APP', ROOT . 'application' . DIRECTORY_SEPARATOR);



if (file_exists(ROOT . 'vendor/autoload.php')) {
    require ROOT . 'vendor/autoload.php';
}


require APP . 'config/config.php';


require APP . 'libs/helper.php';
require APP. 'libs/Facebook/autoload.php';


// load application class
require APP. 'class/FacebookH.php';
require APP. 'class/Cat.php';
require APP. 'class/Pagination.php';


require APP . 'core/application.php';
require APP . 'core/Controller.php';

// start the application
$app = new Application();
