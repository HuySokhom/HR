<?php

use
	OSC\CV\Collection
		as CVCol
;

class RestApiCV extends RestApi {

	public function get($params){
		$col = new CVCol();
		// start limit page
		$showDataPerPage = 40;
		$start = $params['GET']['start'];
		$params['GET']['function'] ? $col->filterByFunction($params['GET']['function']) : '';
		$params['GET']['apply_for'] ? $col->filterByApplyForAndId($params['GET']['apply_for']) : '';
		
		$col->filterByIsPublish(2);
		$col->orderByRefreshDate('DESC');
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

