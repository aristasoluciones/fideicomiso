<?php 

class Task extends Step
{
	private $taskId;
	public function setTaskId($value)
	{
		$this->Util()->ValidateInteger($value);
		$this->taskId = $value;
	}


	private $diaVencimiento;
	public function setDiaVencimiento($value)
	{
		$this->Util()->ValidateInteger($value, 31, 1);
		$this->diaVencimiento = $value;
	}

	private $prorroga;
	public function setProrroga($value)
	{
		$this->Util()->ValidateInteger($value, 365, 0);
		$this->prorroga = $value;
	}
	
	private $nombreTask;
	public function setNombreTask($value)
	{
		$this->Util()->ValidateString($value, 255, 1, 'Nombre');
		$this->nombreTask = $value;
	}

	public function getNombreTask()
	{
		return $this->nombreTask;
	}

	private $control;
	public function setControl($value)
	{
		$this->Util()->ValidateString($value, 255, 1, 'Control Uno');
		$this->control = $value;
	}

	private $control2;
	public function setControl2($value)
	{
		$this->Util()->ValidateString($value, 255, 0, 'Control Dos');
		$this->control2 = $value;
	}

	private $control3;
	public function setControl3($value)
	{
		$this->Util()->ValidateString($value, 255, 0, 'Control Tres');
		$this->control3 = $value;
	}


	public function Enumerate()
	{
		global $months;
		
		$this->Util()->DB()->setQuery("SELECT * FROM step 
			LEFT JOIN servicio ON step.servicioId = servicio.servicioId
				WHERE step.servicioId = '".$this->getServicioId()."'					
				ORDER BY step.stepId ASC");
		$result = $this->Util()->DB()->GetResult();
		foreach($result as $key => $value)
		{
			//get tasks
			$this->Util()->DB()->setQuery("SELECT * FROM task
				WHERE stepId = '".$value["stepId"]."'					
				ORDER BY taskId ASC");
			$result[$key]["tasks"] = $this->Util()->DB()->GetResult();
			$result[$key]["countTasks"] = count($result[$key]["tasks"]);
			
		}
		
		return $result;
	}

	public function Info()
	{
		$this->Util()->DB()->setQuery("SELECT * FROM task WHERE taskId = '".$this->taskId."'");
		$row = $this->Util()->DB()->GetRow();
		
		return $row;
	}

	public function Edit()
	{
		if($this->Util()->PrintErrors()){ return false; }

//print_r($this);
		$this->Util()->DB()->setQuery("
			UPDATE
				task
			SET
				`nombreTask` = '".$this->nombreTask."',
				`diaVencimiento` = '".$this->diaVencimiento."',
				`prorroga` = '".$this->prorroga."',
				`control` = '".$this->control."',
				`control2` = '".$this->control2."',
				`control3` = '".$this->control3."'
			WHERE taskId = '".$this->taskId."'");
		$this->Util()->DB()->UpdateData();

		$this->Util()->setError(1, "complete");
		$this->Util()->PrintErrors();
		return true;
	}

	public function Save()
	{
		if($this->Util()->PrintErrors()){ return false; }

		$this->Util()->DB()->setQuery("
			INSERT INTO
				task
			(
				`stepId`,
				`nombreTask`,
				`diaVencimiento`,
				`prorroga`,
				`control`,
				`control2`,
				`control3`
		)
		VALUES
		(
				'".$this->getStepId()."',
				'".$this->nombreTask."',
				'".$this->diaVencimiento."',
				'".$this->prorroga."',
				'".$this->control."',
				'".$this->control2."',
				'".$this->control3."'
		);");
		$this->Util()->DB()->InsertData();
		$this->Util()->setError(2, "complete");
		$this->Util()->PrintErrors();
		return true;
	}

	public function Delete()
	{
		if($this->Util()->PrintErrors()){ return false; }
		
		$info = $this->Info();
		
		$this->Util()->DB()->setQuery("
			DELETE FROM 
				task
			WHERE
				taskId = '".$this->taskId."'");
		$this->Util()->DB()->DeleteData();
		$this->Util()->setError(3, "complete", $complete);
		$this->Util()->PrintErrors();
		return true;
	}

}

?>