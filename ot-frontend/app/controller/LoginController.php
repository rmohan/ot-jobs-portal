<?php
//session_start();
//require_once (__DIR__ . '/../../vendor/facebook/php-sdk-v4/src/Facebook/autoload.php');

class LoginController extends Controller
{
    private $login_service;

    public function __construct($container = NULL)
    {
        parent::__construct($container);
        $this->login_service = $this->container->get('login_service');
    }

	public function login()
	{
		$this->rules = [
            'source' => [
                'required' => true
            ],
            'social_access_token' => [
                'required' => true
            ]
        ];

        try 
        {
        	$this->validateRequest();
        } 
        catch (Exception $e) 
        {
        	return $this->response->withStatus(400)->write($e->getMessage());
        }

        if ($this->request_params['source'] !== 'facebook' && $this->request_params['source'] !== 'google') {
        	return $this->response->withStatus(400)->write('Invalid `source`. Should be facebook | google');
        }

        $result = $this->login_service->login($this->request_params);
//var_dump($result); exit();
        return $this->response->withJson($result);

	}

	public function facebook()
	{

		$fb = new Facebook\Facebook([
		    'app_id' => $this->container->get('fb_params')['facebook_app_id'],
		    'app_secret' => $this->container->get('fb_params')['facebook_app_secret'],
		    'default_graph_version' => 'v2.8',
		    ]);

		$callback = $this->container->('site_base_url').'/login/fb_callback';

		$helper = $fb->getRedirectLoginHelper();

        $_SESSION['FBRLH_state']=$_GET['state'];

		$login_url = $helper->getLoginUrl($callback, ['email']);

		return $this->response->withHeader('Location', $login_url);
	}

	public function logout()
	{
		$result = $this->login_service->logout();

		session_destroy();

        return $this->response->withJson($result);
	}

	public function fb_callback()
	{

		$fb = new Facebook\Facebook([
		    'app_id' => $this->container->get('fb_params')['facebook_app_id'],
		    'app_secret' => $this->container->get('fb_params')['facebook_app_secret'],
		    'default_graph_version' => 'v2.8',
		    ]);

		$helper = $fb->getRedirectLoginHelper();

		$callback = $this->container->('site_base_url').'/login/fb_callback';

		try {
		    $accessToken = $helper->getAccessToken($callback);
		} catch (Facebook\Exceptions\FacebookResponseException $e) {
		    // When Graph returns an error
		    return $this->response->write('Graph returned an error: ' . $e->getMessage());

		} catch (Facebook\Exceptions\FacebookSDKException $e) {
		    // When validation fails or other local issues
		    return $this->response->write('Facebook SDK returned an error: ' . $e->getMessage());
		}

		if(!isset($accessToken))
			$accessToken = '';

		return $this->render("fbcallback.php", array("accessToken" => $accessToken));

	}
}

?>