<?php

class OperationsService extends Service
{
	public function createJob($job_data)
	{
		$this->service_url = $this->base_url.'/jobs/create';
		$this->post_data = $job_data;
		return $this->connect();
	}

	public function update($job_data)
	{
		$this->service_url = $this->base_url.'/jobs/update';
		$this->post_data = $job_data;
		return $this->connect();
	}	

	public function get($seo_title)
	{
		$this->service_url = $this->base_url.'/jobs/'.$seo_title;
		return $this->connect();
	}

	public function delete($seo_title)
	{
		$this->service_url = $this->base_url.'/jobs/'.$seo_title.'/delete';
		$this->post_data = array("post" => true);
		return $this->connect();
	}	

	public function save($seo_title)
	{
		$this->service_url = $this->base_url.'/jobs/'.$seo_title.'/save';
		$this->post_data = array("post" => true);
		return $this->connect();
	}	

	public function unsave($seo_title)
	{
		$this->service_url = $this->base_url.'/jobs/'.$seo_title.'/unsave';
		$this->post_data = array("post" => true);
		return $this->connect();
	}			

	public function getJobs($send_active = false)
	{
		$this->service_url = $this->base_url.'/jobs?send_active='.$send_active;
		return $this->connect();
	}

	public function getMyJobs()
	{
		$this->service_url = $this->base_url.'/jobs/me';
		return $this->connect();
	}	
}

?>