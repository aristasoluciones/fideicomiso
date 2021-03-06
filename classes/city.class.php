<?php

class City extends Main
{
	private $stateId;
	private $cityId;	
	private $name;	
	private $active;
	
	public function setStateId($value)
	{
		$this->Util()->ValidateInteger($value);
		$this->stateId = $value;
	}
	
	public function setCityId($value)
	{
		$this->Util()->ValidateInteger($value);
		$this->cityId = $value;
	}
			
	public function setName($value)
	{
		if($this->Util()->ValidateRequireField($value, "Nombre"))
			$this->Util()->ValidateString($value, $max_chars=60, $minChars = 1, "Nombre");
		
		$this->name = $value;
	}
			
	public function Enumerate()
	{		
								
		$sql = "SELECT 
					* 
				FROM 
					city
				WHERE
					stateId = '".$this->stateId."'
				ORDER BY 
					cityId ASC";
		
		$this->Util()->DB()->setQuery($sql);
		$result = $this->Util()->DB()->GetResult();
				
		return $result;
	}
		
	public function Info()
	{
		
		$sql = "SELECT 
					* 
				FROM 
					city 
				WHERE 
					cityId = '".$this->cityId."'";
	
		$this->Util()->DB()->setQuery($sql);
		$info = $this->Util()->DB()->GetRow();
		
		$row = $this->Util->EncodeRow($info);
				
		return $row;
	}
	
	public function Save(){
		
		if($this->Util()->PrintErrors()){ 
			return false; 
		}
		
		$sqlQuery = "INSERT INTO 
					city 
					(
						stateId,										
						name											
					)
				 VALUES 
					(			
						'".$this->stateId."',			
						'".utf8_decode($this->name)."'					
					)";
								
		$this->Util()->DB()->setQuery($sqlQuery);
		$cityId = $this->Util()->DB()->InsertData();
						
		$this->Util()->setError(10035, "complete");
		$this->Util()->PrintErrors();
		
		return true;
				
	}
	
	public function Update(){
		
		if($this->Util()->PrintErrors()){ 
			return false; 
		}
		
		$sql = "UPDATE 
					city 
				SET 
					name =  '".utf8_decode($this->name)."'									
				WHERE 
					cityId = ".$this->cityId;
							
		$this->Util()->DB()->setQuery($sql);
		$this->Util()->DB()->ExecuteQuery();
						
		$this->Util()->setError(10036, "complete");
		$this->Util()->PrintErrors();
		
		return true;
				
	}
	
	public function Delete(){
		
		if($this->Util()->PrintErrors()){ 
			return false; 
		}
		
		$sql = "DELETE FROM 
					city
				WHERE 
					cityId = ".$this->cityId;
							
		$this->Util()->DB()->setQuery($sql);
		$this->Util()->DB()->ExecuteQuery();
										
		$this->Util()->setError(10037, "complete");
		$this->Util()->PrintErrors();
		
		return true;
				
	}
		
	public function GetNameById(){
			
		$sql = 'SELECT 
					name
				FROM 
					city 
				WHERE 
					cityId = '.$this->cityId;
		
		$this->Util()->DB()->setQuery($sql);
		
		return $this->Util()->DB()->GetSingle();
		
	}	
	
}//City

?>