<?php

class HomeController extends Controller
{
	private $ops_service;

	public function __construct($container = NULL)
    {
        parent::__construct($container);
        $this->ops_service = $this->container->get('operations_service');
    }

	public function index()
	{
		//$jobs = $this->ops_service->getJobs();
		
		//if(isset($jobs) && !empty($jobs))
		//{
		//	$args['all_jobs'] = $jobs['jobs'];
		//}
		//return $this->response->withJson($args);
		return $this->render("home.php", []);
	}

}

?>