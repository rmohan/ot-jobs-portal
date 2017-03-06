<?php

use Slim\Views\PhpRenderer;

$container = [

	'renderer' => new PhpRenderer('./app/view/'),
	'user_state' => UserState::getInstance(),
    'login_service' => new LoginService($service['login_service']),
    'operations_service' => new OperationsService($service['operations_service']),
    'settings' => [
        'displayErrorDetails' => true,
    ]

];

$container['fb_params'] = function() use ($fb_params) {
    return $fb_params;
};

$container['site_base_url'] = function() use ($site_base_url) {
    return $site_base_url;
};

?>