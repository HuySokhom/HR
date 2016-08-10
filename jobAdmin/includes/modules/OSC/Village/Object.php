<?php

namespace OSC\Village;

use
	Aedea\Core\Database\StdObject as DbObj,
	OSC\Commune\Collection as DistrictCol
;

class Object extends DbObj {
		
	protected
		$nameEn
		, $communeId
		, $detail
	;

	public function __construct( $params = array() ){
		parent::__construct($params);
		$this->detail = new DistrictCol();
	}

	public function toArray( $params = array() ){
		$args = array(
			'include' => array(
				'id',
				'name_en',
				'detail'
			)
		);

		return parent::toArray($args);
	}
	
	public function load( $params = array() ){
		$q = $this->dbQuery("
			SELECT
				name_en,
				commune_id
			FROM
				village
			WHERE
				id = '" . (int)$this->getId() . "'	
		");
		
		if( ! $this->dbNumRows($q) ){
			throw new \Exception(
				"404: Village not found",
				404
			);
		}
		
		$this->setProperties($this->dbFetchArray($q));
		$this->detail->setFilter('id', $this->getCommuneId());
		$this->detail->populate();
	}

	public function update() {
		if( !$this->getId() ) {
			throw new Exception("save method requires id");
		}
		$this->dbQuery("
			UPDATE
				village
			SET
				name_en = '" .  $this->getNameEn() . "',
				commune_id = '" .  $this->getCommuneId() . "'
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
				village
			WHERE
				id = '" . (int)$this->getId() . "'
		");
	}

	public function insert(){
		$this->dbQuery("
			INSERT INTO
				village
			(
				name_en,
				commune_id,
				create_date
			)
				VALUES
			(
				'" . $this->getNameEn() . "',
				'" . $this->getCommuneId() . "',
				NOW()
			)
		");
		$this->setId( $this->dbInsertId() );
	}

	public function setNameEn( $string ){
		$this->nameEn = (string)$string;
	}
	
	public function getNameEn(){
		return $this->nameEn;
	}

	public function setCommuneId( $string ){
		$this->communeId = (string)$string;
	}

	public function getCommuneId(){
		return $this->communeId;
	}

	public function setDetail( $string ){
		$this->detail = (string)$string;
	}

	public function getDetail(){
		return $this->detail;
	}

}
