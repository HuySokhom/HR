<?php
use
    OSC\AdvertisingBanner\Collection
        as AdvertisingBannerCollection,
    OSC\AdvertisingBanner\Object
        as AdvertisingBannerObject,
    OSC\AdvertisingBannerDetail\Object
        as AdvertisingDetailObject
;
class RestApiAdvertisingBanner extends RestApi {

    public function get($params){
        $col = new AdvertisingBannerCollection();
        $col->sortByOrder('ASC');
        return $this->getReturn($col, $params);
    }

    public function post($params){
        $obj = new AdvertisingBannerObject();
        $obj->setProperties($params['POST']['master']);
        $obj->insert();
        $id = $obj->getId();
        
        $fields = $params['POST']['detail'];        
		$detail = new AdvertisingDetailObject();
		foreach ( $fields as $k => $v){
			$detail->setAdvertisingBannerId($id);
			$detail->setProperties($v);
			$detail->insert();
        }
        
        return array(
            'data' => array(
                'id' => $obj->getId()
            )
        );
    }

    public function put($params){
        $obj = new AdvertisingBannerObject();
        $obj->setId($this->getId());
        $obj->setProperties($params['PUT']['master']);
        $obj->update();
        $fields = $params['PUT']['detail'];        
        $detail = new AdvertisingDetailObject();
        $detail->setId($this->getId());
        $detail->delete();
		foreach ( $fields as $k => $v){
			$detail->setAdvertisingBannerId($this->getId());
			$detail->setProperties($v);
			$detail->insert();
        }
        
        return array(
            'data' => array(
                'id' => $obj->getId()
            )
        );
    }

    public function delete($params){
        $obj = new AdvertisingBannerObject();
        $obj->setId($this->getId());
        $obj->delete();
    }

    public function patch($params){
        $cols = new AdvertisingBannerCollection();
        $cols->filterById( $this->getId() );
        if( $cols->getTotalCount() > 0 ){
            $cols->populate();
            $col = $cols->getFirstElement();
            $col->setId($this->getId());
            $col->setStatus($params['PATCH']['status']);
            $col->updateStatus();
        }
        return array(
            'data' => array(
                'data' => 'update success'
            )
        );
    }
}