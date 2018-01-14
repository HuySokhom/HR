<?php

namespace OSC\Plan;

use
	Aedea\Core\Database\StdObject as DbObj
;

class Object extends DbObj {

	protected
		$name,
		$price,
		$benefit,
		$sortOrder,
		$displayType
	;

	// public function __construct( $params = array() ){
	// 	parent::__construct($params);
	// 	$this->detail = new ContentCol();
	// }


	public function toArray( $params = array() ){
		$args = array(
			'include' => array(
				'id',
				'name',
				'price',
				'benefit',
				'status',
				'display_type',
				'sort_order'
			)
		);
		return parent::toArray($args);
	}
	
	public function load( $params = array() ){
		$q = $this->dbQuery("
			SELECT
				name,
				price,
				benefit,
				display_type,
				sort_order,
				status
			FROM
				plan
			WHERE
				id = '" . (int)$this->getId() . "'
		");
		
		if( ! $this->dbNumRows($q) ){
			throw new \Exception(
				"404: Plan not found",
				404
			);
		}
		
		$this->setProperties($this->dbFetchArray($q));

		// $this->detail->setFilter('id', $this->getId());
		// $this->detail->populate();
	}
	public function update() {
		if( !$this->getId() ) {
			throw new Exception("save method requires id");
		}
		$this->dbQuery("
			UPDATE
				plan
			SET 
				name = '" .  $this->getName() . "',
				display_type = '" .  $this->getDisplayType() . "',
				price = '" .  $this->getPrice() . "',
				sort_order = '" .  $this->getSortOrder() . "',
				benefit = '" .  $this->getBenefit() . "',
				update_by = '" .  $this->getUpdateBy() . "'
			WHERE
				id = '" . (int)$this->getId() . "'
		");
	}

	public function updateStatus() {
		if( !$this->getId() ) {
			throw new Exception("save method requires id");
		}
		$this->dbQuery("
			UPDATE
				plan
			SET 
				status = '" .  $this->getStatus() . "'
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
				plan
			WHERE
				id = '" . (int)$this->getId() . "'
		");
	}
	
	public function insert(){	
		$this->dbQuery("
			INSERT INTO
				plan
			(
				name,
				display_type,
				benefit,
				price,
				sort_order,
				status,				
				create_by,
				create_date
			)
				VALUES
			(
				'" . $this->getName() . "',
				'" . $this->getDisplayType() . "',
				'" . $this->getBenefit() . "',
				'" . $this->getPrice() . "',
				'" . $this->getSortOrder() . "',
				1,
				'" . $this->getCreateBy() . "',
				NOW()
			)
		");
		$this->setId( $this->dbInsertId() );
	}

	public function setSortOrder( $string ){
		$this->sortOrder = (int)$string;
	}
	public function getSortOrder(){
		return $this->sortOrder;
	}

	public function setName( $string ){
		$this->name = (string)$string;
	}
	public function getName(){
		return $this->name;
	}

	public function setPrice( $string ){
		$this->price = doubleval($string);
	}
	public function getPrice(){
		return $this->price;
	}

	public function setBenefit( $string ){
		$this->benefit = $string;
	}
	public function getBenefit(){
		return $this->benefit;
	}

	public function setDisplayType( $string ){
		$this->displayType = $string;
	}
	public function getDisplayType(){
		return $this->displayType;
	}

}
