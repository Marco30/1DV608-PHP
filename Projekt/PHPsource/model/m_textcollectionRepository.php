<?php
namespace model;

require_once ('./PHPsource/model/m_textcollection.php');
require_once ('./PHPsource/model/m_textcollectionList.php');
require_once ('./PHPsource/model/m_spokenwordRepository.php');
require_once ('./PHPsource/model/DAL/Repository.php');
require_once("PHPsource/helper/sessionHelper.php");

class TextcollectionRepository extends DAL\Repository {
	private $Textcollection;
	private $sessionHelper;
	
	//DB felt
	private static $TextcollectionID ='textcollectionID';
	private static $name = 'name';
	private static $userID = 'userID';
	private static $username ='username';
	private static $userIDFK = 'userIDFK';
	public static $TextcollectionIDFK = 'textcollectionIDFK';
	private static $SpokenWordID = 'spokenwordID';
	private static $practicedTime = 'time';
	private static $notes = 'poem';
	
	//DB tabeller 
	private static $SpokenWordTable = 'spokenword';
	private static $userTable = 'user';
	

	public function __construct() 
	{
		$this -> dbTable = 'textcollection';
		$this -> Textcollection = new TextcollectionList();
		$this->sessionHelper = new \helper\SessionHelper();
	}
	
	public function add($TextcollectionName, $username) //lägger till i textcollection tabbelen
	{
	
			 	$db = $this->connection();
			
				$userIDFK = $this->getUserID($username);
				
				
				if ($this->nameAlreadyExists($TextcollectionName, $userIDFK)) // kontrolärar om text namn redan finns i databas 
				{
					$this->sessionHelper->setAlert("You already have an instrument called '". $TextcollectionName . "'. </p><p>Please choose a new name.");
					return null;	
				}
				
	
			    
				$sql = "INSERT INTO $this->dbTable (". self::$TextcollectionID . ", " . self::$name . " , " . self::$userIDFK . ") VALUES (  ?, ?, ?)";
				$params = array("", strtoupper($TextcollectionName), $userIDFK);
		
				$query = $db->prepare($sql);
				$query->execute($params);
				
				
				$iTextcollectionID = $db->lastInsertId();
				
				$mainTextcollectionID = $this->getMainTextcollection($username);
			
				
				
				if ($mainTextcollectionID == 0)
					$this->updateMainTextcollection($iTextcollectionID, $username);
				
				return $iTextcollectionID;
	}

	public function get($iTextcollectionID) 
	{  
		
		$db = $this -> connection();

		$sql = "SELECT * FROM $this->dbTable WHERE " . self::$TextcollectionID . " = ?";
		$params = array($iTextcollectionID);

		$query = $db -> prepare($sql);
		$query -> execute($params);

		$result = $query -> fetch();

		if ($result) 
		{
			$i2Textcollection = new \model\Textcollection( $result[self::$name], null, $result[self::$TextcollectionID]);
			
			$sql = "SELECT * FROM ".self::$SpokenWordTable. " WHERE ".SpokenWordRepository::$TextcollectionID." = ?";
			$query = $db->prepare($sql);
			$query->execute (array($result[self::$TextcollectionID]));
			$iSpokenWord = $query->fetchAll();
			
			foreach($iSpokenWord as $i2SpokenWord) 
			{
				$newSpokenWord = new SpokenWord($i2SpokenWord[self::$name], $i2SpokenWord[self::$SpokenWordID], $i2SpokenWord[self::$TextcollectionIDFK]);
				$i2Textcollection->add($newSpokenWord);
			}
			return $i2Textcollection;
		}

		return null;
	}

	 
	public function getTextcollectionID($name, $username) 
	{ 
		$db = $this -> connection();

		$sql = "SELECT * FROM $this->dbTable WHERE " . self::$name . " = ? AND " . self::$userIDFK . "= ?";
		$params = array($name, $username);

		$query = $db -> prepare($sql);
		$query -> execute($params);

		$result = $query -> fetch();	
		
		return $result->name;	
			
    }

