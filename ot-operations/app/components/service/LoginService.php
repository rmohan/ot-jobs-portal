<?php

class LoginService extends Service
{

	public function getUserData($token)
	{
		$this->service_url = $this->base_url.'/user/data';
		$this->auth_token = $token;
		
		return $this->connect();
	}
	
}

?>