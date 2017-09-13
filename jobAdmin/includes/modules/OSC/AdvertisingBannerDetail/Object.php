<?php

namespace OSC\AdvertisingBannerDetail;

use
	Aedea\Core\Database\StdObject as DbObj
;

class Object extends DbObj {
		
	protected
		$advertisingBannerId
		, $name
		, $adList
	;
	
	public function toArray( $params = array() ){
		$args = array(
			'include' => array(
				'id',
				'advertising_banner_id',
				'name'
			)
		);

		return parent::toArray($args);
	}

	public function load( $params = array() ){
		$q = $this->dbQuery("
			SELECT
				advertising_banner_id,
				name
			FROM
				advertising_detail
			WHERE
				id = '" . (int)$this->getId() . "'	
		");

		if( ! $this->dbNumRows($q) ){
			throw new \Exception(
				"404: Advertising not found",
				404
			);
		}
		
		$this->setProperties($this->dbFetchArray($q));
	}
	
	public function delete(){
		if( !$this->getId() ) {
			throw new Exception("delete method requires id to be set");
		}
		$this->dbQuery("
			DELETE FROM
				advertising_detail
			WHERE
				advertising_banner_id = '" . (int)$this->getId() . "'
		");
	}

	public function update(){
		if( !$this->getId() ) {
			throw new Exception("save method requires id");
		}		
		$this->dbQuery("
			UPDATE
				advertising_detail
			SET
				advertising_detail = '" . $this->getAdvertisingBannerId() . "',
			WHERE
				id = '" . (int)$this->getId() . "'
		");		
	}

	public function insert()
	{
		$this->dbQuery("
			INSERT INTO
				advertising_detail
			(
				advertising_banner_id,
				name,
				create_date
			)
				VALUES
			(
				'" . (int)$this->getAdvertisingBannerId() . "',
				'" . $this->getName() . "',
				NOW()
			)
		");
		$this->setId($this->dbInsertId());
	}

	public function setAdvertisingBannerId( $string ){
		$this->advertisingBannerId = (int)$string;
	}

	public function getAdvertisingBannerId(){
		return $this->advertisingBannerId;
	}

	public function setAdListId( $string ){
		$this->adListId = (int)$string;
	}

	public function getAdListId(){
		return $this->adListId;
	}
	
	public function setName( $string ){
		$this->name = (string)$string;
	}

	public function getName(){
		return $this->name;
	}
	
}
