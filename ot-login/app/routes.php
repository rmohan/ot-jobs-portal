<?php

class Routes
{

    public static $routes = [
        'user' => [
            'controller' => 'UserController',
            'actions' => [
                'POST /login' => 'login', 
                'POST /logout' => 'logout',
                'GET /data' => 'getUserData', 
                'GET /guest' => 'getGuestToken'
            ]
        ]
    ];
}

?>