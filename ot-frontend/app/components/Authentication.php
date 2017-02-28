<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class Authentication
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
    	session_start();   

    	// if session exists && token exists
    	if(isset($_SESSION['access_token']))
    	{
    		// $token = $_SESSION['token']; check login-service for guest/user
    		$user_data = $this->login_service->getUserData();

    		if(!isset($user_data))
    			$user_data = array('is_guest' => -1);

    		$this->container->user_state->setUserState($user_data);
    	}
    	else
    	{
    		//$token = call login-service for guest-token [store guest-token in db; run cron to delete inactive token of 10 mins]
    		$token = $this->login_service->getGuestToken();    		

    		if(isset($token) && !empty($token))
    		{
    			$_SESSION['access_token'] = $token['access_token'];
    		}
            
            if(!isset($user_data))
                $user_data = array('is_guest' => -1);

            $this->container->user_state->setUserState($user_data);            

    	}

    	$response = $next($request, $response);
        return $response;

    }
}

?>