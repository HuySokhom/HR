<?php

class RestApiImageUploadBase64 extends RestApi {

	public function post( $params ){
		
		$img = $params['POST']['fileName'];
		$img = str_replace('data:image/png;base64,', '', $img);
		$img = str_replace(' ', '+', $img);
		
		$data = base64_decode($img);
		$filePath = DIR_FS_CATALOG;
		$file = DIR_WS_IMAGES . uniqid() . '.png';
		$success = file_put_contents($filePath . $file, $data);
		if($success){
			$result = ['fileName' => $file, 'success' => true];
		}else{
			$result =  ['fileName' => null, 'success' => false];;
		}
		return [
			'data' => $result
		];	
	}
	
}