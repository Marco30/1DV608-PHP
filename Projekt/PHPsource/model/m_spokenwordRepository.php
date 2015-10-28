<?php
namespace model;

//Dependencies
require_once ('./PHPsource/model/DAL/Repository.php');
require_once ('./PHPsource/model/m_spokenwordList.php');

class SpokenWordRepository extends DAL\Repository {
	private $SpokenWord;
	private $sessionHelper;
	
	//DB fält
	private static $name = 'name';  
	private static $SpokenWordID = 'spokenwordID';
	private static $notes = 'poem';
	private static $practicedTime = 'time';
	public static $TextcollectionID = 'textcollectionIDFK';
	
	
	public function __construct() 
	{
		$this -> dbTable = 'spokenword';
		$this -> SpokenWord = new SpokenWordList();
		$this->sessionHelper = new \helper\SessionHelper();
	}

	public function add(SpokenWord $iSpokenWord) 
	{
		
		
		if ($this->nameAlreadyExists($iSpokenWord->getName(), $iSpokenWord->getOwner()->getTextcollectionID())) // kontrolerar att text inte redan finns i DB
		{
			$this->sessionHelper->setAlert("You already have a song called '". $iSpokenWord->getName() . "'. </p><p>Please choose a new name.");
			return null;	
		}
		else 
		{ 
		
			$sql = "INSERT INTO $this->dbTable (". self::$SpokenWordID . ", " . self::$name . ",  ".self::$TextcollectionID.") VALUES (?, ?, ?)";
			$params = array("", ucfirst($iSpokenWord -> getName()), $iSpokenWord->getOwner()->getTextcollectionID());

			$iSpokenwordID = $this->query($sql, $params, true);
			return $iSpokenwordID;
		}
		
	}

	public function get($iSpokenWordID) 
	{
		$db = $this -> connection();

		$sql = "SELECT * FROM $this->dbTable WHERE " . self::$SpokenWordID. " = ?";
		$params = array($iSpokenWordID);
		$query = $db -> prepare($sql);
		$query -> execute($params);

		$result = $query -> fetch();

		if ($result)
		{
			return new \model\SpokenWord($result[self::$name], $result[self::$SpokenWordID],
			$result[self::$TextcollectionID] , $result[self::$notes], $result[self::$practicedTime]);  
		}
	}

	
	public function nameAlreadyExists($name, $iTextcollectionID) 
	{
			$db = $this->connection();
			$sql = "SELECT * FROM $this->dbTable WHERE `" .self::$name . "` = ? AND `" .self::$TextcollectionID . "` = ?";
			$params = array($name, $iTextcollectionID );
			$query = $db->prepare($sql);
			$query->execute($params);
			
			if ($query->rowCount() > 0) 
        		return true;

			return false;
	}


	public function saveNotes ($notes, $iSpokenWordID) // lägger till texten i spoken word tabellen
	{
		
				
				$sql = "UPDATE ". $this -> dbTable . "
		        SET ". self::$notes . "=?
				WHERE " . self::$SpokenWordID . "=?";
				
				$params = array($notes, $iSpokenWordID);
				$this->query($sql, $params);
							
		
	}
	
	public function delete($iSpokenWordID, $iTextcollectionID) 
	{
			
		$sql = "DELETE FROM $this->dbTable WHERE " . self::$SpokenWordID. "= ? AND ". self::$TextcollectionID. "= ?" ;
		$params = array($iSpokenWordID, $iTextcollectionID);
		$this->query($sql, $params);
		
	}
	
}
