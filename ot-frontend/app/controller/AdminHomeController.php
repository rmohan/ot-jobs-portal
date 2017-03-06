<?php

class AdminHomeController extends Controller
{

	public function index()
	{
		return $this->render("admin_home.php", []);
	}
	
}

?>