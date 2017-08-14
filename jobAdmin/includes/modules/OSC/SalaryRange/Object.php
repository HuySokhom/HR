<?php

namespace OSC\SalaryRange;

use
	Aedea\Core\Database\StdObject as DbObj
;

class Object extends DbObj {
		
	protected
		$fromSalary,
		$toSalary
	;
	
	public function toArray( $params = array() ){
		$args = array(
			'include' => array(
				'id',
				'from_salary',
				'to_salary'
			)
		);

		return parent::toArray($args);
	}
	
	public function load( $params = array() ){
		$q = $this->dbQuery("
			SELECT
				from_salary,
				to_salary
			FROM
				salary_range
			WHERE
				id = '" . (int)$this->getId() . "'	
		");
		
		if( ! $this->dbNumRows($q) ){
			throw new \Exception(
				"404: salary_range not found",
				404
			);
		}
		
		$this->setProperties($this->dbFetchArray($q));
		
	}
	
	
	public function update() {
		if( !$this->getId() ) {
			throw new Exception("save method requires language id");
		}
		$this->dbQuery("
			UPDATE
				salary_range
			SET 
				from_salary = '" .  $this->getFromSalary() . "',
				to_salary = '" .  $this->getToSalary() . "',
				update_by = '" .  $this->getUpdateBy() . "'
			WHERE
				id = '" . (int)$this->getId() . "'
		");
	}

	public function delete(){
		if( !$this->getId() ) {
			throw new Exception("delete method requires id to be set");
		}
		$this->dbQuery("
			DELETE FROM
				salary_range
			WHERE
				id = '" . (int)$this->getId() . "'
		");
	}

	public function updateStatus() {
		if( !$this->getId() ) {
			throw new Exception("save method requires language id");
		}
		$this->dbQuery("
			UPDATE
				salary_range
			SET
				status = '" .  $this->getStatus() . "',
				update_by = '" .  $this->getUpdateBy() . "'
			WHERE
				id = '" . (int)$this->getId() . "'
		");
	}

	public function insert(){	
		$this->dbQuery("
			INSERT INTO
				salary_range
			(
				from_salary,
				to_salary,
				create_by,
				status,
				create_date
			)
				VALUES
			(
 				'" . $this->getFromSalary() . "',
 				'" . $this->getToSalary() . "',
 				'" . $this->getCreateBy() . "',
 				1,
 				NOW()
			)
		");
	}
	
	public function setToSalary( $string ){
		$this->toSalary = (int)$string;
	}
	
	public function getToSalary(){
		return $this->toSalary;
	}

	public function setFromSalary( $string ){
		$this->fromSalary = (int)$string;
	}
	
	public function getFromSalary(){
		return $this->fromSalary;
	}
	
}
