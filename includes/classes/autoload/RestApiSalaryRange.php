<?php

use
	OSC\Customer\Collection
		as CustomerCol
;

class RestApiSalaryRange extends RestApi {

	public function get($params){
		$query = tep_db_query("select * from salary_range where status = 1");
		$result = [];
		while ($item = tep_db_fetch_array($query)) {
			$result[] = $item;
		}

		return ['data' => [
			'elements' => $result
		]];
	}

}
