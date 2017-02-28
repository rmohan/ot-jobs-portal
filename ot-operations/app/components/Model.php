<?php

class Model
{
	protected $query_builder;
	protected $table_name;
	//protected $fields;

	public function __construct($query_builder, $table)
	{
		$this->query_builder = $query_builder;
		$this->table_name = $table;
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

	public function save()
	{
		
		foreach ($this->fields as $key => $field) 
		{
			$insert_array[$field] = ':'.$field;			
		}

		$stmt = $this->query_builder->insert($this->table_name)->values($insert_array);

		foreach ($this->fields as $key => $field) 
		{
			if(isset($this->$field) && !empty($this->$field))
			{
				//$param_array[$field] = $this->$field;	
				$stmt->setParameter($field, $this->$field);
			}
			else
			{
				//$param_array[$field] = NULL;
				$stmt->setParameter($field, NULL);
			}
		}
		//var_dump($param_array);

		$data = $stmt->execute();
	}
}

?>