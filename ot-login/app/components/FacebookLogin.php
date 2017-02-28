<?php

use Facebook\Facebook;

class FacebookLogin extends SocialLogin
{

    public function __construct($container, $access_token)
    {
        $this->container = $container;
        $this->app_id = $container->get('fb_params')['facebook_app_id'];
        $this->app_secret = $container->get('fb_params')['facebook_app_secret'];
        $this->token = $access_token;

        $this->fb = $this->initFacebookAuth();

        $this->initiateLogin();
    }

    private function initFacebookAuth()
    {      
        return new Facebook([
            'app_id' => $this->app_id,
            'app_secret' => $this->app_secret,
            'default_graph_version' => 'v2.8',
        ]);
    }

    public function initiateLogin()
    {
        $this->getProfileData();
        $this->processData();
    }

    protected function getProfileData()
    {
        try {
            // Returns a `Facebook\FacebookResponse` object
            $response = $this->fb->get('/me?fields=id,email,first_name,last_name,picture.type(large)', $this->token);
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            throw new \Exception('Error fetching User data', 400);
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            throw new \Exception('Error fetching User data', 400);
        }
        $graph_object = $response->getGraphObject();
        $this->data['profile_data'] = $graph_object->asArray();
    }

    protected function processData()
    {
        $user = [];
        $data = $this->data;

        if (isset($data['profile_data']['email']) === false) {
            throw new ExceptionHandler('SignUp was not successfull. Please try some other method.', 400, true);
        }

        $user['first_name'] = $data['profile_data']['first_name'] ?? null;
        $user['last_name'] = $data['profile_data']['last_name'] ?? null;
        $user['email'] = $data['profile_data']['email'];
        $user['image_url'] = isset($data['profile_data']['id']) ? 'https://graph.facebook.com/' . $data['profile_data']['id'] . '/picture' : null;
        $user['signup_mode'] = "facebook";
        $this->user_array = $user;

    }
}
