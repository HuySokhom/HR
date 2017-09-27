<?php

use
	OSC\CV\Collection
		as CVCol,
	OSC\CV\Object
		as CVObj
;

class RestApiSessionUserPostCV extends RestApi {

	public function get($params){
		$col = new CVCol();
		$userId = $this->getId();
		// start limit page
		$showDataPerPage = 10;
		$start = $params['GET']['start'];
		$col->orderByRefreshDate('DESC');
		$params['GET']['function'] ? $col->filterByFunction($params['GET']['function']) : '';
		$params['GET']['apply_for'] ? $col->filterByApplyFor($params['GET']['apply_for']) : '';
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
		$userId = $this->getOwner()->getId();
		if( !$userId ){
			throw new \Exception(
				"403: Access Denied",
				403
			);
		}else {
			$obj = new CVObj();
			$userId = $this->getOwner()->getId();
			$obj->setCustomerId($userId);
			//$productObject->setProductsPromote($_SESSION['customer_plan']);
			$obj->setProperties($params['POST']);
			$obj->insert();
			
			return array(
				'data' => array(
					'id' => $obj->getId()
				)
			);
		}
	}

	public function put($params){
		$userId = $this->getOwner()->getId();var_dump($userId);
		if( !$userId ){
			throw new \Exception(
				"403: Access Denied",
				403
			);
		}else {
			$cols = new CVCol();
			$cols->filterByCustomerId($userId);
			$id = $this->getId();
			$cols->filterById( $id );
			if( $cols->getTotalCount() > 0 ){
				$cols->populate();
				$col = $cols->getFirstElement();
				$col->setId($id);
				$col->setCustomerId($userId);
				$col->setProperties($params['PUT']);
				$col->update();
				return array(
					'data' => array(
						'data' => 'update success'
					)
				);
			}
		}
	}

	public function patch($params){
		$userId = $this->getOwner()->getId();
		if( !$userId ){
			throw new \Exception(
				"403: Access Denied",
				403
			);
		}else {
			$cols = new CVCol();
			$cols->filterByCustomerId($userId);
			$cols->filterById( $this->getId() );
			if( $cols->getTotalCount() > 0 ){
				$cols->populate();
				$col = $cols->getFirstElement();
				$col->setId($this->getId());
				$col->setCustomerId($userId);var_dump($col->getCustomerId());
				if( $params['PATCH']['name'] == "update_status" ){
					$col->setStatus($params['PATCH']['status']);
					$col->updateStatus();
				}
				elseif( $params['PATCH']['name'] == "promote_product" ){
					// check plan if upgrade product promote
					$plan = (int)$_SESSION['customer_plan'];
					if($plan > 0){
						$productPromote = (int)$params['PATCH']['products_promote'];
						$limit = (int)$_SESSION['customers_limit_products'];
						if($productPromote > 0){
							// update if product promote bigger than 0 update plan
							tep_db_query("
								update
									products
								set
									products_promote = 0
								where
									products_id = " . $this->getId() . "
							");
							echo 'success';
							return;
						}else {
							// count number of product promote
							$query = tep_db_query("
								select
									count(customers_id) as count
								from
									products
								where
									customers_id = " . $userId . "
										and
									products_promote > 0
							");
							$count = tep_db_fetch_array($query);
							// check valid of product promote
							if ($count['count'] < $limit) {
								tep_db_query("
									update
										products
									set
										products_promote = " . $plan . "
									where
										products_id = " . $this->getId() . "
								");
								echo 'success';
								return;
							} else {
								echo 'limit';
								return;
							}
						}
					}
					echo 'false';
					return;
				}
				else{
					$col->refreshDate();
				}
			}
			return array(
				'data' => array(
					'data' => 'update success'
				)
			);
		}
	}
	
	public function delete($params){
		$userId = $_SESSION['customer_id'];
		if( !$userId ){
			throw new \Exception(
				"403: Access Denied",
				403
			);
		}else {
			$cols = new CVCol();
			$cols->filterByCustomerId($userId);
			$cols->filterById($this->getId());
			if ($cols->getTotalCount() > 0) {
				$cols->populate();
				$col = $cols->getFirstElement();
				$col->setId($this->getId());
				$col->setCustomerId($userId);
				$col->delete();
			}
			return array(
				'data' => array(
					'data' => 'success'
				)
			);
		}
	}


}

