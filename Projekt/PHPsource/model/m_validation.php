<?php
namespace model;
require_once("./PHPsource/helper/sessionHelper.php");

class Validation
{
	
	private $sessionHelper;
	private $errorMessage;
	
	public function __construct()
	{
		$this->sessionHelper = new \helper\SessionHelper();
	}
	
	public function validateName($name)
	{
		$safeName = $this->sessionHelper->makeSafe($name);		
		
	
		 if (empty($name)) 
		 {
		      $this->errorMessage ="Input field can not be empty. ";
		 }
			
	
		if ($name!= $safeName) 
		{
   			$this->errorMessage = "The name has unsafe characters in it!";
		}
		
	
		if (empty($this->errorMessage)) 
		{
			$this->sessionHelper->setName($safeName);
			return true;
		} else {
			$this->sessionHelper->setAlert($this->errorMessage);
			return false;
		}	
	}		
	
}
