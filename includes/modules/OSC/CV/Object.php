<?php

namespace OSC\CV;

use
	Aedea\Core\Database\StdObject as DbObj
	, OSC\Location\Collection as LocationCol
;

class Object extends DbObj {
			
	protected
		$customerId
		, $presentAddress
		, $phoneNumber
		, $email
		, $applyFor
		, $function
		, $salaryExpected
		, $coverLetterSummery
		, $fullName
		, $gender
		, $dob
		, $nationality
		, $maritalStatus
		, $religion
		, $health
		, $country
		, $photo
		, $stateCity
		, $workingHistory
		, $experience
        , $summary
		, $isPublish
		, $viewed
		, $coverLetterSummary
		, $preferLocation
	;
	
    public function setSalaryExpected( $string ){
        $this->salaryExpected = doubleval($string);
    }
    public function getSalaryExpected(){
        return $this->salaryExpected;
	}

    public function setFullName( $string ){
        $this->fullName = $string;
    }
    public function getFullName(){
        return $this->fullName;
	}

    public function setCoverLetterSummary( $string ){
        $this->coverLetterSummary = $string;
    }
    public function getCoverLetterSummary(){
        return $this->coverLetterSummary;
	}

    public function setPreferLocation( $string ){
        $this->preferLocation = $string;
    }
    public function getPreferLocation(){
        return $this->preferLocation;
	}

    public function setViewed( $string ){
        $this->viewed = $string;
    }
    public function getViewed(){
        return $this->viewed;
	}

    public function setDob( $string ){
        $this->dob = date('Y-m-d', strtotime($string));
    }
    public function getDob(){
        return $this->dob;
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
        $this->country = $string;
    }
    public function getCountry(){
        return $this->country;
    }

    public function setStateCity( $string ){
        $this->stateCity = $string;
    }
    public function getStateCity(){
        return $this->stateCity;
    }

    public function setCustomerId( $string ){
        $this->customerId = (int)$string;
    }
    public function getCustomerId(){
        return $this->customerId;
    }

    public function getFunction(){
        return $this->function;
    }
    public function setFunction( $string ){
        $this->function = $string;
    }

    public function getApplyFor(){
        return $this->applyFor;
    }
    public function setApplyFor($string){
        $this->applyFor = $string;
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

    public function setIsPublish( $string ){
		$this->isPublish = (int)$string;
	}
	public function getIsPublish(){
		return $this->isPublish;
	}

	public function setPhoto( $string ){
		$this->photo = (string)$string;
	}
	public function getPhoto(){
		return $this->photo;
	}
	
	public function setEmail( $string ){
		$this->email = (string)$string;
	}	
	public function getEmail(){
		return $this->email;
	}
	
	public function setPresentAddress( $string ){
		$this->presentAddress = (string)$string;
	}
	public function getPresentAddress(){
		return $this->presentAddress;
	}
	
	public function setPhoneNumber( $string ){
		$this->phoneNumber = (string)$string;
	}	
	public function getPhoneNumber(){
		return $this->phoneNumber;
	}
	
	public function setGender( $string ){
		$this->gender = (string)$string;
	}
	public function getGender(){
		return $this->gender;
	}
	
	public function toArray( $params = array() ){
		$args = array(
			'include' => array(
				'id',
				'customer_id',
                'summary',
				'experience',
				'viewed',
				'phone_number',
				'email',
                'working_history',
				'apply_for',
				'photo',
				'nationality',
				'religion',
				'health',
				'present_address',
				'phone_number',
				'cover_letter_summary',
				'prefer_location',
				'full_name',
				'function',
				'marital_status',
				'gender',
				'dob',
				'state_city',
				'country',
				'salary_expected',
                'is_publish',
			)
		);
	
		return parent::toArray($args);
	}
	
	public function load( $params = array() ){
		$q = $this->dbQuery("
			SELECT
				customer_id,
				summary,
				experience,
				viewed,
				phone_number,
				email,
				cover_letter_summary,
				working_history,
				apply_for,
				photo,
				prefer_location,
				nationality,
				religion,
				health,
				present_address,
				phone_number,
				full_name,
				function,
				marital_status,
				gender,
				dob,
				state_city,
				country,
				salary_expected,
				is_publish
			FROM
				post_cv
			WHERE
				id = '" . (int)$this->getId() . "'
		");
	
		if( ! $this->dbNumRows($q) ){
			throw new \Exception(
				"404: Post CV Not Found.",
				404
			);
		}
	
		$this->setProperties($this->dbFetchArray($q));
	}


	public function update() {
	
		if( !$this->getId() ) {
			throw new Exception("save method requires id");
		}
	
		$this->dbQuery("
			UPDATE
				post_cv
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
				marital_status = '" . $this->dbEscape( $this->getMaritalStatus() ) . "',
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
	
	public function insert(){	
		$this->dbQuery("
			INSERT INTO
				post_cv
			(
				customer_id,
				present_address,
				phone_number,
				email,
				apply_for,
				function,
				salary_expected,
				cover_letter_summary,
				full_name,
				gender,
				dob,
				nationality,
				religion,
				health,
				marital_status,
				country,
				state_city,
				working_history,
				experience,
				prefer_location,
				summary,
				photo,
				is_publish,
				viewed,
				status,
				create_date
			)
				VALUES
			(
				'" . $this->dbEscape($this->getCustomerId()) . "',
 				'" . $this->dbEscape($this->getPresentAddress()) . "',
 				'" . $this->dbEscape($this->getPhoneNumber()). "',
				'" . $this->dbEscape($this->getEmail()) . "',
				'" . $this->dbEscape($this->getApplyFor()) . "',
				'" . $this->dbEscape($this->getFunction()) . "',
				'" . $this->dbEscape($this->getSalaryExpected()) . "',
				'" . $this->dbEscape($this->getCoverLetterSummary()) . "',
				'" . $this->dbEscape($this->getFullName()) . "',
				'" . $this->dbEscape($this->getGender()) . "',
				'" . $this->dbEscape($this->getDob()) . "',
				'" . $this->dbEscape($this->getNationality()) . "',
				'" . $this->dbEscape($this->getReligion()) . "',
				'" . $this->dbEscape($this->getHealth()) . "',
				'" . $this->dbEscape($this->getMaritalStatus()) . "',
				'" . $this->dbEscape($this->getCountry()) . "',
				'" . $this->dbEscape($this->getStateCity()) . "',
				'" . $this->dbEscape($this->getWorkingHistory()) . "',
				'" . $this->dbEscape($this->getExperience()) . "',
				'" . $this->dbEscape($this->getPreferLocation()) . "',
				'" . $this->dbEscape($this->getSummary()) . "',
				'" . $this->dbEscape($this->getPhoto()) . "',
				 0,
				 0,
				 0,
 				NOW()
			)
		");
	}

}
