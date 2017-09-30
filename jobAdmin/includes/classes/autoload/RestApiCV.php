<?php

use
	OSC\CV\Collection
		as CVCol,
	OSC\CV\Object
		as CVObj
;

class RestApiCV extends RestApi {

	public function get($params){
		$col = new CVCol();
		$userId = $this->getId();
		// start limit page
		$showDataPerPage = 10;
		$start = $params['GET']['start'];
		$col->orderByRefreshDate('DESC');
		$params['GET']['function'] ? $col->filterByFunction($params['GET']['function']) : '';
		$params['GET']['apply_for'] ? $col->filterByApplyFor($params['GET']['apply_for']) : '';
		$params['GET']['customer_id'] ? $col->filterByCustomerId($params['GET']['customer_id']) : '';
		$this->applyLimit($col,
			array(
				'limit' => array( $start, $showDataPerPage )
			)
		);
		
		$this->applyFilters($col, $params);
		$this->applySortBy($col, $params);
		return $this->getReturn($col, $params);
	}
	

	public function post($params){
		$obj = new CVObj();
		$obj->setProperties($params['POST']);
		$obj->insert();
		
		return array(
			'data' => array(
				'id' => $obj->getId()
			)
		);
	}

	public function put($params){
		$obj = new CVObj();
		$obj->setId($this->getId());
		$obj->setProperties($params['PUT']);
		$obj->update();
		return array(
			'data' => array(
				'data' => 'update success'
			)
		);
	}

	public function patch($params){
		$obj = new CVObj();
		$obj->setId($this->getId());
		if( $params['PATCH']['name'] == "update_status" ){
			$obj->setStatus($params['PATCH']['status']);
			$obj->updateStatus();
		}
		elseif( $params['PATCH']['name'] == "is_publish" ){
			$obj->setIsPublish($params['PATCH']['is_publish']);
			$obj->updateStatusPublish();
		}
		else{
			$obj->refreshDate();
		}
	
		return array(
			'data' => array(
				'data' => 'update success'
			)
		);
	}
	
	public function delete($params){
		$obj = new CVObj();
		$obj->setId($this->getId());
		$obj->delete();
		return array(
			'data' => array(
				'data' => 'success'
			)
		);
	}


}

