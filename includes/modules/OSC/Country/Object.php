<?php

namespace OSC\Country;

use
	Aedea\Core\Database\StdObject as DbObj
;

class Object extends DbObj {

	protected
		$name
	;

	public function toArray( $params = array() ){
		$args = array(
			'include' => array(
				'id',
				'name',
			)
		);
		return parent::toArray($args);
	}

	public function load( $params = array() ){
		$q = $this->dbQuery("
			SELECT
				countries_name as name
			FROM
				countries
			WHERE
				countries_id = '" . (int)$this->getId() . "'
		");

		if( ! $this->dbNumRows($q) ){
			throw new \Exception(
				"404: Countries not found",
				404
			);
		}
		
		$this->setProperties($this->dbFetchArray($q));

	}

	public function setName( $string ){
		$this->name = $string;
	}
	public function getName(){
		return $this->name;
	}

}
