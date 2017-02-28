<?php

class Job extends Model
{
	
	protected $fields = ['title', 'description', 'seo_title', 'company_id', 'start_date', 'end_date'];

	public function __construct($query_builder)
	{
		parent::__construct($query_builder, 'job');	
	}
	
}

?>