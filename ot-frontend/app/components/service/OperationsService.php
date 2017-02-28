<?php

class OperationsService extends Service
{
	public function getJobs()
	{
		$this->service_url = $this->base_url.'/jobs';
		return $this->connect();
	}

	public function getMyJobs()
	{
		$this->service_url = $this->base_url.'/jobs/me';
		return $this->connect();
	}	
}

?>