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

		$app->map(['GET', 'POST', 'DELETE'], '{url_path:.+}', function(Request $req,  Response $res, $args = []) use ($app){
			$params = $req->getParams();
			$app_container = $app->getContainer();
			
			$function = '';
			$controller_name = '';

			$routes = Routes::$routes;
			$url_path = $req->getAttribute('url_path');

			$url_path = rtrim($url_path, '/');

			$path_array = explode("/", $url_path);
			if(is_array($path_array) && !empty($path_array) && count($path_array) > 1)
			{

				$i = 1;

				while($i < count($path_array))
				{
					$regex_match = '';
					$matched_key = '';
					foreach ($routes as $key => $pattern) 
					{
						preg_match('/{.*}/', $key, $match);
                        if ($match) 
                        {
                            $regex_match .= ".*";
                            $matched_key = $key;
                        }
					}
					if(isset($routes[$path_array[$i]]))
					{
						if(is_array($routes[$path_array[$i]]) && !empty($routes[$path_array[$i]]))
						{
							$controller_name = $routes[$path_array[$i]]['controller'];							
							$routes = $routes[$path_array[$i]]['actions'];	
						}
						else
							$function = $routes[$path_array[$i]];
					}
					elseif($regex_match != '')
					{
                        $arg = preg_replace('/{(.*)}/', '$1', $matched_key);
                        $args[$arg] = $path_array[$i];

						if(is_array($routes[$matched_key]) && !empty($routes[$matched_key]))
						{
							$controller_name = $routes[$matched_key]['controller'];							
							$routes = $routes[$matched_key]['actions'];	
						}
						else
							$function = $routes[$matched_key];
					}
					else
						break;						
					
					$i++;
				}

				if(($function == '') && isset($routes['']) && ($i == count($path_array)))
				{
					$function = $routes[''];
				}
			}
			elseif(count($path_array) == 1)
			{
				$controller_name = "HomeController";
				$controller = new $controller_name($app_container);
				$function = "index";
			}

			if($controller_name == '' || $function == '')
			{
				return $res
			            ->withStatus(404)
			            ->write("404: Page Not Found.");				
			}
			else
			{
				$controller = new $controller_name($app_container);
				$result = $controller->executeAction($function, $args, $params);

				return $result;

			}


		});
	}
}

?>