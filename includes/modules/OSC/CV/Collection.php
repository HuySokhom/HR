<?php

namespace OSC\CV;

use Aedea\Core\Database\StdCollection;

class Collection extends StdCollection {
	
	public function __construct( $params = array() ){
		parent::__construct($params);
		
		$this->addTable('post_cv', 'pc');
		$this->idField = 'pc.id';
		$this->setDistinct(true);
		$this->objectType = __NAMESPACE__ .'\Object';
	}

	public function filterByCustomerId( $arg ){
		$this->addWhere("c.customer_id = '" . $arg . "'");
	}

	public function filterByIsAgency( $arg ){
		$this->addWhere("c.is_agency = '" . (int)$arg . "'");
	}

	public function filterByIsPublish( $arg ){
		$this->addWhere("c.is_publish = '" . (int)$arg . "'");
	}

	public function filterById( $arg ){
		$this->addWhere("c.id = '" . (int)$arg . "'");
	}

	public function orderById($arg){
		$this->addOrderBy("c.id", $arg);
	}
	

}
