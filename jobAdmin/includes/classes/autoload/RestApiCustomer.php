<?php

use
	OSC\Customer\Collection
		as CustomersCol,
	OSC\Customer\Object
		as CustomersObject
;

class RestApiCustomer extends RestApi {

	public function get($params){
		$col = new CustomersCol();
		$col->sortByDate('DESC');

		if($params['GET']['plan'] != ''){
			$col->filterByPlan($params['GET']['plan']);
		}
		$params['GET']['search_name'] ? $col->filterByName($params['GET']['search_name']) : '';
		$params['GET']['type'] ? $col->filterByType($params['GET']['type']) : '';
		$params['GET']['id'] ? $col->filterById($params['GET']['id']) : '';
		// start limit page
		$showDataPerPage = 10;
		$start = $params['GET']['start'];
		$this->applyLimit($col,
			array(
				'limit' => array( $start, $showDataPerPage )
			)
		);
		return $this->getReturn($col, $params);

	}

	public function post($params){
		// check email existing
		$check_email_query = tep_db_query("
			SELECT
				count(*) as total
			FROM
				" . TABLE_CUSTOMERS . "
			WHERE
				customers_email_address = '" . tep_db_input($params['PUT']['customers_email_address']) . "'"
		);
		$check_email = tep_db_fetch_array($check_email_query);

		if ($check_email['total'] > 0) {
			return array(
				'data' => array(
					'success' => 'false'
				)
			);
		}else {
			include(DIR_WS_FUNCTIONS . 'password_funcs.php');
			$obj = new CustomersObject();
			$obj->setProperties( $params['POST'] );
			$password = tep_encrypt_password($params['POST']['customers_password']);
			
			$obj->setCustomersPassword($password);
			$obj->insert();
			return array(
				'data' => array(
					'id' => $obj->getId()
				)
			);
		}
	}
	
	public function put($params){
		$cols = new CustomersCol();
		$customerId = $this->getId();
		// check email existing
		$check_email_query = tep_db_query("
			SELECT
				count(*) as total
			FROM
				" . TABLE_CUSTOMERS . "
			WHERE
				customers_email_address = '" . tep_db_input($params['PUT']['customers_email_address']) . "'
					and
				customers_id != '" . (int)$customerId . "'"
		);
		$check_email = tep_db_fetch_array($check_email_query);

		if ($check_email['total'] > 0) {
			echo 'duplicate';
			return;
		}else {
			$cols->filterById($customerId);
			if ($cols->getTotalCount() > 0) {
				$cols->populate();
				$col = $cols->getFirstElement();
				$col->setId($customerId);
				$col->setUpdateBy($_SESSION['username']);
				$col->setProperties($params['PUT']);
				$col->update();

				if($params['PUT']['customers_password']){				
					include(DIR_WS_FUNCTIONS . 'password_funcs.php');
					$password = tep_encrypt_password($params['PUT']['customers_password']);
					$col->setCustomersPassword($password);
					$col->updateUserPassword();
				}
				echo 'success';
				return;
			}
		}
	}

	public function patch($params){
		$obj = new CustomersObject();
		$obj->setId($this->getId());
		$obj->setUpdateBy($_SESSION['admin']['username']);
		if($params['PATCH']['agency']){
            $obj->setIsAgency($params['PATCH']['is_agency']);
            $obj->updateStatusAgency();
        }else{
            $obj->setIsPublish($params['PATCH']['is_publish']);
            $obj->updateIsPublish();
        }
	}

	public function delete(){

		$obj = new CustomersObject();
		$obj->setId($this->getId());
		$obj->delete();
		return array(
			'data' => array(
				'data' => 'success'
			)
		);

	}
	
}
