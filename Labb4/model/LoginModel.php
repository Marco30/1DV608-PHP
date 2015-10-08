<?php  
//Marco villegas 
namespace model;

require_once("model/UserRepository.php");

class LoginModel
{

	private $password;
	private $username; 
	
	// Använder getter och setter för att till dela värden till mina privata variabler password och usernam 
	public function setPassword($value) 
	{
		$this->password = $value;
	}
	
	public function setUsername($value)
	{
		$this->username = $value;
	}
	
	public function getPassword()
	{
		return $this->password;
	}
	
	public function getUsername()
	{
		return $this->username;
	}
	
	public function checkIfLoggedIn()//Funktion som kontrollerar om man är inloggad eller in med sessions     
	{
		if(!isset($_SESSION['username']))
		{
	 	 	return false; 
		}else{
			return true;
		} 
	}
	
	

	public function checkUserExists($username,$password)// funktion som kontrolerar att det inmatade användarnamn och lösenord är sammas som den sparade medlemens användarnamn och lösenord i funktion 
	{
		
$userRepository = new \model\UserRepository();
//var_dump($username); test
//var_dump($password); test 
			if($userRepository->checkBeforeLogin($username, $password))// Om värderna stämmer tilldelas $_SESSION['username'] värdet i parametern. 
			{ 
			$_SESSION['username'] = $username;
			
			$this->setPassword($password);
			
			$this->setUsername($username); 
			
			return true;		
			
				
			}
			else
			{
				return false;
			}
		
	}
	

	
	public function sessionStart()// funktion som startar sessionen 
	{
		session_start();
	}
	
	public function sessionDestroy()// funktion som tar bort  sessionen
	{
		session_destroy();
	}
	
}
