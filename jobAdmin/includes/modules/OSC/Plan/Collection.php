<?php

namespace OSC\Plan;

use Aedea\Core\Database\StdCollection;

class Collection extends StdCollection {
	
	public function __construct( $params = array() ){
		parent::__construct($params);
		
		$this->addTable('plan', 'p');
		$this->idField = 'p.id';
		$this->setDistinct(true);
		
		$this->objectType = __NAMESPACE__ . '\Object';		
	}

	public function filterById( $arg ){
		$this->addWhere("p.id = '" . (int)$arg. "' ");
	}

	public function orderBySortOrder( $arg ){
		$this->addOrderBy('p.sort_order', $arg);
	}

	public function filterByStatus( $arg ){
		$this->addWhere("p.status = '" . (int)$arg. "' ");
	}

}
