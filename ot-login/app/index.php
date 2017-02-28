<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require (__DIR__ . '/autoload.php');
require (__DIR__ . '/../vendor/autoload.php');

// for FB & G+ credentails
require (__DIR__ . '/config/config.php');
require (__DIR__ . '/config/container.php');

$app = new \Slim\App(new \Slim\Container($container));

/*$app->get('/', function (Request $req,  Response $res, $args = []) {
    /*$myvar1 = $req->getParam('myvar'); //checks both _GET and _POST [NOT PSR-7 Compliant]
    $myvar2 = $req->getParsedBody()['myvar']; //checks _POST  [IS PSR-7 compliant]
    $myvar3 = $req->getQueryParams()['myvar']; //checks _GET [IS PSR-7 compliant]
    var_dump($myvar1);
    $res->getBody()->write("Hello, index");

    return $res;
});

$app->get('/{name}', function (Request $req,  Response $res, $args = []) {
    /*$myvar1 = $req->getParam('myvar'); //checks both _GET and _POST [NOT PSR-7 Compliant]
    $myvar2 = $req->getParsedBody()['myvar']; //checks _POST  [IS PSR-7 compliant]
    $myvar3 = $req->getQueryParams()['myvar']; //checks _GET [IS PSR-7 compliant]
    var_dump($myvar1);
    $name = $req->getAttribute('name');
    $res->getBody()->write("Hello, $name");

    return $res;
});*/

require(__DIR__ . '/config/middleware.php');

$routeManager = new RouteManager($app);
$routeManager->route();

$app->run();

?>