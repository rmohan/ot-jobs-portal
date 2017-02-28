<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class ProcessRequest
{

	private $container;
    private $login_service;
	
	public function __construct($container)
	{
		$this->container = $container;
        $this->login_service = $container->get('login_service');
	}

	public function __invoke(Request $request, Response $response, callable $next)
    { 

    	$token = $request->getHeader('X-OT-ACCESS-TOKEN');

        if(isset($token) && !empty($token))
        {
            $this->container['auth_token'] = $token[0];
        }
        else
        {
            $this->container['auth_token'] = '';
        }

        $user_data = $this->login_service->getUserData($this->container->get('auth_token'));

        if(!isset($user_data))
            $user_data = array('is_guest' => -1);

        $this->container->user_state->setUserState($user_data);

    	$response = $next($request, $response);

        return $response;

    }
}

?>