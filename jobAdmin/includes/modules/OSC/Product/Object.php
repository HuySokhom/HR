<?php

namespace OSC\Product;

use
	Aedea\Core\Database\StdObject as DbObj
	, OSC\ProductDescription\Collection
			as ProductDescriptionCol
	, OSC\CustomerSample\Collection
		as CustomerCol
	, OSC\CategoriesDescription\Collection
		as CategoryCollection
	, OSC\ProductImage\Collection
		as ProductImageCol
;

class Object extends DbObj {
		
	protected
		$customersId
		, $productsId
        , $salaryId
        , $gender
		, $provinceId
        , $industryId
        , $villageId
		, $productsImage
		, $productsImageThumbnail
		, $productsPrice
		, $productsDateAdded
		, $productsStatus
		, $productsKindOf
		, $bedRooms
		, $bathRooms
		, $numberOfFloors
		, $imageDetail
        , $productDetail
		, $categoriesId
		, $categoryDetail
		, $customersDetail
		, $mapLat
		, $mapTitle
		, $companyName
		, $productsPromote
        , $isPublish
        , $productsCloseDate
        , $numberOfHire
	;
	
	public function toArray( $params = array() ){
		$args = array(
			'include' => array(
                'id',
                'categories_id',
                'products_promote',
                'category_detail',
                'customers_id',
                'province_id',
                'industry_id',
                'salary_id',
                'products_close_date',
                'create_date',
                'create_by',
                'products_status',
                'products_kind_of',
				'company_name',
                'number_of_hire',
                'gender',
                'product_detail',
                'is_publish',
			)
		);
		return parent::toArray($args);
	}

	public function __construct( $params = array() ){
 		parent::__construct($params);
 		$this->productDetail = new ProductDescriptionCol();
		$this->customersDetail = new CustomerCol();
		$this->categoryDetail = new CategoryCollection();
		$this->imageDetail = new ProductImageCol();
	}

