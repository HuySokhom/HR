<?php

class RestApiFileUpload extends RestApi {

	public function post( $params = array() ){
		foreach ( $_FILES as $file ){

			// get extension
			$ext = pathinfo($file['name'], PATHINFO_EXTENSION);

			// check extension is valid image
//			if( ! in_array($ext, array(
//				'jpg',
//				'jpeg',
//				'gif',
//				'png',
//			))){
//				continue;
//			}

			// add timestamp to image name to prevent against overwrites
			$file['name'] = substr($file['name'], 0, strlen($ext) * -1)
				. time()
				. '.' . $ext
			;
			if(move_uploaded_file(
				$file['tmp_name'],
				DIR_FS_CATALOG . 'leason/' . $file['name']
			)){
				$fileUpload = DIR_FS_CATALOG . 'leason/' . $file['name'];
			}
			return array(
				'data' => array(
					'file' => 'leason/' . $file['name'],
				)
			);
		}

	}

}