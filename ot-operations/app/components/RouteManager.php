<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class RouteManager
{
	private $app;

	public function __construct($app)
	{
		$this->app = $app;
	}

	public function route()
	{
		$routes = Routes::$routes;
		$app = $this->app;

		// the SLIM application will accept only the GET,POST and DELETE request methods. It will match all paths and then route the url_path
		// to the corresponding controller if a match is found.
		$app->map(['GET', 'POST', 'DELETE'], '{url_path:.+}', function(Request $req,  Response $res, $args = []) use ($app){
			$params = $req->getParams();
			$app_container = $app->getContainer();

			$routes = Routes::$routes;
			$url_path = $req->getAttribute('url_path');

			$url_path = rtrim($url_path, '/');

			$path_array = explode("/", $url_path);
			if(is_array($path_array) && !empty($path_array) && count($path_array) > 1)
			{
				
				// redirect to controller if route exists, else throw 404
				if(isset($routes[$path_array[1]]))
				{
					$controller_name = $routes[$path_array[1]]['controller'];
					$controller = new $controller_name($app_container);

					$controller_actions = $routes[$path_array[1]]['actions'];

					if(count($path_array) > 2)
					{
						$pageRoute = '/' . implode('/', array_slice($path_array, 2));
					}
					else
					{
						$pageRoute = '/';
					}

					$method = $req->getMethod();

					foreach ($controller_actions as $action => $function) 
					{
						list($methods, $endpoint) = explode(" ", $action);
						if(in_array($method, explode(",", $methods)))
						{
							// if route doesn't contain any regex
							if($pageRoute == $endpoint)
							{															
								$result = $controller->executeAction($function, $args, $params);
								return $res->withStatus($result['status'])->withJson($result['content']);
							}
							else
							{
								//if route has regex, then match and pass as arguments
								$endpoints = explode("/", $endpoint);
								$remaining_path_count = count($path_array) - 2;

								if(count($endpoints) -1 == $remaining_path_count)
								{

									$regex_match = '/';
	                                foreach ($endpoints as $pattern) 
	                                {
	                                    preg_match('/{.*}/', $pattern, $match);
	                                    if ($match) 
	                                    {
	                                        $regex_match .= ".*/";
	                                    } else if ($pattern != "") {
	                                        $regex_match .= "$pattern/";
	                                    }
	                                }
	                                $regex_match = rtrim($regex_match, '/');
	                                preg_match('#(' . $regex_match . ')$#', $pageRoute, $matches);

	                                if ($matches) 
	                                {
	                                    for ($i = 0; $i < count($endpoints); $i++) 
	                                    {
	                                        preg_match('/{.*}/', $endpoints[$i], $match);
	                                        if ($match) 
	                                        {
	                                            $arg = preg_replace('/{(.*)}/', '$1', $endpoints[$i]);
	                                            $args[$arg] = $path_array[$i + 1];
	                                        }
	                                    }
	                                    $result = $controller->executeAction($function, $args, $params);
	                                    return $res->withStatus($result['status'])->withJson($result['content']);
	                                }	                                
								}								
							}	

						}
						
					}
					
				}
				else
				{
					return $res
				            ->withStatus(404)
				            ->withJson(array('Error' => 'Invalid API endpoint'));
				}	
			}

			return $res
				            ->withStatus(404)
				            ->withJson(array('Error' => 'Invalid API endpoint'));

		});
	}
}

?>