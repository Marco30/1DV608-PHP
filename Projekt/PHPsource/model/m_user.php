<?php

namespace model;

require_once('m_pw.php');
require_once("PHPsource/helper/sessionHelper.php");


class User
{   

	const minUsernameLen = 3;
	private $uniqueKey;
	private $username;  
	private $password;		
	private $sessionHelper;
	

	public function __construct($unique, $username, \model\Password $password) 
	{
		$this->sessionHelper = new \helper\SessionHelper();
		$this->uniqueKey = $unique;
		
		if ($this->validateUsername($username)) 
		{
			$this->username = $username;
		}
		
		$this->password = $password->getHashedPassword();
	}
	
	public function getUsername()
	{ 
		return $this->username;
	}
	
	public function setUsername($username) 
	{  
		$this->username =username;
	}
	
	public function getPassword() 
	{
		return $this->password;
	}
	
	public function getUnique() 
	{
	return $this->uniqueKey;	
	}
	
	public function validateUsername($username) // extra validering 
	{
		
		if (mb_strlen($username) < self::minUsernameLen) 
		{
			$this->sessionHelper->setAlert("The username must be at least 3 characters long");  
			throw new \Exception();
		}
		
		return true;
	}
	
}



