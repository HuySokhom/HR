<?php

use
	OSC\Product\Object as ProductObj
;

class RestApiSessionUserPlan extends RestApi {

	public function post($params){
		$userId = $this->getOwner()->getId();
		// security of user
		if( !$userId ){
			throw new \Exception(
				"403: Access Denied",
				403
			);
		}else {
			$plan = new ProductObj();
			$plan->setId($total['id']);
			$plan->setCustomersId($userId);
			$plan->setProductsPromote($params['POST']['promote_id']);
			$plan->updatePlan();
			return array(
				'data' => array(
					'id' => $plan->getId()
				)
			);
		}
	}


}
