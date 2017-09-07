<?php

use
	OSC\SalaryRange\Collection as SalaryCol,
	OSC\SalaryRange\Object as SalaryObj
;

class RestApiSalaryRange extends RestApi {

	public function get($params){
		$col = new SalaryCol();
		$col->orderById("DESC");
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

	public function post($params){
		$salaryObj = new SalaryObj();
		$salaryObj->setCreateBy($_SESSION['admin']['username']);
		$salaryObj->setProperties( $params['POST'] );
		$salaryObj->insert();
		$newId = $salaryObj->getId();
		return array(
			'data' => array(
				'id' => $newId
			)
		);
	}

	public function put($params){
		$cols = new SalaryCol();
		$typeId = $this->getId();
		$cols->filterById( $typeId );
		if( $cols->getTotalCount() > 0 ){
			$cols->populate();
			$col = $cols->getFirstElement();
			$col->setId($this->getId());
			$col->setProperties($params['PUT']);
			$col->setUpdateBy($_SESSION['admin']['username']);
			$col->update();
		}
		return array(
			'data' => array(
				'success' => 'true'
			)
		);

	}

	public function patch($params){
		$obj = new SalaryObj();
		$obj->setId($this->getId());
		$obj->setUpdateBy($_SESSION['admin']['username']);
		$obj->setStatus($params['PATCH']['status']);
		$obj->updateStatus();
	}

	public function delete(){
		$obj = new SalaryObj();
		$obj->setId($this->getId());
		$obj->delete();
		return array(
			'data' => array(
				'data' => 'success'
			)
		);
	}

}
