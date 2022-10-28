<?php

session_start();
define('DEFAULT_CONTROLLER', 'home');
define('ROOT', dirname(dirname(__FILE__)));
define('PATH_VIEWS' ,ROOT . '/src/Views');

require_once ROOT . '/bootstrap.php';
