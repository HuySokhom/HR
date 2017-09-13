<?php

namespace OSC\Customer;

use
	Aedea\Core\Database\StdObject as DbObj
;

class Object extends DbObj {
			
	protected
		$customersFirstname
		, $customersLastname
		, $customersFax
		, $industryId
		, $customersEmailAddress
		, $customersAddress
		, $customersPlan
		, $customersTelephone
		, $customersType
		, $customersLocation
		, $customersSocialNetwork
		, $customersAppId
		, $customersCompanyName
		, $customersContactName
		, $customersGender
		, $userName
		, $userType
		, $photo
		, $planDate
		, $planExpire
		, $photoThumbnail
		, $detail
		, $isAgency
        , $statusApprove
        , $isPublish
        , $summary
        , $workingHistory
        , $experience
        , $companyName
        , $skillTitle
        , $customersWebsite
        , $customersPassword
	;
	
	public function toArray( $params = array() ){
		$args = array(
			'include' => array(
				'id',
				'company_name',
				'user_type',
                'customers_website',
				'is_agency',
                'skill_title',
				'industry_id',
				'photo',
				'status',
                'status_approve',
				'photo_thumbnail',
				'detail',
				'customers_email_address',
				'customers_address',
				'customers_fax',
				'customers_telephone',
				'customers_password',
				'customers_location',
				'customers_plan',
				'summary',
				'working_history',
                'experience',
                'is_publish',
			)
		);
	
		return parent::toArray($args);
	}
	
