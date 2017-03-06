<?php

class JobController extends Controller
{
	private $ops_service;

    public function __construct($container = NULL)
    {
        parent::__construct($container);
        $this->ops_service = $this->container->get('operations_service');
    }

    public function index()
    {
        return $this->render("jobs.php", []);
    }
    
    public function create()
    {
        if($this->request->getMethod() == 'POST')
        {
            $post_data = $this->request->getParsedBody();

            if(isset($post_data['job']))
            {
                $result = $this->ops_service->createJob($post_data['job']);

                return $this->response->withJson($result);
            }
        }

        return $this->render("jobs_create.php", array('action' => '/admin/jobs/create'));
    }

    public function update()
    {
        if($this->request->getMethod() == 'POST')
        {
            $post_data = $this->request->getParsedBody();

            if(isset($post_data['job']) && isset($post_data['job']['seo_title']) && !empty($post_data['job']['seo_title']))
            {
                $result = $this->ops_service->update($post_data['job']);

                return $this->response->withJson($result);
            }
        }

        $job = [];

        if(isset($this->params['id']) && !empty($this->params['id']))
        {
            $job = $this->ops_service->get($this->params['id']);
        }

        $args = $job;
        $args['action'] = '/admin/jobs/update';

        return $this->render("jobs_create.php", $args);
    }

    public function all()
    {
        $args = [];
        $send_inactive = false;

        if(isset($this->params['show_all']) && $this->container->user_state->getIsAdmin())
        {
            $send_inactive = true;
        }
        $jobs = $this->ops_service->getJobs($send_inactive);
        
        if(isset($jobs) && !empty($jobs))
        {
            $args['jobs'] = $jobs['jobs'];
            $args['action'] = 'Save';
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
            $args['action'] = 'Unsave';
        }
        return $this->response->withJson($args);
        //return $this->render("home.php", $args);
    }  

    public function delete()
    {

        if(isset($this->params['id']) && !empty($this->params['id']))
        {
            $job = $this->ops_service->delete($this->params['id']);
        }

        return $this->response->withHeader('Location', $this->container->get('site_base_url').'/admin/jobs');
    }  

    public function save()
    {
        if(isset($this->params['id']) && !empty($this->params['id']))
        {
            $job = $this->ops_service->save($this->params['id']);
        }

        return $this->response->withHeader('Location', $this->container->get('site_base_url'));
    }

    public function unsave()
    {
        if(isset($this->params['id']) && !empty($this->params['id']))
        {
            $job = $this->ops_service->unsave($this->params['id']);
        }

        return $this->response->withHeader('Location', $this->container->get('site_base_url'));
    }
}

?>