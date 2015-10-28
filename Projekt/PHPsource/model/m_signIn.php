<?php
  namespace model;

  require_once("PHPsource/helper/sessionHelper.php");
  require_once('m_userRepository.php');
  
  class SignIn 
  {
  	private $cookieStorage;
    private $sessionHelper;
	private $userRepository;
    private static $uniqueID = "SignIn::UniqueID";
    private static $username = "SignIn::Username";
	private static $password = "SignIn::Password";

    public function __construct() 
    {
      $this->cookieStorage = new \helper\CookieStorage();
	  $this->userRepository = new \model\UserRepository();
      $this->sessionHelper = new \helper\SessionHelper();
    }

 
    public function userIsSignedIn() // Kontrollera om användaren är inloggad med sessionen
    {
    	
	 if (isset($_SESSION[self::$uniqueID])) 
	 {
        
        if ($_SESSION[self::$uniqueID] === $this->sessionHelper->setUniqueID()) // Kontrollera om sessionen är giltig
        {
          return true;
        }

      return false;
     }
      
    }

  
    public function signIn($postUsername, $postPassword, $postRemember) 
    { 
   
        
     	$un = $this->sessionHelper->makeSafe($postUsername);    
    	$pw =  $this->sessionHelper->makeSafe($postPassword);    

	  
      if (empty($postUsername)) 
      {
        $this->sessionHelper->setAlert("Username is missing");
        return false;
      }
      else if (empty($postPassword)) 
      {
        $this->sessionHelper->setAlert("Password is missing");
        return false;
      }
	  
      
    
		if (!$this->userRepository->find($un, $this->sessionHelper->encryptString($pw))) // Kontrollera mot databasen om rätt användarnamn och lösenord har använts 
		{
			  $this->sessionHelper->setAlert("Wrong username or/and password");  
			return false;
		}
		
	
        $_SESSION[self::$uniqueID] = $this->sessionHelper->setUniqueID();// sätter session för användaren
        $_SESSION[self::$username] = $un;
		$_SESSION[self::$password] = $pw;

        
        if (!$postRemember) // Om man inte X Remember inte fått ett värde
        {
          $this->sessionHelper->setAlert("Sign in was successfull!"); 
        }
		
	   return true;
    }
   
    public function signOut() // loga ut användare
    {  
      
      if (isset($_SESSION[self::$uniqueID])) 
      {
      		unset($_SESSION[self::$uniqueID]);
		  session_destroy();
      return true;
      }
      
      return false;
    }
  }
