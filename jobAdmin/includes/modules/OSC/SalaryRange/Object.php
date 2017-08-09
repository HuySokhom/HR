<?php

namespace OSC\SalaryRange;

use
	Aedea\Core\Database\StdObject as DbObj
;

class Object extends DbObj {
		
	protected
		$from,
		$to
	;
	
	public function toArray( $params = array() ){
		$args = array(
			'include' => array(
				'id',
				'from',
				'to'
			)
		);

		return parent::toArray($args);
	}
	
	public function load( $params = array() ){
		$q = $this->dbQuery("
			SELECT
				from,
				to
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
				from = '" .  $this->getTitle() . "',
				to = '" .  $this->getDescription() . "',
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
				from,
				to,
				create_by,
				status,
				create_date
			)
				VALUES
			(
 				'" . $this->getFrom() . "',
 				'" . $this->getTo() . "',
 				'" . $this->getCreateBy() . "',
 				1,
 				NOW()
			)
		");
	}
	
	public function setTo( $string ){
		$this->to = (string)$string;
	}
	
	public function getTo(){
		return $this->to;
	}

	public function setFrom( $string ){
		$this->from = (string)$string;
	}
	
	public function getFrom(){
		return $this->from;
	}
	
}
