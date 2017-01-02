<?php

namespace OSC\Leason;

use
	Aedea\Core\Database\StdObject as DbObj
;

class Object extends DbObj {

	protected
		$fileLeason,
		$title,
		$description
	;
	public function toArray( $params = array() ){
		$args = array(
			'include' => array(
				'id',
				'file_leason',
				'title',
				'description',
				'status'
			)
		);
		return parent::toArray($args);
	}

	public function load( $params = array() ){
		$q = $this->dbQuery("
			SELECT
				title,
				file_leason,
				description,
				status
			FROM
				leason
			WHERE
				id = '" . (int)$this->getId() . "'
		");

		if( ! $this->dbNumRows($q) ){
			throw new \Exception(
				"404: leason not found",
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
				leason
			SET 
				title = '" .  $this->getTitle() . "',
				description = '" .  $this->getDescription() . "',
				file_leason = '" .  $this->getFileLeason() . "',
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
				leason
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
				leason
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
				leason
			(
				file_leason,
				title,
				description,
				create_by,
				status,
				create_date
			)
				VALUES
			(
				'" . $this->getFileLeason() . "',
 				'" . $this->getTitle() . "',
 				'" . $this->getDescription() . "',
 				'" . $this->getCreateBy() . "',
 				1,
 				NOW()
			)
		");
	}

	public function getTitle(){
		return $this->title;
	}
	public function setTitle($string){
		$this->title = $string;
	}

	public function getFileLeason(){
		return $this->fileLeason;
	}
	public function setFileLeason($string){
		$this->fileLeason = $string;
	}

	public function getDescription(){
		return $this->description;
	}
	public function setDescription($string){
		$this->description = $string;
	}

}
