<?php

class RestApiUploadCV extends RestApi {

    public function post( $params ){
        if ( !isset($_SESSION['customers_email_address']) ) {
            throw new \Exception(
                "403: Access Denied",
                403
            );
        } else {
            foreach ($_FILES as $file) {
                // get extension
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);

                // check extension is valid image
                if (!in_array($ext, array(
                    'pdf',
                    'PDF',
                ))
                ) {
                    continue;
                }
                $user = str_replace(' ', '_', $_SESSION['customers_email_address']);
                // add timestamp to image name to prevent against overwrites
                $file['name'] = substr($file['name'], 0, strlen($ext) * -1) . '.' . $ext;

                // create folder for each user when upload
                $folderName = DIR_FS_CATALOG . 'cv/' . $user;

                if ( !file_exists($folderName) ) {
                    mkdir( $folderName , 0777, true);
                }

                $date = new DateTime();
                $dateUpload =  date_format($date, 'Y-m-d');
                // create sub folder
                $folderDate = $folderName . '/' . $dateUpload . '/';
                if(!file_exists($folderDate)){
                    // create date folder in each folder in user folder upload file
                    // to determine how many file per day when user upload
                    mkdir( $folderDate , 0777, true);
                }

//                $folderImage = $folderDate . '/cv/';
//                if(!file_exists($folderImage)){
//                    // create date folder in each folder in user folder upload file
//                    // to determine how many file per day when user upload
//                    mkdir( $folderImage , 0777, true);
//                }
//                $folderImageThumbnail = $folderDate . '/image_thumbnail/';
//                if(!file_exists($folderImageThumbnail)){
//                    // create date folder in each folder in user folder upload file
//                    // to determine how many file per day when user upload
//                    mkdir( $folderImageThumbnail , 0777, true);
//                }

                // count file in folder
//                $fileCount = new FilesystemIterator($folderDate, FilesystemIterator::SKIP_DOTS);
//                $totalFile = iterator_count($fileCount);
                // check limit for security when upload file
//                if($totalFile < 50) {
                    if (move_uploaded_file(
                        $file['tmp_name'],
                        $folderDate . $file['name']
                    )) {
                        $cv = $folderDate . $file['name'];
//                        $imgThumbnail = $folderImageThumbnail . $file['name'];

//                        $this->make_thumb($file, $imgOriginal, $imgThumbnail, 200);
                    }

                    return array(
                        'data' => array(
                            'upload_cv' => 'cv/' . $user . '/' . $dateUpload . '/' . $file['name'],
                        )
                    );
//                }
            }
        }
    }

}