<?php

namespace OSC\Customer;

use
	Aedea\Core\Database\StdObject as DbObj
	, OSC\Location\Collection as LocationCol
;

class Object extends DbObj {
			
	protected
		$customersEmailAddress
		, $customersAddress
		, $customersTelephone
		, $customersType
		, $customersLocation
		, $skillTitle
		, $companyName
		, $customersWebsite
		, $isAgency
		, $customersGender
		, $userName
		, $userType
		, $photo
		, $photoThumbnail
		, $detail
		, $location
		, $total
        , $summary
        , $workingHistory
        , $experience
        , $uploadCv
	;

	public function __construct( $params = array() ){
		parent::__construct($params);
		$this->location = new LocationCol();
	}

	public function toArray( $params = array() ){
		$args = array(
			'include' => array(
				'id',
				'user_name',
                'summary',
                'experience',
                'working_history',
				'user_type',
				'photo',
				'photo_thumbnail',
				'detail',
				'customers_email_address',
				'customers_address',
				'customers_telephone',
				'customers_location',
				'skill_title',
				'company_name',
				'customers_website',
				'location',
                'upload_cv',
				'total'
			)
		);
	
		return parent::toArray($args);
	}
	
	public function load( $params = array() ){
		$q = $this->dbQuery("
			SELECT
				user_name,
				user_type,
				photo,
				photo_thumbnail,
				customers_email_address,
				customers_telephone,
				customers_address,
				customers_location,
				skill_title,
				company_name,
				customers_website,
				is_agency,
				detail,
				summary,
                experience,
                working_history,
                upload_cv
			FROM
				customers
			WHERE
				customers_id = '" . (int)$this->getId() . "'
		");
	
		if( ! $this->dbNumRows($q) ){
			throw new \Exception(
				"404: User not found",
				404
			);
		}
	
		$this->setProperties($this->dbFetchArray($q));

		$this->location->setFilter('id', $this->getCustomersLocation());
		$this->location->populate();

		$count = $this->dbQuery("
			SELECT
				COUNT(products_id)
				as total
			FROM
				products
			WHERE
				customers_id = '" . (int)$this->getId() . "'
					AND
				products_status = 1
		");
		$total = $this->dbFetchArray($count);
		$this->setTotal($total['total']);

	}

	public function updateUserType() {

		if( !$this->getId() ) {
			throw new Exception("save method requires id");
		}

		$this->dbQuery("
			UPDATE
				customers
			SET
				user_type = '" . $this->dbEscape( $this->getUserType() ) . "'
			WHERE
				customers_id = '" . (int)$this->getId() . "'
		");
	}


	public function update() {
	
		if( !$this->getId() ) {
			throw new Exception("save method requires id");
		}
	
		$this->dbQuery("
			UPDATE
				customers
			SET
				user_name = '" . $this->dbEscape( $this->getUserName() ) . "',
				upload_cv = '" . $this->dbEscape( $this->getUploadCv() ) . "',
				summary = '" . $this->dbEscape( $this->getSummary() ) . "',
				skill_title = '" . $this->dbEscape( $this->getSkillTitle() ) . "',
				working_history = '" . $this->dbEscape( $this->getWorkingHistory() ) . "',
				experience = '" . $this->dbEscape( $this->getExperience() ) . "',
				company_name = '" . $this->dbEscape( $this->getCompanyName() ) . "',
				customers_email_address = '" . $this->dbEscape( $this->getCustomersEmailAddress() ) . "',
				photo = '" . $this->dbEscape( $this->getPhoto() ) . "',
				photo_thumbnail = '" . $this->dbEscape( $this->getPhotoThumbnail() ) . "',
				customers_telephone = '" . $this->dbEscape( $this->getCustomersTelephone() ) . "',
				customers_location = '" . (int)$this->getCustomersLocation() . "',
				detail = '" . $this->dbEscape( $this->getDetail() ). "',
				customers_address = '" . $this->dbEscape( $this->getCustomersAddress() ) . "',
				customers_website = '" . $this->dbEscape( $this->getCustomersWebsite() ) . "',
				customers_location = '" . $this->dbEscape( $this->getCustomersLocation() ) . "'
			WHERE
				customers_id = '" . (int)$this->getId() . "'
		");
	
	}

    public function setUploadCv( $string ){
        $this->uploadCv = $string;
    }

    public function getUploadCv(){
        return $this->uploadCv;
    }

    public function setSummary( $string ){
        $this->summary = $string;
    }

    public function getSummary(){
        return $this->summary;
    }

    public function setExperience( $string ){
        $this->experience = $string;
    }

    public function getExperience(){
        return $this->experience;
    }

    public function setWorkingHistory( $string ){
        $this->workingHistory = $string;
    }

    public function getWorkingHistory(){
        return $this->workingHistory;
    }

    public function setCompanyName( $string ){
		$this->companyName = (string)$string;
	}

	public function getCompanyName(){
		return $this->companyName;
	}

	public function setCustomersWebsite( $string ){
		$this->customersWebsite = $string;
	}

	public function getCustomersWebsite(){
		return $this->customersWebsite;
	}

	public function setIsAgency( $string ){
		$this->isAgency = (string)$string;
	}

	public function getIsAgency(){
		return $this->isAgency;
	}

	public function setSkillTitle( $string ){
		$this->skillTitle = (string)$string;
	}

	public function getSkillTitle(){
		return $this->skillTitle;
	}

	public function setDetail( $string ){
		$this->detail = (string)$string;
	}

	public function getDetail(){
		return $this->detail;
	}

	public function setUserType( $string ){
		$this->userType = (string)$string;
	}

	public function getUserType(){
		return $this->userType;
	}

	public function setPhoto( $string ){
		$this->photo = (string)$string;
	}

	public function getPhoto(){
		return $this->photo;
	}

	public function setPhotoThumbnail( $string ){
		$this->photoThumbnail = (string)$string;
	}

	public function getPhotoThumbnail(){
		return $this->photoThumbnail;
	}

	public function setUserName( $string ){
		$this->userName = (string)$string;
	}

	public function getUserName(){
		return $this->userName;
	}

	public function setTotal( $string ){
		$this->total = (string)$string;
	}
	
	public function getTotal(){
		return $this->total;
	}
	
	public function setLocation( $string ){
		$this->location = (int)$string;
	}
	
	public function getLocation(){
		return $this->location;
	}
	
	public function setCustomersEmailAddress( $string ){
		$this->customersEmailAddress = (string)$string;
	}
	
	public function getCustomersEmailAddress(){
		return $this->customersEmailAddress;
	}
	
	public function setCustomersAddress( $string ){
		$this->customersAddress = (string)$string;
	}
	
	public function getCustomersAddress(){
		return $this->customersAddress;
	}
	
	public function setCustomersTelephone( $string ){
		$this->customersTelephone = (string)$string;
	}
	
	public function getCustomersTelephone(){
		return $this->customersTelephone;
	}
	
	public function setCustomersAppId( $string ){
		$this->customersAppId = (string)$string;
	}
	
	public function getCustomersAppId(){
		return $this->customersAppId;
	}
	
	public function setCustomersCompanyName( $string ){
		$this->customersCompanyName = (string)$string;
	}
	
	public function getCustomersCompanyName(){
		return $this->customersCompanyName;
	}
	
	public function setCustomersContactName( $string ){
		$this->customersContactName = (string)$string;
	}
	
	public function getCustomersContactName(){
		return $this->customersContactName;
	}
	
	public function setCustomersGender( $string ){
		$this->customersGender = (string)$string;
	}
	
	public function getCustomersGender(){
		return $this->customersGender;
	}
	
	public function setCustomersLocation( $string ){
		$this->customersLocation = (int)$string;
	}
	
	public function getCustomersLocation(){
		return $this->customersLocation;
	}
	
	public function setCustomersSocialNetwork( $string ){
		$this->customersSocialNetwork = $string;
	}
	
	public function getCustomersSocialNetwork(){
		return $this->customersSocialNetwork;
	}
	
	public function setCustomersType( $string ){
		$this->customersType = $string;
	}
	
	public function getCustomersType(){
		return $this->customersType;
	}
	
}
