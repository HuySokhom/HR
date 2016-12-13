<?php

namespace OSC\Customer;

use Aedea\Core\Database\StdCollection;

class Collection extends StdCollection {
	
	public function __construct( $params = array() ){
		parent::__construct($params);
		
		$this->addTable('customers', 'c');
		$this->idField = 'c.customers_id';
		$this->setDistinct(true);
		$this->objectType = __NAMESPACE__ .'\Object';
	}

	public function filterByType( $arg ){
		$this->addWhere("c.user_type = '" . $arg . "'");
	}

	public function filterByIsAgency( $arg ){
		$this->addWhere("c.is_agency = '" . (int)$arg . "'");
	}

	public function filterByIsPublish( $arg ){
		$this->addWhere("c.is_publish = '" . (int)$arg . "'");
	}

	public function filterById( $arg ){
		$this->addWhere("c.customers_id = '" . (int)$arg . "'");
	}

	public function orderById($arg){
		$this->addOrderBy("c.customers_id", $arg);
	}

	public function orderByRandom(){
		$this->addOrderBy("RAND()");
	}

}
