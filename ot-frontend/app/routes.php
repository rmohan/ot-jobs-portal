<?php

class Routes
{
    public static $routes = [
        'logout' => [
            'controller' => 'LoginController',
            'permission' => '',
            'actions' => [
                '' => 'logout'
            ]
        ],
        'login' => [
            'controller' => 'LoginController',
            'permission' => '',
            'actions' => [
                '' => 'login',
                'facebook' => 'facebook',
                'google' => 'google',
                'fb_callback' => 'fb_callback'
            ]
        ],
        'jobs' => [
            'controller' => 'JobController',
            'permission' => '',
            'actions' => [
                '' => 'all',
                'me' => 'saved',
                'save' => 'save',
                'unsave' => 'unsave',
                '{seo_title}' => 'get' 
            ]
        ],
        'admin' => [
            'controller' => 'AdminHomeController',
            'permission' => 'admin',
            'actions' => [
                '' => 'index',
                'jobs' => [
                    'controller' => 'JobController',
                    'permission' => 'admin',
                    'actions' => [
                        '' => 'index',
                        'create' => 'create',
                        'update' => 'update',
                        'delete' => 'delete',
                    ]
                ]
            ],
        ]
    ];
}

?>