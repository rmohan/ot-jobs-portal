<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class ProcessRequest
{

	private $container;
	
	public function __construct($container)
	{
		$this->container = $container;
	}

	public function __invoke(Request $request, Response $response, callable $next)
    { 

    	$token = $request->getHeader('X-OT-ACCESS-TOKEN');

        if(isset($token) && !empty($token))
        {
            //$this->container->set('auth_token', function(){ return $token; });
            $this->container['auth_token'] = $token[0];
        }
        else
        {
            $this->container['auth_token'] = '';
        }

        $source = $request->getHeader('X-Request-Source'); // to be used for operations service only

        if(isset($source) && !empty($source))
        {
            //$this->container->set('request_source', $source);
            $this->container['request_source'] = $source[0];
        }
        else{
             $this->container['request_source'] = '';
        }

    	$response = $next($request, $response);

        return $response;

    }
}

?>