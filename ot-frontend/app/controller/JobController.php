<?php

class JobController extends Controller
{
	private $ops_service;

    public function __construct($container = NULL)
    {
        parent::__construct($container);
        $this->ops_service = $this->container->get('operations_service');
    }
    
    public function all()
    {
        $jobs = $this->ops_service->getJobs();
        
        if(isset($jobs) && !empty($jobs))
        {
            $args['jobs'] = $jobs['jobs'];
        }
        return $this->response->withJson($args);
        //return $this->render("home.php", $args);
    }

    public function saved()
    {
        $jobs = $this->ops_service->getMyJobs();
        
        if(isset($jobs) && !empty($jobs))
        {
            $args['jobs'] = $jobs['jobs'];
        }
        return $this->response->withJson($args);
        //return $this->render("home.php", $args);
    }    
}

?>