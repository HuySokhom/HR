<?php

use
    OSC\Customer\Collection
    as EmployerCol
;

class RestApiEmployers extends RestApi {

    public function get($params){

        $col = new EmployerCol();
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
}



