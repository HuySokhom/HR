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
		, $functionName
		, $salaryExpected
		, $coverLetterSummery
		, $fullName
		, $gender
		, $dob
		, $nationality
		, $maritalStatus
		, $religion
		, $health
		, $countryId
		, $countryName
		, $photo
		, $stateCity
		, $workingHistory
		, $experience
        , $summary
		, $isPublish
		, $viewed
		, $coverLetterSummary
		, $preferLocation
		, $currentPosition
	;
	
    public function setCurrentPosition( $string ){
        $this->currentPosition = $string;
    }
    public function getCurrentPosition(){
        return $this->currentPosition;
	}

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
        $this->preferLocation = (int)$string;
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

    public function setCountryId( $string ){
        $this->countryId = (int)$string;
    }
    public function getCountryId(){
        return $this->countryId;
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

    public function setCustomerId( $string ){
        $this->customerId = (int)$string;
    }
    public function getCustomerId(){
        return $this->customerId;
    }

    public function getFunctionName(){
        return $this->functionName;
    }
    public function setFunctionName( $string ){
        $this->functionName = $string;
    }
    public function getFunction(){
        return $this->function;
    }
    public function setFunction( $string ){
        $this->function = (int)$string;
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
				'current_position',
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
				'function_name',
				'create_date',
				'marital_status',
				'gender',
				'country_name',
				'dob',
				'state_city',
				'country_id',
				'status',
				'salary_expected',
                'is_publish',
			)
		);
	
		return parent::toArray($args);
	}
	
	public function load( $params = array() ){
		$q = $this->dbQuery("
			SELECT
				p.customer_id,
				p.summary,
				p.experience,
				p.viewed,
				p.phone_number,
				p.email,
				DATE_FORMAT(p.create_date, '%d/%m/%Y') as create_date,
				p.cover_letter_summary,
				p.working_history,
				p.apply_for,
				p.photo,
				p.prefer_location,
				p.nationality,
				p.religion,
				p.health,
				current_position,
				p.present_address,
				p.phone_number,
				p.full_name,
				p.function,
				cd.categories_name as function_name,
				p.marital_status,
				p.gender,
				p.dob,
				p.state_city,
				country_id,
				c.countries_name as country_name,
				p.salary_expected,
				p.is_publish,
				p.status
			FROM
				post_cv p LEFT JOIN countries c ON p.country_id = c.countries_id
				INNER JOIN categories_description cd ON p.function = cd.categories_id
			WHERE
				p.id = '" . (int)$this->getId() . "'
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
				present_address = '" . $this->dbEscape($this->getPresentAddress()) . "',
				phone_number = '" . $this->dbEscape($this->getPhoneNumber()) . "',
				current_position = '" . $this->dbEscape($this->getCurrentPosition()) . "',
				email = '" . $this->dbEscape($this->getEmail()) . "',
				apply_for = '" . $this->dbEscape($this->getApplyFor()) . "',
				function = '" . $this->dbEscape($this->getFunction()) . "',
				salary_expected = '" . $this->dbEscape($this->getSalaryExpected()) . "',
				cover_letter_summary = '" . $this->dbEscape($this->getCoverLetterSummary()) . "',
				full_name = '" . $this->dbEscape($this->getFullName()) . "',
				gender = '" . $this->dbEscape($this->getGender()) . "',
				dob = '" . $this->dbEscape($this->getDob()) . "',
				nationality = '" . $this->dbEscape($this->getNationality()) . "',
				religion = '" . $this->dbEscape($this->getReligion()) . "',
				health = '" . $this->dbEscape($this->getHealth()) . "',
				marital_status = '" . $this->dbEscape($this->getMaritalStatus()) . "',
				country_id = '" . $this->dbEscape($this->getCountryId()) . "',
				state_city = '" . $this->dbEscape($this->getStateCity()) . "',
				working_history = '" . $this->dbEscape($this->getWorkingHistory()) . "',
				experience = '" . $this->dbEscape($this->getExperience()) . "',
				prefer_location = '" . $this->dbEscape($this->getPreferLocation()) . "',
				summary = '" . $this->dbEscape($this->getSummary()) . "',
				photo = '" . $this->dbEscape($this->getPhoto()) . "'
			WHERE
				customer_id = '" . (int)$this->getCustomerId() . "'
					AND 
				id  = '" . (int)$this->getId() . "'
		");	
	}

	
	public function updateStatus() {
		if( !$this->getId() ) {
			throw new Exception("save method requires id");
		}
	
		$this->dbQuery("
			UPDATE
				post_cv
			SET
				status = '" . $this->getStatus() . "'
			WHERE
				customer_id = '" . (int)$this->getCustomerId() . "'
					AND 
				id  = '" . (int)$this->getId() . "'
		");	
	}
	
	
	public function refreshDate() {
		if( !$this->getId() ) {
			throw new Exception("save method requires id");
		}
	
		$this->dbQuery("
			UPDATE
				post_cv
			SET
				refresh_date = NOW()
			WHERE
				customer_id = '" . (int)$this->getCustomerId() . "'
					AND 
				id  = '" . (int)$this->getId() . "'
		");	
	}

	public function delete() {
		if( !$this->getId() ) {
			throw new Exception("save method requires id");
		}
	
		$this->dbQuery("
			DELETE FROM 
				post_cv
			WHERE
				customer_id = " . (int)$this->getCustomerId() . "
					AND 
				id  = " . (int)$this->getId() . "
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
				current_position,
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
				country_id,
				state_city,
				working_history,
				experience,
				prefer_location,
				summary,
				photo,
				is_publish,
				viewed,
				status,
				refresh_date,
				create_date
			)
				VALUES
			(
				'" . $this->dbEscape($this->getCustomerId()) . "',
 				'" . $this->dbEscape($this->getPresentAddress()) . "',
				'" . $this->dbEscape($this->getPhoneNumber()). "',
				'" . $this->dbEscape($this->getCurrentPosition()). "',
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
				'" . $this->dbEscape($this->getCountryId()) . "',
				'" . $this->dbEscape($this->getStateCity()) . "',
				'" . $this->dbEscape($this->getWorkingHistory()) . "',
				'" . $this->dbEscape($this->getExperience()) . "',
				'" . $this->dbEscape($this->getPreferLocation()) . "',
				'" . $this->dbEscape($this->getSummary()) . "',
				'" . $this->dbEscape($this->getPhoto()) . "',
				0,
				0,
				0,
				NOW(),
				NOW()
			)
		");
	}

}
