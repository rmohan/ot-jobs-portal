<?php

class Controller
{
	protected $args;
	protected $params;
	protected $container;
	protected $query_builder;
	protected $request;
	protected $rules;
	protected $request_params;

	public function __construct($container = NULL)
	{
		$this->container = $container;
		$this->query_builder = $this->container->get('querybuilder');
		$this->request = $this->container->get('request');
	}

	public function validateRequest($extra_request_params = []) 
	{
		if($this->request->getMethod() == 'GET')
		{
			$request_params = $this->request->getQueryParams();
		}
        else 
        {
            $request_params = $this->request->getParsedBody();
        }

        if(!isset($request_params))
            $request_params = [];
        
        $request_params = array_merge($request_params, $extra_request_params);

        foreach ($this->rules as $param => $rule) 
        {
            if (isset($rule['required']) && $rule['required']) 
            {
                if (!isset($request_params[$param]) || empty($request_params[$param])) 
                {
                    return $this->throwError($param . ' is Required');
                }
            }
            if (isset($rule['enum'])) 
            {
                if (isset($request_params[$param]) && !in_array($request_params[$param], $rule['enum'])) 
                {
                    return $this->throwError($param . ' Value not allowed');
                }
            }
            //set type for sanitizing the request parameters
            if (isset($rule['type'])) 
            {
                if (isset($request_params[$param]) && !empty($request_params[$param])) 
                {
                    switch ($rule['type']) 
                    {
                        case 'string':
                            $request_params[$param] = trim($request_params[$param]);
                            $request_params[$param] = addslashes($request_params[$param]);
                            break;
                        case 'integer':
                            if (!(is_numeric($request_params[$param]) && (int) $request_params[$param] == $request_params[$param])) 
                            {
                                return $this->throwError($param . ' value must be integer');
                            }                            
                            break;
                        case 'float':
                            if (!is_numeric($request_params[$param]))
                            {
                                return $this->throwError($param . ' value must be a number');
                            }
                            break;
                            
                        case 'array':
                            if (!is_array($request_params[$param])) 
                            {
                                return $this->throwError($param . ' value must be a array');
                            }
                            break;   

                        case 'date':
                            //var_dump(date(strtotime($request_params[$param])));
                        	$request_params[$param] = date('Y-m-d H:i:s', strtotime($request_params[$param]));//DateTime::createFromFormat('Y-m-d H:i:s', $request_params[$param]);
    						/*if (!$d || $d->format('Y-m-d H:i:s') !== $request_params[$param])
    						{
    							return $this->throwError($param . ' value must be a date of form Y-m-d H:i:s');
    						}*/
    						break;
                    }
                }
            }
        }
        $this->request_params = $request_params;
    }

	public function executeAction($action, $args = NULL, $params = NULL)
    {
        /*if (!is_array($action)) {
            $actionMethod = $action;
        } else {
            $actionMethod = $action['actionName'];
            $this->response->setResponseConfig($action);
        }*/
        
        //$this->checkAccess($action);
        
        if (isset($args)) 
        {
            $this->args = $args;
        }

        if (isset($params)) 
        {
            $this->params = $params;
            //$this->setLimit($params);
            //$this->setOffset($params);
        }

        if (!method_exists($this, $action)) 
        {
            throw new Exception('No corresponding class method defined with name: ' . $actionMethod, 481, false);
        }
        
        return $this->$action();
        
    }

    private function checkAccess($action)
    {
        $rules = $this->denyAccessRules();
        //$user_role = $this->userState;
        if (isset($rules[$action])) {
            /*if ($rules[$action] === 'user' && $userState->getIsGuest()) {
                throw new Exception('You are not allowed to access this endpoint', Constants::$errorCodes['NOT_AUTHORIZED'], false);
            }*/
        }
    }    

    protected function throwError($message)
    {
    	throw new Exception($message);
    }
}

?>