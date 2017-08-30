<?php

namespace OSC\AdvertisingBannerDetail;

use Aedea\Core\Database\StdCollection;

class Collection extends StdCollection {
	
	public function __construct( $params = array() ){
		parent::__construct($params);
		
		$this->addTable('advertising_detail', 'ab');
		$this->idField = 'ab.id';
		$this->setDistinct(true);
		$this->objectType = __NAMESPACE__ . '\Object';		
	}
	
	public function filterById( $arg ){
		$this->addWhere("ab.id = '" . (int)$arg. "' ");
	}

	public function filterByAdvertisingId( $arg ){
		$this->addWhere("ab.advertising_banner_id = '" . (int)$arg. "' ");
	}
}
