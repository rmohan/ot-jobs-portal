<?php

class UserJobs extends Model
{
	
	protected $fields = ['user_id', 'job_id'];

	public function __construct($query_builder)
	{
		parent::__construct($query_builder, 'user_jobs');	
	}
	
}

?>