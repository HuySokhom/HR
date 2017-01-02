<?php

namespace OSC\Leason;

use Aedea\Core\Database\StdCollection;

class Collection extends StdCollection {
	
	public function __construct( $params = array() ){
		parent::__construct($params);
		
		$this->addTable('leason', 'l');
		$this->idField = 'l.id';
		$this->setDistinct(true);		
		$this->objectType = __NAMESPACE__ . '\Object';	
	}

	public function filterById( $arg ){
		$this->addWhere("l.id = '" . (int)$arg. "' ");
	}

	public function sortById(){
		$this->addOrderBy("l.id", 'desc');
	}


	public function filterByTitle( $arg ){
		$this->addWhere("l.title LIKE '%" . $arg. "%' ");
	}

}
