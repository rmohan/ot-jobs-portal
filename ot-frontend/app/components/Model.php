<?php

class Model
{
	protected $renderer;
	protected $table_name;
	//protected $fields;

	public function __construct($container)
	{
		//$this->renderer = $container->get('renderer');
	}

	public function setFields($params)
	{		
		foreach ($this->fields as $key => $field) 
		{
			if(isset($params[$field]) && !empty($params[$field]))
			{
				$this->$field = $params[$field];
			}		
		}
	}

}

?>