<?php 

/**
 * Singleton for appwide access to User State
 */
class UserState
{
    const ADMIN_ROLE_ID = 2;
    private static $user_state_instance = null;
    private $is_guest;
    private $user_role;
    private $user_data = null;

    public static function getInstance()
    {
        if (self::$user_state_instance === null) {
            self::$user_state_instance = new UserState();
        }
        return self::$user_state_instance;
    }

    public function getIsGuest()
    {
        return $this->is_guest;
    }

    public function getIsAdmin()
    {
        return ($this->user_role == self::ADMIN_ROLE_ID)? true : false;

    }    

    public function getUserRole()
    {
        return $this->user_role;
    }

    public function setUserState($user_data)
    {

        $this->is_guest = (isset($user_data['is_guest'])) ? $user_data['is_guest'] : true;
        $this->user_role = (isset($user_data['user_role'])) ? $user_data['user_role'] : -1;
        $this->user_data = (isset($user_data['user_data'])) ? $user_data['user_data'] : [];

    }

    public function getUserData()
    {
        if ($this->is_guest) {
            return [];
        }

        return $this->user_data;
    }
}
