<?php

use
	OSC\CV\Collection
		as CVCol
;

class RestApiSessionUserPostCV extends RestApi {

	public function get($params){
		$col = new CVCol();
		$userId = $this->getId();
		// start limit page
//		$showDataPerPage = 10;
//		$start = $params['GET']['start'];
//		$this->applyLimit($col,
//			array(
//				'limit' => array( $start, $showDataPerPage )
//			)
//		);
		
		//$col->filterByCustomersId($userId);
		// filter with default status 1
		
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
			$productObject = new CVCol();
			$userId = $this->getOwner()->getId();
			$productObject->setCustomersId($userId);
			//$productObject->setProductsPromote($_SESSION['customer_plan']);
			$productObject->setProperties($params['POST']['products']);
			$productObject->insert();
			
			return array(
				'data' => array(
					'id' => $productId
				)
			);
		}
	}

	public function put($params){
		$userId = $this->getOwner()->getId();
		if( !$userId ){
			throw new \Exception(
				"403: Access Denied",
				403
			);
		}else {
			$cols = new CVCol();
			$cols->filterByCustomersId($userId);
			$productId = $this->getId();
			$cols->filterById( $productId );
			if( $cols->getTotalCount() > 0 ){
				$cols->populate();
				$col = $cols->getFirstElement();
				$col->setProductsId($productId);
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
			$cols->filterByCustomersId($userId);
			$cols->filterById( $this->getId() );
			if( $cols->getTotalCount() > 0 ){
				$cols->populate();
				$col = $cols->getFirstElement();
				$col->setProductsId($this->getId());
				if( $params['PATCH']['name'] == "update_status" ){
					$col->setProductsStatus($params['PATCH']['status']);
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
		$userId = $this->getOwner()->getId();
		if( !$userId ){
			throw new \Exception(
				"403: Access Denied",
				403
			);
		}else {
			if($params['DELETE']['image']){
				$image = new ProductImageObj();
				$image->setId($this->getId());
				$image->delete();
				return array(
					'data' => array(
						'data' => 'success'
					)
				);
			}else {
				$cols = new ProductPostCol();
				$cols->filterByCustomersId($userId);
				$cols->filterById($this->getId());
				if ($cols->getTotalCount() > 0) {
					$cols->populate();
					$col = $cols->getFirstElement();
					$col->setProductsId($this->getId());
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


}

