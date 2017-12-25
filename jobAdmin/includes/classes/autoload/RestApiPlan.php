<?php

use
	OSC\Plan\Collection as PlanCol,
	OSC\Plan\Object as PlanObj
;

class RestApiPlan extends RestApi {

	public function get($params){
		$col = new PlanCol();
		$col->orderBySortOrder("ASC");
		$this->applyFilters($col, $params);
		$this->applySortBy($col, $params);
		return $this->getReturn($col, $params);

	}

	public function put($params){
		$obj = new PlanObj();
		$id = $this->getId();
		$obj->setProperties($params['PUT']);
		$obj->setId($id);
		$obj->update();
		return array(
			'data' => array(
				'success' => 'true'
			)
		);

	}

	public function post($params){
		$obj = new PlanObj();
		$obj->setProperties($params['POST']);
		$obj->insert();
		return array(
			'data' => array(
				'success' => 'true',
				"id" => $this->getId()
			)
		);
	}

}
