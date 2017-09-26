<?php

use
	OSC\Country\Collection
		as CountryCol
;

class RestApiCountry extends RestApi {

	public function get($params){
		$col = new CountryCol();
		
		$this->applySortBy($col, $params);
		return $this->getReturn($col, $params);

	}

}
