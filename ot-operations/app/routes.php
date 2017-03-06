<?php

class Routes
{

    public static $routes = [
        'jobs' => [
            'controller' => 'JobController',
            'actions' => [
                'POST /create' => 'create', 
                'POST /update' => 'update',
                'GET ' => 'getAll', 
                'GET /me' => 'getSaved',                
                'GET /{seo_title}' => 'get',
                'POST /{seo_title}/delete' => 'delete',
                'POST /{seo_title}/save' => 'saveUserJob',
                'POST /{seo_title}/unsave' => 'unsaveUserJob',
            ]
        ]
    ];
}

?>