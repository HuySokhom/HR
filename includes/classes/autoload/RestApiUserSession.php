<?php

class RestApiUserSession extends RestApi {

    public function get(){

        //var_dump( $_SESSION );
        return array( data => array(
            'user_type' => $_SESSION['user_type'],
            'user_id' => $_SESSION['customer_id']
        ));
    }
}



