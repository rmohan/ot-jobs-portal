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
			if(isset($params[$field])  && (!empty($params[$field]) || strlen($params[$field])))
			{
				//var_dump($field); var_dump($params[$field]);
				$this->$field = $params[$field];
			}		
		}
	}

	public function save()
	{

		$this->query_builder->resetQueryParts();
		$this->query_builder->setParameters([]);

		foreach ($this->fields as $key => $field) 
		{
			$insert_array[$field] = ':'.$field;			
		}

		$stmt = $this->query_builder->insert($this->table_name)->values($insert_array);

		foreach ($this->fields as $key => $field) 
		{
			if(isset($this->$field)  && (!empty($this->$field) || strlen($this->$field)))
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
//var_dump($this->query_builder->getSQL()); var_dump($stmt);exit();
		$data = $stmt->execute();
	}

	public function updateWhere($column_key, $column_value)
	{
		$this->query_builder->resetQueryParts();
		$this->query_builder->setParameters([]);


		if(!empty($column_key) && !empty($column_value))
		{
			$stmt = $this->query_builder->update($this->table_name)->where($column_key.' = ?');
			
			foreach ($this->fields as $key => $field) 
			{
				if(isset($this->$field)  &&  (!empty($this->$field) || strlen($this->$field)))
				{
					$stmt->set($field, '?');
				}				
			}

			$i = 0;
			foreach ($this->fields as $key => $field) 
			{
				if(isset($this->$field)  && (!empty($this->$field) || strlen($this->$field)))
				{
					$stmt->setParameter($i, $this->$field);
					$i++;
				}	
			}
			$stmt->setParameter($i,$column_value);

			//var_dump($this->query_builder->getSQL()); var_dump($stmt);exit();

			$data = $stmt->execute();
				
		}	
	}

	public function findByKey($column_key, $column_value)
	{
		$this->query_builder->resetQueryParts();
		$this->query_builder->setParameters([]);

		if(!empty($column_key) && !empty($column_value))
		{
			$stmt = $this->query_builder->select('*')->from($this->table_name)->where($column_key.' = ?')->setParameter(0,$column_value);
			$data = $stmt->execute()->fetchAll();

			if(isset($data) && (count($data) == 1) && (!empty($data[0])))
			{
				return $data[0];
			}
				
		}
		return false;
	}

	public function delete($conditions)
	{
		$this->query_builder->resetQueryParts();
		$this->query_builder->setParameters([]);

		if(!empty($conditions))
		{
			$stmt = $this->query_builder->delete($this->table_name); //->where($column_key.' = ?')->setParameter(0,$column_value);
			
			$i = 0;
			foreach ($conditions as $key => $value) {
				$where_clause_array[] = $key." = ?";
				$stmt->setParameter($i, $value);
				$i++;
			}
			$stmt->where(implode(" and ", $where_clause_array));
			
			//var_dump($this->query_builder->getSQL()); var_dump($stmt);exit();
			$data = $stmt->execute();

			if($data)
				return true;
				
		}
		return false;
	}	

}

?>