<?php

use
    OSC\Customer\Collection
    as EmployerCol
;

class RestApiEmployers extends RestApi {

    public function get($params){

        $col = new EmployerCol();
        $this->applyFilters($col, $params);
        $this->applySortBy($col, $params);
        return $this->getReturn($col, $params);

    }
}



