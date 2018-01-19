<?php

use
	OSC\Plan\Collection as PlanCol,
	OSC\Plan\Object as PlanObj
;

class RestApiPlan extends RestApi {

	public function get($params){
		$col = new PlanCol();
		$col->filterByStatus(1);
		$col->orderBySortOrder("ASC");
		$this->applyFilters($col, $params);
		$this->applySortBy($col, $params);
		return $this->getReturn($col, $params);

	}

}
