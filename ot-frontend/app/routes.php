<?php

class Routes
{
    public static $routes = [
        'logout' => [
            'controller' => 'LoginController',
            'actions' => [
                '' => 'logout'
            ]
        ],
        'login' => [
            'controller' => 'LoginController',
            'actions' => [
                '' => 'login',
                'facebook' => 'facebook',
                'google' => 'google',
                'fb_callback' => 'fb_callback'
            ]
        ],
        'jobs' => [
            'controller' => 'JobController',
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
            'actions' => [
                '' => 'index',
                'jobs' => [
                    'controller' => 'JobController',
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