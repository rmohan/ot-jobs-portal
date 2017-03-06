<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require (__DIR__ . '/app/autoload.php');
require (__DIR__ . '/vendor/autoload.php');

// for FB & G+ credentails
require (__DIR__ . '/app/config/config.php');
require (__DIR__ . '/app/config/container.php');

$app = new \Slim\App(new \Slim\Container($container));

require(__DIR__ . '/app/config/middleware.php');

$routeManager = new RouteManager($app);
$routeManager->route();

$app->run();
?>