<?php

use
	OSC\Leason\Collection as LeasonCol,
	OSC\Leason\Object as LeasonObj
;

class RestApiLeason extends RestApi {

	public function get($params){
		$col = new LeasonCol();
		$col->sortById();
		$col->filterByStatus(1);
		$params['GET']['id'] ? $col->filterById($params['GET']['id']) : '';
		$params['GET']['search_title'] ? $col->filterByTitle($params['GET']['search_title']) : '';
		// start limit page
		$showDataPerPage = 10;
		$start = $params['GET']['start'];
		$this->applyLimit($col,
			array(
				'limit' => array( $start, $showDataPerPage )
			)
		);

		$this->applyFilters($col, $params);
		$this->applySortBy($col, $params);
		return $this->getReturn($col, $params);

	}

}
