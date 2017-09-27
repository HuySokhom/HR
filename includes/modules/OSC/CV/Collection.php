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
		$this->addWhere("pc.customer_id = '" . $arg . "'");
	}

	public function filterByApplyFor( $arg ){
		$this->addWhere("pc.apply_for like '%" . $arg . "%'");
	}

	public function filterByFunction( $arg ){
		$this->addWhere("pc.function = '" . (int)$arg . "'");
	}

	public function filterByIsPublish( $arg ){
		$this->addWhere("pc.is_publish = '" . (int)$arg . "'");
	}

	public function filterById( $arg ){
		$this->addWhere("pc.id = '" . (int)$arg . "'");
	}

	public function orderById($arg){
		$this->addOrderBy("pc.id", $arg);
	}
	
	public function orderByRefreshDate( $arg ){
		$this->addOrderBy("pc.refresh_date", $arg);
	}


}
