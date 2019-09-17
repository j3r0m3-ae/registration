<?php

// TODO: remove these settings at the end of development
error_reporting(E_ALL);
ini_set('display_errors', 1);

define('ROOT', __DIR__);

require './vendor/autoload.php';

$routes = require './app/config/routes.php';

$controllersMapping = require './app/config/controllersMapping.php';
$controllerFactory = new \app\components\ControllerFactory($controllersMapping);

(new \app\components\Router($routes, $controllerFactory))->run();