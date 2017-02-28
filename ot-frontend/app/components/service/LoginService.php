<?php

class LoginService extends Service
{

	public function login($params)
	{
		$this->service_url = $this->base_url.'/user/login';
		$this->post_data = $params;
		return $this->connect();
	}

	public function getUserData()
	{
		$this->service_url = $this->base_url.'/user/data';
		return $this->connect();
	}

	public function getGuestToken()
	{
		$this->service_url = $this->base_url.'/user/guest';
		return $this->connect();
	}

	public function logout()
	{
		$this->service_url = $this->base_url.'/user/logout';
		$this->post_data = array('post' => true);
		return $this->connect();
	}
	
}

?>