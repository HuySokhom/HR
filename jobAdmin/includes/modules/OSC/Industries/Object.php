<?php

namespace OSC\Industries;

use
	Aedea\Core\Database\StdObject as DbObj
;

class Object extends DbObj {
		
	protected
		$name,
		$description
	;
	
	public function toArray( $params = array() ){
		$args = array(
			'include' => array(
				'id',
				'name',
				'description'
			)
		);

		return parent::toArray($args);
	}
	
	public function load( $params = array() ){
		$q = $this->dbQuery("
			SELECT
				name,
				description
			FROM
				industries
			WHERE
				id = '" . (int)$this->getId() . "'	
		");
		
		if( ! $this->dbNumRows($q) ){
			throw new \Exception(
				"404: industries not found",
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
				industries
			SET 
				name = '" .  $this->getTitle() . "',
				description = '" .  $this->getDescription() . "',
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
				industries
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
				industries
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
				industries
			(
				name,
				description,
				create_by,
				status,
				create_date
			)
				VALUES
			(
 				'" . $this->getName() . "',
 				'" . $this->getDescription() . "',
 				'" . $this->getCreateBy() . "',
 				1,
 				NOW()
			)
		");
	}

	public function setName( $string ){
		$this->name = (string)$string;
	}
	
	public function getName(){
		return $this->name;
	}

	public function setDescription( $string ){
		$this->description = (string)$string;
	}
	
	public function getDescription(){
		return $this->description;
	}
}
