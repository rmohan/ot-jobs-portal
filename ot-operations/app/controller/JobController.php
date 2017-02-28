<?php

class JobController extends Controller
{

    const ADMIN_ROLE_ID = 2;

	protected function denyAccessRules()
    {
        return [
            'create' => 'user',
            'update' => 'user',
            'delete' => 'user'
        ];
    }

	private function _generate_seo_title($title, $company_id)
	{
		$seo_title = strtolower(str_replace(' ', '-', $title));
		$seo_title = preg_replace('/[^A-Za-z0-9\-]/', '', $seo_title);
		$seo_title = preg_replace('/-+/', '-', $seo_title); 

		// hash is being generated to ensure that seo-title remains unique
		$hash = substr(md5($company_id.time()), 0, 6);

		return $seo_title.'-'.$hash;
	}

	public function create()
	{
		$this->rules = [
            'company_id' => [
                'required' => true,
                'type' => 'integer'
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


        $this->request_params['seo_title'] = $this->_generate_seo_title($this->request_params['title'], $this->request_params['company_id']); 


		$job_model = new Job($this->query_builder);
		$job_model->setFields($this->request_params);
		$job_model->save();

		return array('status' => 200, 'content' => array('data' => 'id'));
	}

	public function update()
	{
		return array("function" => "update");
	}

	public function get()
	{
		return array('status' => 200, 'content' => array("function" => "get"));
	}

	public function getAll()
	{
        $job_model = new Job($this->query_builder);
        
        if($this->container->user_state->getIsGuest())
        {
            $jobs = $job_model->getActive();
        }
        else
        {
            $user = $this->container->user_state->getUserData();

            $jobs = $job_model->getActiveExceptSaved($user['user_id']);
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

	}

	public function saveUserJob()
	{
		return array("function" => "saveUserJob");
	}

	public function unsaveUserJob()
	{

	}
}

?>