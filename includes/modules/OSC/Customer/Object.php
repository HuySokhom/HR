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
		, $country
		, $countryName
		, $stateCity
		, $maritalStatus
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
		, $industryId
		, $industryName
		, $nationality
		, $religion
		, $customersDob
		, $health
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
				'industry_id',
				'industry_name',
                'working_history',
				'user_type',
				'photo',
				'nationality',
				'religion',
				'health',
				'photo_thumbnail',
				'detail',
				'customers_email_address',
				'customers_address',
				'customers_telephone',
				'customers_location',
				'skill_title',
				'company_name',
				'marital_status',
				'customers_gender',
				'customers_dob',
				'state_city',
				'country',
				'country_name',
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
				customers_dob,
				customers_gender,
				customers_address,
				marital_status,
				state_city,
				country,
				co.countries_name as country_name,
				customers_location,
				skill_title,
				company_name,
				industry_id,
				i.name as industry_name,
				customers_website,
				nationality,
				religion,
				health,
				is_agency,
				detail,
				summary,
                experience,
                working_history,
                upload_cv
			FROM
				customers c left join industries i on c.industry_id = i.id left join countries co on c.country = co.countries_id
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
				customers_dob = '" . $this->getCustomersDob() . "',
				nationality = '" . $this->dbEscape( $this->getNationality() ) . "',
				religion = '" . $this->dbEscape( $this->getReligion() ) . "',
				health = '" . $this->dbEscape( $this->getHealth() ) . "',
				marital_status = '" . $this->dbEscape( $this->getMaritalStatus() ) . "',				
				industry_id = '" .  $this->getIndustryId() . "',
				upload_cv = '" . $this->dbEscape( $this->getUploadCv() ) . "',
				state_city = '" . $this->dbEscape( $this->getStateCity() ) . "',
				customers_gender = '" . $this->dbEscape( $this->getCustomersGender() ) . "',
				country = '" . $this->dbEscape( $this->getCountry() ) . "',
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
	
    public function setCustomersDob( $string ){
        $this->customersDob = date('Y-m-d', strtotime($string));
    }

    public function getCustomersDob(){
        return $this->customersDob;
	}
	
    public function setHealth( $string ){
        $this->health = $string;
    }

    public function getHealth(){
        return $this->health;
	}
	
    public function setReligion( $string ){
        $this->religion = $string;
    }

    public function getReligion(){
        return $this->religion;
	}
	
    public function setNationality( $string ){
        $this->nationality = $string;
    }

    public function getNationality(){
        return $this->nationality;
    }

    public function setMaritalStatus( $string ){
        $this->maritalStatus = $string;
    }

    public function getMaritalStatus(){
        return $this->maritalStatus;
    }

    public function setCountry( $string ){
        $this->country = (int)$string;
    }

    public function getCountry(){
        return $this->country;
    }

    public function setCountryName( $string ){
        $this->countryName = $string;
    }

    public function getCountryName(){
        return $this->countryName;
	}
	
    public function setStateCity( $string ){
        $this->stateCity = $string;
    }

    public function getStateCity(){
        return $this->stateCity;
    }

    public function setIndustryId( $string ){
        $this->industryId = (int)$string;
    }

    public function getIndustryId(){
        return $this->industryId;
    }

    public function setUploadCv( $string ){
        $this->uploadCv = $string;
    }

    public function getIndustryName(){
        return $this->industryName;
    }
    public function setIndustryName( $string ){
        $this->industryName = $string;
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
