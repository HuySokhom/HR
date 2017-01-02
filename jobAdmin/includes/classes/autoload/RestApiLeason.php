<?php

use
	OSC\Leason\Collection as LeasonCol,
	OSC\Leason\Object as LeasonObj
;

class RestApiLeason extends RestApi {

	public function get($params){
		$col = new LeasonCol();
		$params['GET']['id'] ? $col->filterById($params['GET']['id']) : '';
		$params['GET']['title'] ? $col->filterByTitle($params['GET']['title']) : '';
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
		$newsObj = new LeasonObj();
		$newsObj->setStatus(1);
		$newsObj->setCreateBy($_SESSION['admin']['username']);
		$newsObj->setProperties( $params['POST']);
		$newsObj->insert();
		$newId = $newsObj->getId();

		return array(
			'data' => array(
				'id' => $newId
			)
		);
	}

	public function put($params){
		$cols = new LeasonCol();
		$newsId = $this->getId();
		$cols->filterById( $newsId );
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
		$obj = new LeasonObj();
		$obj->setId($this->getId());
		$obj->setUpdateBy($_SESSION['admin']['username']);
		$obj->setStatus($params['PATCH']['status']);
		$obj->updateStatus();
	}

	public function delete(){
		$cols = new LeasonCol();
		$cols->filterById( $this->getId() );
		if( $cols->getTotalCount() > 0 ){
			$cols->populate();
			$col = $cols->getFirstElement();
			$col->setId($this->getId());
			$col->delete();
		}
		return array(
			'data' => array(
				'data' => 'success'
			)
		);

	}

}
