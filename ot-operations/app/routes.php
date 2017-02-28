<?php

class Routes
{

    public static $routes = [
        'jobs' => [
            'controller' => 'JobController',
            'actions' => [
                'POST /create' => 'create', 
                'POST /{seo_title}/update' => 'update',
                'GET ' => 'getAll', 
                'GET /me' => 'getSaved',                
                'GET /{seo_title}' => 'get',
                'DELETE /{seo_title}' => 'delete',
                'POST /{seo_title}/save' => 'saveUserJob',
                'POST /{seo_title}/unsave' => 'unsaveUserJob',
            ]
        ]
    ];
}

?>