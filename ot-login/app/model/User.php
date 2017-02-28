<?php

class User extends Model
{
	
	protected $fields = ['email', 'role_id', 'first_name', 'last_name', 'image_url', 'signup_mode'];

	public function __construct($query_builder)
	{
		parent::__construct($query_builder, 'user');	
	}

	public function findByEmail($email)
	{
		$data = $this->findByKey('email', $email);

		if($data && !empty($data))
			return $data;

		return false;
	}

	public function findById($id)
	{
		$data = $this->findByKey('id', $id);

		if($data && !empty($data))
			return $data;

		return false;
	}
	
}

?>