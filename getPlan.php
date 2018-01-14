<?php
  	require('includes/application_top.php');
	$query = tep_db_query("
		select 
			name, price, benefit, display_type 
		from 
			plan 
	");
	$result = tep_db_fetch_array($query);
	$array = [];
	while($res = tep_db_fetch_array($query)){
		$array[] = [
			'price' => doubleval($res['price']),
			'name' => $res['name'],
			'benefit' => $res['benefit'],
			'display_type' => $res['display_type']
		];
	};

	echo json_encode($array);