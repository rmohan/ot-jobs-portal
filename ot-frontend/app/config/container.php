<?php

use Slim\Views\PhpRenderer;

$container = [

	'renderer' => new PhpRenderer('./view/'),
	'user_state' => UserState::getInstance(),
    'login_service' => new LoginService($service['login_service']),
    'operations_service' => new OperationsService($service['operations_service']),

];


?>