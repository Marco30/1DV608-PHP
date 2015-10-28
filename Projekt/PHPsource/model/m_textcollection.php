<?php
namespace model;
//Dependencies
require_once('./PHPsource/model/m_spokenwordList.php');

class Textcollection 
{
	private $TextcollectionID;
	private $name;
	private $SpokenWord;

	
	public function __construct($name, SpokenWordList $iSpokenWord = null, $iTextcollectionID = null) 
	{
	
		if ($iTextcollectionID == null) 
		{
			$this->TextcollectionID = 0;
		}
		else
		{
			$this->TextcollectionID =$iTextcollectionID;
		}
		$this->SpokenWord = ($iSpokenWord == null) ? new SpokenWordList(): $iSpokenWord;
		$this->name = $name;
	}


	public function getName() 
	{
		return $this->name; 	
	}

 
	public function getTextcollectionID() 
	{
		return $this->TextcollectionID;
	}
	

	public function setTextcollectionID($TextcollectionID) //TODO check if used in repository
	{  
		$this->TextcollectionID = $TextcollectionID;
	}
	

	public function add(\model\SpokenWord $iSpokenWord)
	{
		$this->SpokenWord->add($iSpokenWord);
	}
	

	public function getSpokenWord()
	{
		return $this->SpokenWord;
	}
	
}