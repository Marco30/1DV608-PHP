<?php

namespace model;

require_once("PHPsource/helper/sessionHelper.php");

class Password 
{

	const minPwLen = 6;
	private $pw;
	private $sessionHelper;

	public function __construct($password) 
    {
		$this->sessionHelper = new \helper\SessionHelper();
			
		if ($this->validatePw($password)) 
        {
			$this->pw = $password;
		}
		
	}
	
	public function getHashedPassword()
    {
		return $this->sessionHelper->encryptString($this->pw);
	}
	
	public function validatePw($password)
    {
		
		if (mb_strlen($password) < self::minPwLen) //extern validering för extra säkerhet
		{ 
			$this->sessionHelper->setAlert("Lösenordet har för få tecken. Minst 6 tecken.");  
		}
		
		return true;
	}
}