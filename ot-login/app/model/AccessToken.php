<?php

class AccessToken extends Model
{

    protected $fields = ['access_token', 'user_id', 'ip_address'];

    public function __construct($query_builder)
    {
        parent::__construct($query_builder, 'access_token_cache'); 
    }

    public function assignToUserId($token, $user_id)
    {
        $params['user_id'] = $user_id;

        $this->setFields($params);

        if(isset($token) && !empty($token))
        {
            $token_string = addslashes($token);
            $this->updateWhere('access_token', $token_string);
        }
        
    }

    public function destroyToken($token)
    {
        if(isset($token) && !empty($token))
        {
            $token = addslashes($token);

            $data = $this->delete('access_token', $token);

            return true;
        }

        return false;
    }

    public function createNewAccessToken($params)
    {
        $new_token = bin2hex(openssl_random_pseudo_bytes(16));

        $params['access_token'] = $new_token;

        $this->setFields($params);
        $this->save();

        return $new_token;
    }

    public function verifyToken($token)
    {
        if(isset($token) && !empty($token))
        {
            $token = addslashes($token);

            $data = $this->findByKey('access_token', $token);

            if($data && !empty($data))
                return $data['user_id'];
        }

        return false;
    }
}
