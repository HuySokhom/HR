<?php

use
    OSC\Customer\Collection
    as EmployerCol
;

class RestApiEmployers extends RestApi {

    public function get($params){

        $col = new EmployerCol();

        $params['GET']['user_type'] ? $col->filterByType($params['GET']['user_type']) : '';
        $params['GET']['name'] ? $col->filterByName($params['GET']['name']) : '';
        $params['GET']['location'] ? $col->filterByLocation($params['GET']['location']) : '';
        $params['GET']['position'] ? $col->filterByPosition($params['GET']['position']) : '';
        $params['GET']['is_agency'] ? $col->filterByIsAgency($params['GET']['is_agency']) : '';
        $col->filterByIsPublish(1);
        $col->orderByRandom();
        // start limit page
        $showDataPerPage = 10;
        $start = $params['GET']['start'];
        $this->applyLimit($col,
            array(
                'limit' => array( $start, $showDataPerPage )
            )
        );
        $col->orderById('DESC');
        return $this->getReturn($col, $params);

    }
}



