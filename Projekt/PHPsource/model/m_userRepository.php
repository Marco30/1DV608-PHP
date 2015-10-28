<?php

namespace model;

require_once('DAL/Repository.php');
require_once("PHPsource/helper/sessionHelper.php");

class UserRepository extends \model\DAL\Repository 
{
	
	private static $key = 'uniqueKey';
	private static $userID = 'userID';
	private static $username = 'username';
	private static $password = 'password';
	private static $owner = 'userUnique';
	private $sessionHelper;

	public function __construct() 
	{
		$this->dbTable = 'user';
		$this->sessionHelper = new \helper\SessionHelper();
	}

	public function add(User $user)
	{
	
		try 
		{
			
			$db = $this->connection();
			$sql = "INSERT INTO $this->dbTable (".self::$userID.",".self::$username.", ".self::$password.", ".TextcollectionRepository::$TextcollectionIDFK.") VALUES (?,?,?,?)";
			
			$params = array('', $user->getUsername(), $user->getPassword(), 0);
			
			$query = $db->prepare($sql);  
			
			$query->execute($params);
			
			$this->sessionHelper->setAlert("User was successfully added");
			
			$this->sessionHelper->setCreatedUsername($user->getUsername());  
		}
		catch(\PDOExeption $e)
		{  
			throw new \Exception($e);
		}
	}
	
	public function find($username, $password)// går igenom DB
	{ 
		 
		$db = $this->connection();
		$sql= "SELECT `".self::$username."` FROM $this->dbTable WHERE `".self::$username."` = '".$username. "' AND `".self::$password."`= '".$password. "'";			
		
		$query = $db->prepare($sql);  
		
		$query->execute();
		
		 if ($query->rowCount() > 0) 
		 {
        	return true;
	   	 } 

	    else 
	    {
	       return false; 
	    }
			
	}
	
	public function usernameAlreadyExists($username)// kontrollerar om man redan finns 
	{
		
		try{
			$db = $this->connection();
			$sql = "SELECT * FROM $this->dbTable WHERE `" .self::$username . "` = ?";
			$params = array($username);
			$query = $db->prepare($sql);
			$query->execute($params);
			
			if ($query->rowCount() > 0) 
        		return true;

			return false;
		}
		catch(\PDOException $e)
		{
			throw new \Exception($e->getMessage());   
		}
	}
}
