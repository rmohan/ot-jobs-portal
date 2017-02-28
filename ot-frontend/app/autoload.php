<?php

function ot_frontend_autoload($class)
{
	$controller_file = dirname(__FILE__) . '/controller/'.$class.'.php';
	if(file_exists($controller_file))
	{
		require ($controller_file);
	}

	$model_file = dirname(__FILE__) . '/model/'.$class.'.php';
	if(file_exists($model_file))
	{
		require ($model_file);
	}

	$component_file = dirname(__FILE__) . '/components/'.$class.'.php';
	if(file_exists($component_file))
	{
		require ($component_file);
	}

	$service_file = dirname(__FILE__) . '/components/service/'.$class.'.php';
	if(file_exists($service_file))
	{
		require ($service_file);
	}

	$file = dirname(__FILE__).'/'.$class.'.php';
	if(file_exists($file))
	{
		require ($file);
	}
}

spl_autoload_register('ot_frontend_autoload');