	public function load( $params = array() ){
		$q = $this->dbQuery("
			SELECT
				company_name,
				summary,
				working_history,
				skill_title,
				customers_website,
                experience,
				status,
				status_approve,
				user_type,
				photo,
				is_agency,
				industry_id,
				customers_fax,
				photo_thumbnail,
				customers_email_address,
				customers_telephone,
				customers_address,
				customers_location,
				detail,
				is_publish
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
	}

	
	public function updateUserPassword() {		
		if( !$this->getId() ) {
			throw new Exception("save method requires id");
		}
		$this->dbQuery("
			UPDATE
				customers
			SET
				customers_password = '" . $this->dbEscape( $this->getCustomersPassword() ) . "'
			WHERE
				customers_id = '" . (int)$this->getId() . "'
		");
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


    public function updateIsPublish() {

        if( !$this->getId() ) {
            throw new Exception("save method requires id");
        }

        $this->dbQuery("
			UPDATE
				customers
			SET
				is_publish = '" . (int)$this->getIsPublish() . "'
			WHERE
				customers_id = '" . (int)$this->getId() . "'
		");

    }


    public function updateStatus() {
		if( !$this->getId() ) {
			throw new Exception("save method requires id");
		}
		$this->dbQuery("
			UPDATE
				customers
			SET
				status = '" .  $this->getStatus() . "',
				update_by = '" .  $this->getUpdateBy() . "'
			WHERE
				customers_id = '" . (int)$this->getId() . "'
		");
	}

	public function updateStatusAgency() {
		if( !$this->getId() ) {
			throw new Exception("save method requires id");
		}
		$this->dbQuery("
			UPDATE
				customers
			SET
				is_agency = '" .  $this->getIsAgency() . "',
				update_by = '" .  $this->getUpdateBy() . "'
			WHERE
				customers_id = '" . (int)$this->getId() . "'
		");
	}

    public function updateStatusFeature() {
        if( !$this->getId() ) {
            throw new Exception("save method requires id");
        }
        $this->dbQuery("
			UPDATE
				customers
			SET
				status_approve = '" .  $this->getStatusApprove() . "',
				update_by = '" .  $this->getUpdateBy() . "'
			WHERE
				customers_id = '" . (int)$this->getId() . "'
		");
    }

	public function delete() {
		if( !$this->getId() ) {
			throw new Exception("save method requires id");
		}
		$this->dbQuery("
			DELETE FROM
				customers
			WHERE
				customers_id = '" . (int)$this->getId() . "'
		");

	}

	public function insert() {	
		$this->dbQuery("
			INSERT INTO
				customers
			(
				company_name,
				industry_id,
				summary,
				customers_website,
				skill_title,
				working_history,
				experience,
				user_type,
				customers_email_address,
				photo,
				customers_plan,
				photo_thumbnail,
				customers_telephone,
				customers_fax,
				customers_location,
				detail,
				customers_address,
				customers_password,
				is_publish,
				create_date
			)
			VALUE
			(
				'" . $this->dbEscape( $this->getCompanyName() ) . "',
				'" . $this->getIndustryId() . "',
				'" . $this->dbEscape( $this->getSummary() ) . "',
				'" . $this->dbEscape( $this->getCustomersWebsite() ) . "',
				'" . $this->dbEscape( $this->getSkillTitle() ) . "',
				'" . $this->dbEscape( $this->getWorkingHistory() ) . "',
				'" . $this->dbEscape( $this->getExperience() ) . "',
				'" . $this->dbEscape( $this->getUserType() ) . "',
				'" . $this->dbEscape( $this->getCustomersEmailAddress() ) . "',
				'" . $this->dbEscape( $this->getPhoto() ) . "',
				'" . $this->getCustomersPlan() . "',
				'" . $this->dbEscape( $this->getPhotoThumbnail() ) . "',
				'" . $this->dbEscape( $this->getCustomersTelephone() ) . "',
				'" . $this->dbEscape( $this->getCustomersFax() ) . "',
				'" . (int)$this->getCustomersLocation() . "',
				'" . $this->dbEscape( $this->getDetail() ). "',
				'" . $this->dbEscape( $this->getCustomersAddress() ) . "',
				'" . $this->getCustomersPassword() . "',
				1,
				NOW()
			)			
		");
		$this->setId( $this->dbInsertId() );
	}

	public function update() {
	
		if( !$this->getId() ) {
			throw new Exception("save method requires id");
		}
	
		$this->dbQuery("
			UPDATE
				customers
			SET
				company_name = '" . $this->dbEscape( $this->getCompanyName() ) . "',
				industry_id = '" . $this->getIndustryId() . "',
				summary = '" . $this->dbEscape( $this->getSummary() ) . "',
				customers_website = '" . $this->dbEscape( $this->getCustomersWebsite() ) . "',
				skill_title = '" . $this->dbEscape( $this->getSkillTitle() ) . "',
				working_history = '" . $this->dbEscape( $this->getWorkingHistory() ) . "',
				experience = '" . $this->dbEscape( $this->getExperience() ) . "',
				user_type = '" . $this->dbEscape( $this->getUserType() ) . "',
				customers_email_address = '" . $this->dbEscape( $this->getCustomersEmailAddress() ) . "',
				photo = '" . $this->dbEscape( $this->getPhoto() ) . "',
				customers_plan = '" . $this->getCustomersPlan() . "',
				photo_thumbnail = '" . $this->dbEscape( $this->getPhotoThumbnail() ) . "',
				customers_telephone = '" . $this->dbEscape( $this->getCustomersTelephone() ) . "',
				customers_password = '" . $this->dbEscape( $this->getCustomersPassword() ) . "',
				customers_fax = '" . $this->dbEscape( $this->getCustomersFax() ) . "',
				customers_location = '" . (int)$this->getCustomersLocation() . "',
				detail = '" . $this->dbEscape( $this->getDetail() ). "',
				customers_address = '" . $this->dbEscape( $this->getCustomersAddress() ) . "',
				update_by = '" . $this->getUpdateBy() ."'
			WHERE
				customers_id = '" . (int)$this->getId() . "'
		");
	
	}

	public function setCustomersPassword( $string ){
		$this->customersPassword = $string;
	}

	public function getCustomersPassword(){
		return $this->customersPassword;
	}

	public function setIndustryId( $string ){
		$this->industryId = (int)$string;
	}

	public function getIndustryId(){
		return $this->industryId;
	}

	public function setCustomersFax( $string ){
		$this->customersFax = (string)$string;
	}

	public function getCustomersFax(){
		return $this->customersFax;
	}

	public function setCustomersPlan( $string ){
		$this->customersPlan = (int)$string;
	}

	public function getCustomersPlan(){
		return $this->customersPlan;
	}

	public function setPlanDate( $string ){
		$this->planDate = $string;
	}

	public function getPlanDate(){
		return $this->planDate;
	}

	public function setPlanExpire( $string ){
		$this->planExpire = $string;
	}

	public function getPlanExpire(){
		return $this->planExpire;
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

	public function setCustomersFirstname( $string ){
		$this->customersFirstname = (string)$string;
	}
	
	public function getCustomersFirstname(){
		return $this->customersFirstname;
	}
	
	public function setcustomersLastName( $string ){
		$this->customersLastname = (string)$string;
	}
	
	public function getCustomersLastname(){
		return $this->customersLastname;
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

	public function setIsAgency( $string ){
		$this->isAgency = $string;
	}

	public function getIsAgency(){
		return $this->isAgency;
	}

    public function setStatusApprove( $string ){
        $this->statusApprove = (int)$string;
    }

    public function getStatusApprove(){
        return $this->statusApprove;
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

    public function setSummary( $string ){
        $this->summary = $string;
    }


    public function getSkillTitle(){
        return $this->skillTitle;
    }

    public function setSkillTitle( $string ){
        $this->skillTitle = $string;
    }

    public function getSummary(){
        return $this->summary;
    }

    public function setCompanyName( $string ){
        $this->companyName = $string;
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

    public function setIsPublish( $string ){
        $this->isPublish = (int)$string;
    }

    public function getIsPublish(){
        return $this->isPublish;
    }
}
