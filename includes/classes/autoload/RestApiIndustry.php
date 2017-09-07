<?php

class RestApiIndustry extends RestApi {

	public function get($params){
		$query = tep_db_query("
			select
				name,
				id
			from
				industries
		");
		$array = array();
		while ($item = tep_db_fetch_array($query)){
			$array[] = [
				'name' => $item['name'],
				'id' => (int)$item['id']
			];
		}
		return array(
			data => array(
				elements => $array,
			)
		);
	}

}

