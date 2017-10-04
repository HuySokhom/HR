<?php

namespace OSC\Country;

use Aedea\Core\Database\StdCollection;

class Collection extends StdCollection {
	
	public function __construct( $params = array() ){
		parent::__construct($params);
		
		$this->addTable('countries', 'c');
		$this->idField = 'c.countries_id';
		$this->setDistinct(true);		
		$this->objectType = __NAMESPACE__ . '\Object';	
	}

	public function filterById( $arg ){
		$this->addWhere("c.id = '" . (int)$arg. "' ");
	}

	public function filterByName( $arg ){
		$this->addWhere("c.name LIKE '%" . $arg. "%' ");
	}

}