	public function delete(\model\Textcollection $iTextcollection, $username) 
	{
			
		
		$mainTextcollectionID = $this->getMainTextcollection($username);
		$iTextcollectionID = $iTextcollection -> getTextcollectionID();
		
	
		if ($mainTextcollectionID == $iTextcollectionID)
		{	
			$this->updateMainTextcollection(0, $username);
			$mainTextcollectionID = 0;
		}
	
		$db = $this -> connection();

		//delete texter från SpokenWordtabel
		$sql = "DELETE * FROM". self::$SpokenWordTable. "WHERE" . self::$TextcollectionID . "= ?";
		$params = array($iTextcollection -> getTextcollectionID());
		
		//tar bort Textcollection från Textcollection tabell
		$sql = "DELETE FROM $this->dbTable WHERE " . self::$TextcollectionID . "= ?";
		$params = array($iTextcollection -> getTextcollectionID());

		$query = $db -> prepare($sql);
		$query -> execute($params);
		
		
		$mainTextcollectionID = $this->getMainTextcollection($username);
		$this->sessionHelper->unsetSession();
		$this->sessionHelper->setHTextcollectionID($mainTextcollectionID);
	}
	
	public function toList($username) 
	{
		
		try {
			$db = $this -> connection();
			
			$userIDFK = $this->getUserID($username);
			
			$sql = "SELECT * FROM `". $this->dbTable. "` WHERE " . self::$userIDFK . "= ?";
			$params = array($userIDFK);
			$query = $db -> prepare($sql);
			$query -> execute($params);

			foreach ($query->fetchAll() as $owner) {
				$name = $owner[self::$name];
				$iTextcollectionID = $owner[self::$TextcollectionID];

				$iTextcollection = new Textcollection($name, null, $iTextcollectionID);

	 
				$sql = "SELECT * FROM ".self::$SpokenWordTable. " WHERE ".SpokenWordRepository::$TextcollectionID." = ?";
				$query = $db->prepare($sql);
				$query->execute (array($iTextcollectionID));
				$iSpokenWord = $query->fetchAll();
			 

				foreach($iSpokenWord as $i2SpokenWord) {
					$newSpokenWord = new SpokenWord($i2SpokenWord[self::$name], $i2SpokenWord[self::$SpokenWordID], $i2SpokenWord[self::$TextcollectionIDFK], $i2SpokenWord[self::$notes], $i2SpokenWord[self::$practicedTime]);
					$iTextcollection->add($newSpokenWord);
				}	
			
				$iTextcollection->setTextcollectionID($iTextcollectionID);
		
				$this->Textcollection->add($iTextcollection);
			}
			
			return $this->Textcollection;
			
		} 
		catch (\PDOException $e) 
		{
			echo '<pre>';
			var_dump($e);
			echo '</pre>';

			die('Error while connection to database.');
		}
	}

	public function nameAlreadyExists($TextcollectionName, $userID) //Kontrollerar namn på collection inte redan finns 
	{
		
			$db = $this->connection();
			$sql = "SELECT * FROM $this->dbTable WHERE `" .self::$name . "` = ? AND `" .self::$userIDFK . "` = ?";
			$params = array($TextcollectionName, $userID );
			$query = $db->prepare($sql);
			$query->execute($params);
			
			if ($query->rowCount() > 0) 
        		return true;

			return false;
	}


	 
	public function getMainTextcollection($username) // använda för att lässa in alla texsamlingar en användare har
	{
		
				$db = $this->connection();
				
			
				$sql= "SELECT `". self::$TextcollectionIDFK . "` FROM `". self::$userTable . "` WHERE `". self::$username . "` = '".$username. "' LIMIT 1";
				$query = $db->prepare($sql);
				$query->execute();
				$result= $query->fetch(\PDO::FETCH_ASSOC);
				
				
		return $result[self::$TextcollectionIDFK];
	}

	public function getUserID($username) // hämtar userID från tabel 
	{
					
				$db = $this -> connection();
				
				$sql= "SELECT `". self::$userID . "` FROM `". self::$userTable . "` WHERE `". self::$username . "` = '".$username. "' LIMIT 1";
				$query = $db->prepare($sql);
				$query->execute();
				$result= $query->fetch(\PDO::FETCH_ASSOC);
			
				
				return $result[self::$userID];
	}
	
	public function updateMainTextcollection($iTextcollectionID, $username) 
	{
		
				$db = $this->connection();
				$db->beginTransaction();
							
				$userID = $this->getUserID($username);
							
				$sql = "UPDATE ". self::$userTable . "
		        SET ". self::$TextcollectionIDFK . "=?
				WHERE " . self::$userID . "=?";
				
				$params = array($iTextcollectionID, $userID);
				$query = $db->prepare($sql);
				$query->execute($params);
				
				$db->commit(); 
				
				$this->sessionHelper->unsetSession();
				$this->sessionHelper->setHTextcollectionID($iTextcollectionID);
	
	}
}
