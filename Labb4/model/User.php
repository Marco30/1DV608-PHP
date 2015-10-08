<?php
//Marco villegas 

namespace model;

class User{
	
	private $name;
	private $password1;
	private $tag; 
	

	public function name($input)// validerar användarnamnet vid registrering  
	{ 
	    $checkedName = $this->checkForTags($input);
	    
		if(strlen($input) >= 3)
		{
			$this->name = $checkedName;
			return true;
			
		}
		else
		{
			return false;
		}
	}
	

	public function password($input)	// validerar lösenordet vid registrering  
	{
	    
		if(strlen($input) >= 6)
		{
			$this->password1 = $input;
			return true;
			
		}
		else
		{
			return false;
		}		
	}
	
	
	public function checkIfPasswordMatch($password2)// kollar så att båda lösenorden matchar vid registrering  
	{
	    
		if($this->password1 === $password2)
		{
			return true;
			
		}
		else
		{
			return false;
		}
		
	}
	

	public function checkForTags($name)// kollar efter htmlkod/tags i namnet 
	{
		
		//var_dump($name);
		
		if(strip_tags($name) === $name)
		{
			$this->tag = false;
			return $name; 
			
		}
		else
		{
			$this->tag = true;
			return strip_tags($name);
		}
	}
		
	public function tagInName()// kallas för att få infom om den har htmlkod/tags eller inte 
	{
	    
		if($this->tag === true)
		{
			return true;
		}
	    return false;
	}
		
	public function getUserName()// ger namn
	{
		return $this->name;
	}
	
	public function getPassword()// ger password 
	{
		$Password5 = $this->password1;
		return $Password5;
	}
}
