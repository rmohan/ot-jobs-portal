<?php

class Job extends Model
{
	
	protected $fields = ['title', 'description', 'seo_title', 'start_date', 'end_date', 'added_by_admin', 'priority', 'landing_page_url', 'is_active'];

	public function __construct($query_builder)
	{
		parent::__construct($query_builder, 'job');	
	}

	public function getAll()
	{
		$stmt = $this->query_builder->select('title,seo_title,start_date,end_date,is_active')->from($this->table_name);
		$data = $stmt->execute()->fetchAll();
		return $data;
	}

	public function getActive()
	{
		$stmt = $this->query_builder->select('title,seo_title,description')->from($this->table_name);

		$stmt = $stmt->where(
						$this->query_builder->expr()->andX(
				            $this->query_builder->expr()->eq('is_active', '1'),
				            $this->query_builder->expr()->lte('start_date', 'NOW() or start_date is NULL'),
				            $this->query_builder->expr()->gte('end_date', 'NOW() or end_date is NULL')

			        ));
		
		$data = $stmt->execute()->fetchAll();
		return $data;
	}

	public function getActiveExceptSaved($user_id)
	{
		$stmt = $this->query_builder->select('title,seo_title,description')->from($this->table_name, 'j')->leftJoin('j', 'user_jobs', 'uj', 'j.id = uj.job_id');

		$stmt = $stmt->where(
						$this->query_builder->expr()->andX(
				            $this->query_builder->expr()->eq('j.is_active', '1'),
				            $this->query_builder->expr()->lte('j.start_date', 'NOW() or j.start_date is NULL'),
				            $this->query_builder->expr()->gte('j.end_date', 'NOW() or j.end_date is NULL'),
				            $this->query_builder->expr()->neq('user_id is NULL or user_id', '?')
			        ));

		$stmt = $stmt->setParameter(0, $user_id);

		//var_dump($this->query_builder->getSQL());var_dump($stmt);exit();
		
		$data = $stmt->execute()->fetchAll();
		return $data;
	}

	public function getActiveSaved($user_id)
	{
		$stmt = $this->query_builder->select('title,seo_title,description')->from($this->table_name, 'j')->leftJoin('j', 'user_jobs', 'uj', 'j.id = uj.job_id');

		$stmt = $stmt->where(
						$this->query_builder->expr()->andX(
				            $this->query_builder->expr()->eq('j.is_active', '1'),
				            $this->query_builder->expr()->lte('j.start_date', 'NOW() or j.start_date is NULL'),
				            $this->query_builder->expr()->gte('j.end_date', 'NOW() or j.end_date is NULL'),
				            $this->query_builder->expr()->eq('user_id', '?')
			        ));

		$stmt = $stmt->setParameter(0, $user_id);

		//var_dump($this->query_builder->getSQL());var_dump($stmt);exit();
		
		$data = $stmt->execute()->fetchAll();
		return $data;
	}	
	
}

?>