	public function load( $params = array() ){
		$q = $this->dbQuery("
			SELECT
				p.customers_id,
				p.products_promote,
				p.categories_id,
				p.province_id,
				p.industry_id,
				p.products_date_added,
				p.products_status,
				p.products_kind_of,
				p.number_of_hire,
				p.salary_id,
				DATE_FORMAT(p.products_close_date, '%Y/%m/%d') as products_close_date,
				p.gender,
				p.is_publish,
				c.company_name
			FROM
				products p inner join customers c on p.customers_id = c.customers_id
			WHERE
				products_id = '" . (int)$this->getId() . "'
		");
		
		if( ! $this->dbNumRows($q) ){
			throw new \Exception(
				"404: Products not found",
				404
			);
		}
		
		$this->setProperties($this->dbFetchArray($q));

		$this->customersDetail->setFilter('id', $this->getCustomersId());
		$this->customersDetail->populate();

 		$this->productDetail->setFilter('id', $this->getId());
 		$this->productDetail->populate();

		$this->categoryDetail->setFilter('categories_id', $this->getCategoriesId());
		$this->categoryDetail->populate();
//
		$this->imageDetail->setFilter('products_id', $this->getId());
		$this->imageDetail->populate();
	}
	
	public function updateStatus() {
		if( !$this->getProductsId() ) {
			throw new Exception("save method requires id");
		}
		$this->dbQuery("
			UPDATE
				products
			SET 
				is_publish = '" . (int)$this->getProductsStatus() . "'
			WHERE
				products_id = '" . (int)$this->getProductsId() . "'
		");
	}

	public function delete(){
		if( !$this->getProductsId() ) {
			throw new Exception("delete method requires id to be set");
		}
		$this->dbQuery("
			DELETE FROM
				products
			WHERE
				products_id = '" . (int)$this->getProductsId() . "'
		");

		// remove products description
		$this->dbQuery("
			DELETE FROM
				products_description
			WHERE
				products_id = '" . (int)$this->getProductsId() . "'
		");
		// remove products to categories
		$this->dbQuery("
			DELETE FROM
				products_to_categories
			WHERE
				products_id = '" . (int)$this->getProductsId() . "'
		");
		// remove products contact
		$this->dbQuery("
			DELETE FROM
				product_contact_person
			WHERE
				products_id = '" . (int)$this->getProductsId() . "'
		");
		// remove products image
		$this->dbQuery("
			DELETE FROM
				products_images
			WHERE
				products_id = '" . (int)$this->getProductsId() . "'
		");
	}

	public function refreshDate(){
		$this->dbQuery("
			UPDATE
				products
			SET
				products_date_added = NOW()
			WHERE
				products_id = '" . (int)$this->getProductsId() . "'
		");
	}
	public function update(){
		$this->dbQuery("
			UPDATE
				products
			SET
				province_id = '" . (int)$this->getProvinceId() . "',
				categories_id = '" . (int)$this->getCategoriesId() . "',
				gender = '" . $this->getGender() . "',
				customers_id = '" . (int)$this->getCustomersId() . "',
				salary_id = '" . $this->getSalaryId() . "',
				industry_id = '" . $this->getIndustryId() . "',
 				products_kind_of = '" . $this->getProductsKindOf() . "',
 				number_of_hire = '" . $this->getNumberOfHire() . "',
 				products_close_date = '" . $this->getProductsCloseDate() . "'
			WHERE
				products_id = '" . (int)$this->getProductsId() . "'
		");
		
	}
	
	public function insert(){	
		$this->dbQuery("
			INSERT INTO
				products
			(
				customers_id,
				categories_id,
				province_id,
				industry_id,
				gender,
				salary_id,
				number_of_hire,
				products_date_added,
				products_status,
				create_date,
				products_kind_of,
				products_close_date,
				is_publish
			)
				VALUES
			(
				'" . (int)$this->getCustomersId() . "',
				'" . (int)$this->getCategoriesId() . "',
				'" . (int)$this->getProvinceId() . "',
				'" . (int)$this->getIndustryId() . "',
				'" . $this->getGender() . "',
				'" . (int)$this->getSalaryId() . "',
				'" . $this->getNumberOfHire() . "',
 				NOW(),
 				1,
 				NOW(),
				'" . $this->getProductsKindOf() . "',
				'" . $this->getProductsCloseDate() . "',
				1
			)
		");	
		$this->setProductsId( $this->dbInsertId() );
	}

	public function getMapLat(){
		return $this->mapLat;
	}
	public function setMapLat( $string ){
		$this->mapLat = $string;
	}

    public function getIsPublish(){
        return $this->isPublish;
    }
    public function setIsPublish( $string ){
        $this->isPublish = $string;
    }

	public function getProductsPromote(){
		return $this->productsPromote;
	}
	public function setProductsPromote( $string ){
		$this->productsPromote = (int)$string;
	}

	public function getCompanyName(){
		return $this->companyName;
	}
	public function setCompanyName( $string ){
		$this->companyName = $string;
	}

	public function getMapLong(){
		return $this->mapLong;
	}
	public function setMapLong( $string ){
		$this->mapLong = $string;
	}

	public function setCustomersId( $int ){
		$this->customersId = (int)$int;
	}
	
	public function getCustomersId(){
		return $this->customersId;
	}
	
	public function setProvinceId( $int ){
		$this->provinceId = (int)$int;
	}
	
	public function getProvinceId(){
		return $this->provinceId;
	}
	
	public function setProductsId( $int ){
		$this->productsId = (int)$int;
	}
	
	public function getProductsId(){
		return $this->productsId;
	}
	
	public function setProductsDateAdded( $date ){
		$this->productsDateAdded = $date;
	}
	
	public function getProductsDateAdded(){
		return $this->productsDateAdded;
	}

	public function setProductsImageThumbnail( $string ){
		$this->productsImageThumbnail = (string)$string;
	}

	public function getProductsImageThumbnail(){
		return $this->productsImageThumbnail;
	}

	public function setProductsImage( $string ){
		$this->productsImage = (string)$string;
	}
	
	public function getProductsImage(){
		return $this->productsImage;
	}
	
	public function setProductsStatus( $int ){
		$this->productsStatus = (int)$int;
	}
	
	public function getProductsStatus(){
		return $this->productsStatus;
	}

	public function setDistrictId( $int ){
		$this->districtId = (int)$int;
	}

	public function getDistrictId(){
		return $this->districtId;
	}

	public function getVillageId(){
		return $this->villageId;
	}
	public function setVillageId( $int ){
		$this->villageId = (int)$int;
	}

	public function getProductsKindOf(){
		return $this->productsKindOf;
	}
	public function setProductsKindOf( $array ){
		$this->productsKindOf = $array;
	}

	public function getImageDetail(){
		return $this->imageDetail;
	}
	public function setImageDetail( $array ){
		$this->imageDetail = $array;
	}

	public function getProductDetail(){
		return $this->productDetail;
	}
	public function setProductDetail( $array ){
		$this->productDetail = $array;
	}

	public function getProductsPrice(){
		return $this->productsPrice;
	}
	public function setProductsPrice( $int ){
		$this->productsPrice = doubleval($int);
	}

    public function getBedRooms(){
        return $this->bedRooms;
    }
    public function setBedRooms( $int ){
        $this->bedRooms = (int)$int;
    }
    public function getBathRooms(){
        return $this->bathRooms;
    }
    public function setBathRooms( $int ){
        $this->bathRooms = (int)$int;
    }

	public function getCategoriesId(){
		return $this->categoriesId;
	}
	public function setCategoriesId( $int ){
		$this->categoriesId = (int)$int;
	}

    public function getIndustryId(){
        return $this->industryId;
    }
    public function setIndustryId( $int ){
        $this->industryId = (int)$int;
    }

	public function getCategoryDetail(){
		return $this->categoryDetail;
	}
	public function setCategoryDetail( $array ){
		$this->categoryDetail = $array;
	}

	public function getCustomersDetail(){
		return $this->customersDetail;
	}
	public function setCustomersDetail( $array ){
		$this->customersDetail = $array;
	}

    public function getSalaryId(){
        return $this->salaryId;
    }
    public function setSalaryId( $string ){
        $this->salaryId = (int)$string;
    }

    public function getGender(){
        return $this->gender;
    }
    public function setGender( $string ){
        $this->gender = $string;
    }

    public function getProductsCloseDate(){
        return $this->productsCloseDate;
    }
    public function setProductsCloseDate( $string ){
        $this->productsCloseDate = $string;
    }

    public function getNumberOfHire(){
        return $this->numberOfHire;
    }
    public function setNumberOfHire( $int ){
        $this->numberOfHire = (int)$int;
    }

}
