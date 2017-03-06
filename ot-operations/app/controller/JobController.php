<?php

class JobController extends Controller
{

	private function _generate_seo_title($title)
	{
		$seo_title = strtolower(str_replace(' ', '-', $title));
		$seo_title = preg_replace('/[^A-Za-z0-9\-]/', '', $seo_title);
		$seo_title = preg_replace('/-+/', '-', $seo_title); 

		// hash is being generated to ensure that seo-title remains unique
		$hash = substr(md5(time()), 0, 6);

		return $seo_title.'-'.$hash;
	}

	public function create()
	{
        if(!$this->container->user_state->getIsAdmin())
        {
            return array('status' => 403, 'content' => array('Error' => 'Permission Denied'));
        }

		$this->rules = [
            'title' => [
                'required' => true,
                'type' => 'string'
            ],
            'description' => [
                'required' => true,
                'type' => 'string'
            ],
            'start_date' => [
                'required' => false,
                'type' => 'date'
            ],
            'end_date' => [
                'required' => false,
                'type' => 'date'
            ],
            'landing_page_url' => [
                'required' => false,
                'type' => 'string'
            ],
            'priority' => [
                'required' => false,
                'type' => 'integer'
            ]
        ];

        try 
        {
        	$this->validateRequest();
        } 
        catch (Exception $e) 
        {
        	return array('status' => 400, 'content' => array('Error' => $e->getMessage()));
        }


        $user = $this->container->user_state->getUserData();

        $this->request_params['seo_title'] = $this->_generate_seo_title($this->request_params['title']); 
        $this->request_params['added_by_admin'] = $user['user_id'];
        $this->request_params['is_active'] = 1;

		$job_model = new Job($this->query_builder);
		$job_model->setFields($this->request_params);

		$job_model->save();

		return array('status' => 200, 'content' => array('success' => 'true'));
	}

	public function update()
	{
		if(!$this->container->user_state->getIsAdmin())
        {
            return array('status' => 403, 'content' => array('Error' => 'Permission Denied'));
        }

        $this->rules = [
            'seo_title' => [
                'required' => true,
                'type' => 'string'            
            ],
            'title' => [
                'required' => true,
                'type' => 'string'
            ],
            'description' => [
                'required' => true,
                'type' => 'string'
            ],
            'start_date' => [
                'required' => false,
                'type' => 'date'
            ],
            'end_date' => [
                'required' => false,
                'type' => 'date'
            ],
            'landing_page_url' => [
                'required' => false,
                'type' => 'string'
            ],
            'priority' => [
                'required' => false,
                'type' => 'integer'
            ]
        ];

        try 
        {
            $this->validateRequest();
        } 
        catch (Exception $e) 
        {
            return array('status' => 400, 'content' => array('Error' => $e->getMessage()));
        }

        $job_model = new Job($this->query_builder);
        $job_model->setFields($this->request_params);

        $job_model->updateWhere('seo_title', $this->request_params['seo_title']);
        

        return array('status' => 200, 'content' => array('success' => 'true'));
	}

	public function get()
	{

        if(!$this->container->user_state->getIsAdmin())
        {
            return array('status' => 403, 'content' => array('Error' => 'Permission Denied'));
        }

        $this->rules = [
            'seo_title' => [
                'required' => true,
                'type' => 'string'            
            ]
        ];

        try 
        {
            $this->validateRequest($this->args);
        } 
        catch (Exception $e) 
        {
            return array('status' => 400, 'content' => array('Error' => $e->getMessage()));
        }

        $job_model = new Job($this->query_builder);
        $data = $job_model->findByKey('seo_title', $this->request_params['seo_title']);

		return array('status' => 200, 'content' => array('job' => $data));
	}

	public function getAll()
	{
        $job_model = new Job($this->query_builder);

        if(isset($this->params['send_active']) && ($this->params['send_active']) && $this->container->user_state->getIsAdmin())
        {
            $jobs = $job_model->getAll();
        }
        elseif (!$this->container->user_state->getIsGuest()) 
        {
            $user = $this->container->user_state->getUserData();

            $jobs = $job_model->getActiveExceptSaved($user['user_id']);
        }
        else
        {
            $jobs = $job_model->getActive();
        }   
        
		return array('status' => 200, 'content' => array('jobs' => $jobs));
	}

	public function getSaved()
	{
		$job_model = new Job($this->query_builder);
        
        if($this->container->user_state->getIsGuest())
        {
            $jobs = [];
        }
        else
        {
            $user = $this->container->user_state->getUserData();
            
            $jobs = $job_model->getActiveSaved($user['user_id']);
        }   
        
        return array('status' => 200, 'content' => array('jobs' => $jobs));
	}

	public function delete()
	{
        if(!$this->container->user_state->getIsAdmin())
        {
            return array('status' => 403, 'content' => array('Error' => 'Permission Denied'));
        }

        $this->rules = [
            'seo_title' => [
                'required' => true,
                'type' => 'string'            
            ]
        ];

        try 
        {
            $this->validateRequest($this->args);
        } 
        catch (Exception $e) 
        {
            return array('status' => 400, 'content' => array('Error' => $e->getMessage()));
        }

        $this->request_params['is_active'] = 0;

        $job_model = new Job($this->query_builder);
        $job_model->setFields($this->request_params);        

        $job_model->updateWhere('seo_title', $this->request_params['seo_title']);

        return array('status' => 200, 'content' => array('success' => 'true'));
	}

	public function saveUserJob()
	{
		
        if($this->container->user_state->getIsGuest())
        {
            return array('status' => 403, 'content' => array('Error' => 'Permission Denied'));
        }

        $this->rules = [
            'seo_title' => [
                'required' => true,
                'type' => 'string'            
            ]
        ];

        try 
        {
            $this->validateRequest($this->args);
        } 
        catch (Exception $e) 
        {
            return array('status' => 400, 'content' => array('Error' => $e->getMessage()));
        }

        $job_model = new Job($this->query_builder);
        $data = $job_model->findByKey('seo_title', $this->request_params['seo_title']);

        $user = $this->container->user_state->getUserData();

        if(isset($data['id']) && isset($user['user_id']))
        {
            $uj_model = new UserJobs($this->query_builder);
            $uj_model->setFields(array('user_id' => $user['user_id'], 'job_id' => $data['id']));
            $uj_model->save();
        }

        return array('status' => 200, 'content' => array('success' => 'true'));
	}

	public function unsaveUserJob()
	{
        if($this->container->user_state->getIsGuest())
        {
            return array('status' => 403, 'content' => array('Error' => 'Permission Denied'));
        }

        $this->rules = [
            'seo_title' => [
                'required' => true,
                'type' => 'string'            
            ]
        ];

        try 
        {
            $this->validateRequest($this->args);
        } 
        catch (Exception $e) 
        {
            return array('status' => 400, 'content' => array('Error' => $e->getMessage()));
        }

        $job_model = new Job($this->query_builder);
        $data = $job_model->findByKey('seo_title', $this->request_params['seo_title']);

        $user = $this->container->user_state->getUserData();

        if(isset($data['id']) && isset($user['user_id']))
        {
            $uj_model = new UserJobs($this->query_builder);
            $uj_model->delete(array('user_id' => $user['user_id'], 'job_id' => $data['id']));
        }

        return array('status' => 200, 'content' => array('success' => 'true'));
	}
}

?>