<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class ProcessRequest
{

	private $container;
    protected $ignoreActions = ['guest'];
	
	public function __construct($container)
	{
		$this->container = $container;
	}

	public function __invoke(Request $request, Response $response, callable $next)
    { 
        $source = $request->getHeader('X-Request-Source'); // to be used for operations service only
        if(isset($source) && !empty($source))
        {
            //$this->container->set('request_source', $source);
            $this->container['request_source'] = $source[0];
        }
        else{
             $this->container['request_source'] = '';
        }



        if ($this->_ignoreCheck($request, $response, $next)) {
            return $response;
        }


    	$token = $this->_getAuthHeader(); //$request->getHeader('X-OT-ACCESS-TOKEN');
        if(isset($token) && !empty($token))
        {
            //$this->container->set('auth_token', function(){ return $token; });
            $this->container['auth_token'] = $token;
        }
        else
        {
            $this->container['auth_token'] = '';
        }


    	$response = $next($request, $response);
        return $response;

    }

    private function _ignoreCheck($request, &$response, callable $next)
    {

        $url_parts = explode('/', $request->getUri()->getPath());

        $action = (isset($url_parts[2])) ? $url_parts[2] : '';

        if (in_array($action, $this->ignoreActions)) {
            $response = $next($request, $response);
            return $response;
        }

        return false;

    }

    private function _getAuthHeader()
    {
        //var_dump($_SERVER); exit();


        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            if (isset($_SERVER['Authorization'])) {
                list($_SERVER['PHP_AUTH_USER'], ) = explode(':', base64_decode(substr($_SERVER['Authorization'], 6)));
            } else {
                throw new \Exception('Required Authorization header is invalid or empty', 480);
            }
        }
        return $_SERVER['PHP_AUTH_USER'];
    }
}

?>