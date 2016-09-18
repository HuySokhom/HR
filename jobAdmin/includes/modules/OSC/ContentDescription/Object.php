<?php

namespace OSC\ContentDescription;

use
	Aedea\Core\Database\StdObject as DbObj
;

class Object extends DbObj {
		
	protected
		$pagesContent
		, $pagesTitle
		, $pagesId
		, $languageId
	;

	public function toArray( $params = array() ){
		$args = array(
			'include' => array(
				'id',
				'pages_content',
				'pages_title',
				'pages_id',
				'language_id'
			)
		);

		return parent::toArray($args);
	}
	
	public function load( $params = array() ){
		$q = $this->dbQuery("
			SELECT
				pages_title,
				pages_content,
				language_id,
				pages_id
			FROM
				page_description
			WHERE
				id = '" . (int)$this->getId() . "'	
		");
		
		if( ! $this->dbNumRows($q) ){
			throw new \Exception(
				"404: Page Description not found",
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
				page_description
			SET
				pages_title = '" .  $this->getPagesTitle() . "',
				pages_content = '" . $this->dbEscape(  $this->getPagesContent() ) . "',
				update_by = '" . $this->getUpdateBy() . "'
			WHERE
				id = '" . (int)$this->getId() . "'
					AND
				language_id = '" . (int)$this->getLanguageId() . "'
		");
	}

	public function insert(){
		$this->dbQuery("
			INSERT INTO
				page_description
			(
				pages_content,
				pages_title,
				create_by,
				create_date,
				language_id
			)
				VALUES
			(
				'" . $this->dbEscape(  $this->getPagesContent() ) . "',
				'" . $this->getPagesTitle() . "',
				'" . $this->getCreateBy() ."',
				NOW(),
				'" . $this->getLanguageId() ."'
			)
		");
		$this->setId( $this->dbInsertId() );
	}

	public function setPagesContent( $string ){
		$this->pagesContent = $string;
	}
	
	public function getPagesContent(){
		return $this->pagesContent;
	}

	public function setPagesTitle( $string ){
		$this->pagesTitle = (string)$string;
	}
	public function getPagesTitle(){
		return $this->pagesTitle;
	}

	public function setLanguageId( $string ){
		$this->languageId = (int)$string;
	}
	public function getLanguageId(){
		return $this->languageId;
	}

	public function setPagesId( $string ){
		$this->pagesId = (int)$string;
	}
	public function getPagesId(){
		return $this->pagesId;
	}
}
