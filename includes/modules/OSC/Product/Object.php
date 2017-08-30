<?php

namespace OSC\Product;

use
	Aedea\Core\Database\StdObject as DbObj
	, OSC\ProductDescription\Collection
		as ProductDescriptionCol
	, OSC\Customer\Collection
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
		, $provinceId
        , $gender
        , $salaryId
		, $productsDateAdded
		, $productsStatus
		, $productsKindOf
		, $numberOfHire
		, $imageDetail
        , $productDetail
		, $categoriesId
		, $categoryDetail
		, $productsPromote
		, $productsCloseDate
        , $isPublish
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
                'salary_id',
                'products_close_date',
				'create_date',
				'create_by',
				'products_status',
				'products_kind_of',
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
//		$this->customersDetail = new CustomerCol();
		$this->categoryDetail = new CategoryCollection();
		$this->imageDetail = new ProductImageCol();
	}

	public function load( $params = array() ){
		$q = $this->dbQuery("
			SELECT
				customers_id,
				products_promote,
				categories_id,
				province_id,
				products_date_added,
				products_status,
				products_kind_of,
				number_of_hire,
				salary_id,
				products_close_date,
				create_by,
				gender,
				is_publish
			FROM
				products
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

 		$this->productDetail->setFilter('id', $this->getId());
 		$this->productDetail->populate();

		$this->categoryDetail->setFilter('categories_id', $this->getCategoriesId());
		$this->categoryDetail->populate();

	}

	public function updateStatus() {
		if( !$this->getProductsId() ) {
			throw new Exception("save method requires id");
		}
		$this->dbQuery("
			UPDATE
				products
			SET
				products_status = '" . (int)$this->getProductsStatus() . "'
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
				salary_id = '" . $this->getSalaryId() . "',
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
				products_promote,
				salary,
				products_date_added,
				products_status,
				create_date,
				products_kind_of,
				gender,
				products_close_date,
				number_of_hire,
				is_publish
			)
				VALUES
			(
				'" . (int)$this->getCustomersId() . "',
				'" . (int)$this->getCategoriesId() . "',
				'" . (int)$this->getProvinceId() . "',
 				'" . (int)$this->getProductsPromote() . "',
				'" . $this->getSalary() . "',
 				NOW(),
 				1,
 				NOW(),
				'" . $this->getProductsKindOf() . "',
				'" . $this->getGender() . "',
				'" . $this->getProductsCloseDate() . "',
				'" . $this->getNumberOfHire() . "',
				0
			)
		");
		$this->setProductsId( $this->dbInsertId() );
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

	public function getProductsPromote(){
		return $this->productsPromote;
	}
	public function setProductsPromote( $int ){
		$this->productsPromote = (int)$int;
	}


	public function getProductsKindOf(){
		return $this->productsKindOf;
	}
	public function setProductsKindOf( $string ){
		$this->productsKindOf = $string;
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

    public function getNumberOfHire(){
        return $this->numberOfHire;
    }
    public function setNumberOfHire( $int ){
        $this->numberOfHire = (int)$int;
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

	public function getProductsCloseDate(){
		return $this->productsCloseDate;
	}
	public function setProductsCloseDate( $string ){
		$this->productsCloseDate = $string;
	}

	public function getSalary(){
		return $this->salary;
	}
	public function setSalary( $string ){
		$this->salary = $string;
	}

	public function getGender(){
		return $this->gender;
	}
	public function setGender( $string ){
		$this->gender = $string;
	}

    public function getIsPublish(){
        return $this->isPublish;
    }
    public function setIsPublish( $string ){
        $this->isPublish = $string;
    }
}
