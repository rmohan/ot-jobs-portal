<?php

class UserController extends Controller
{
    private $access_token_provider;

    public function __construct($container)
    {
        parent::__construct($container);
        $this->access_token_provider = new AccessToken($this->query_builder);
    }

	public function login()
	{
		$this->rules = [
            'source' => [
                'required' => true,
                'type' => 'string'
            ],
            'social_access_token' => [
                'required' => true,
                'type' => 'string'
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

        if ($this->request_params['source'] === 'facebook') {
            $social_login = new FacebookLogin($this->container, $this->request_params['social_access_token']);
        } else {
            //$socialLogin = new GoogleLogin($this->container, $this->request_params['social_access_token']);
        }

        $data = $social_login->processSocialLogin();

        $this->access_token_provider->assignToUserId($this->container->get('auth_token'), $data['user_id']);

		return array('status' => 200, 'content' => array('success' => 'true'));
	}

	public function logout()
	{
        $token = $this->container->get('auth_token');        
        $this->access_token_provider->destroyToken($token);

		return array('status' => 200, 'content' => array("success" => "true"));
	}

	public function getUserData()
	{

        $token = $this->container->get('auth_token');

        $request_source = $this->container->get('request_source');

        $return_data = [];

        $user = $this->access_token_provider->verifyToken($token);

        if($user && !empty($user))
        {
            $user_model = new User($this->query_builder);
            $user_data = $user_model->findById($user);
            if($user_data && !empty($user_data))
            {
                $return_data['is_guest'] = false;
                $return_data['user_role'] = $user_data['role_id'];
                $return_data['user_data'] = array('name' => $user_data['first_name'], 'profile_image' => $user_data['image_url']);
                if(isset($request_source) && !empty($request_source) && ($request_source == 'OPS'))
                {
                    $return_data['user_data']['user_id'] = $user_data['id'];
                }
            }
            else
            {
                $return_data['is_guest'] = true;
                $return_data['user_role'] = -1;
            }
        }

        return array('status' => 200, 'content' => $return_data);

	}

	public function getGuestToken()
	{
        $this->rules = [
            'ip_address' => [
                'required' => false,
                'type' => 'ip'
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

        $token = $this->access_token_provider->createNewAccessToken($this->request_params);
		return array('status' => 200, 'content' => array("access_token" => $token));
	}
}

?>