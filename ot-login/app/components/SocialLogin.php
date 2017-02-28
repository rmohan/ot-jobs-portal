<?php 

class SocialLogin
{

    public $token;
    public $user_array = [];
    public $data = [];
    public $app_id;
    public $app_secret;
    protected $container;

    public function getUserData()
    {
        return $this->user_array;
    }

    public function processSocialLogin()
    {

        $user_model = new User($this->container->get('querybuilder'));
        $user = $user_model->findByEmail($this->user_array['email']);

        $new_user = false;

        if ($user === false) {
            $this->user_array['role_id'] = '1'; //default to user-role; override manually or admin panel
            $user_model->setFields($this->user_array);            
            $user_model->save();            
            $new_user = true;
            $user = $user_model->findByEmail($this->user_array['email']);
        }
    
        return array('user_id' => $user['id']);
    }

}
