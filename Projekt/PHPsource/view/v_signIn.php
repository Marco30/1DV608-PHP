<?php
  namespace view;

  require_once("PHPsource/controller/c_signIn.php");
  require_once("PHPsource/helper/CookieStorage.php");
  require_once("PHPsource/helper/sessionHelper.php");
  require_once("PHPsource/helper/FileStorage.php");

  class SignIn {
    private $model;
    private $cookieStorage;
    private $sessionHelper;
	private $fileStorage;
	public static $getAction = "action"; 
	
	//loga in/loga ut 
	public static $actionSignIn = 'signIn';
	public static $actionSignOut = "signOut";
	
    //Namn på fält och knapar i html formulären 
	private static $uniqueID  = "SignIn::UniqueID";
	private static $signInBtn  = "SignIn:signInBtn";
	private static $rememberUser = "rememberUser";
	private static $username = "SignIn::Username";
	private static $password = "SignIn::Password";


    public function __construct(\model\SignIn $model) 
    {
      $this->model = $model;
      $this->cookieStorage = new \helper\CookieStorage();
	  $this->fileStorage = new \helper\FileStorage();
      $this->sessionHelper = new \helper\SessionHelper(); 
    }
	
// kontrollerar om användar har tryck på logan in 
	public static function hasUserChosenSignInpage() 
	{
		if (isset($_GET[self::$getAction]))
		{
			if( $_GET[self::$getAction] == self::$actionSignIn) 
			return true;
		}
		return false;   
	}
		
	
	public function SignOutAttempt() // kontrollerar om användar har tryck på logan out
	{  
		if (isset($_GET[self::$getAction])) 
		{
			if($_GET[self::$getAction] == self::$actionSignOut)
			return true;
		}
		return false;
	}
	
// ger lösenord och användarnamn
	public function getFormData() 
	{
		if (isset($_POST[self::$username])) 
		{
			$remember = false;	
			if (isset($_POST[self::$username])) 
			{
			$remember = true;
			}
			return array($_POST[self::$username], $_POST[self::$password], $remember ); //TODO return object
		}
		
		return NULL;
	}

      // visar sidan när man int är inlogad 
    public function showHomepage() {
	  $html  = "<div id='homepage'>";
	  $html  = "<div id='startMessage'>";
      $html .= "<h2>Welcome to Spoken Word!</h2>";
	  $html .= "<p>A place where people share their thoughts and ideas!</p>";
	  $html .= "</div>";
	  $html .= "<div class='successMessage'><p>".$this->sessionHelper->getAlert() ."</p></div>";
	  $html .= "<a href='?".self::$getAction."=".NavigationView::$actionSignUp."' id='signUp'>Sign up</a>"; 
	  $html .= "<a href='?".self::$getAction."=".self::$actionSignIn."' id='signIn'>Sign in</a>";  
	  $html .= "<div id='musicbar'><div id='treble'></div><ul>
	  			<li>Keep track of your Spoken Word Collection</li>
	  			</ul></div>";  
	  $html .= "</div>";

      return $html;
    }

  // visa log in sidan 
    public function showSignIn() 
    {
	  $username =  $this->sessionHelper->getCreatedUsername();
	 
	  if (empty($username))
	  {
	    $username = empty($_POST[self::$username]) ? '' : $_POST[self::$username];
	  }
	  
	  $html  = "<div id='signInView'>";
      $html .= "<h2>Sign in</h2>";

      $html .= "
	  <form action='?" . self::$getAction . "=" . self::$actionSignIn ."' method='post'>";
	  $html .=  "<input type='text' name='". self::$username . "' placeholder='Username' value='".$username."' maxlength='30'>
	    <input type='password' name='". self::$password. "' placeholder='Password' value='' maxlength='30'>
	    <input type='checkbox' id='". self::$rememberUser. "' name='". self::$rememberUser. "' >
	    <p>Remember me</p>
	    <input type='submit' value='Sign in' name='". self::$signInBtn. "' id='submit'>
	  </form>"; 
	  $html .= "<div class='errorMessage'><p>".$this->sessionHelper->getAlert() ."</p></div>";
	  $html .= "</div>";

      return $html;
    }

	
	public function SignOut(){
		 if ($this->cookieStorage->isCookieSet(self::$uniqueID)) 
		 {
        
		  // förstör cookies
          $this->destroyCookies();
		  
		  // tar bort cookie filen
          $this->fileStorage->removeFile($this->cookieStorage->getCookieValue(self::$uniqueID)); 
		return true;
        }
		return false;
	}
	
	public function destroyCookies()// förstör alla cookies
	{
		
          $this->cookieStorage->destroy(self::$uniqueID);
          $this->cookieStorage->destroy(self::$username);
          $this->cookieStorage->destroy(self::$password);
		
	}


	public function rememberUser()// kom ihåg användare 
	{
		if (isset($_POST[self::$rememberUser]))
        return true;

      return false;	
	}	
	
	public function getUsernameInput()
	{
			return $this->sessionHelper->makeSafe($_POST[self::$username]);
	}
	
	public function getPasswordInput(){
			return $this->sessionHelper->makeSafe($_POST[self::$password]);
	}		
	
	public function setCookies($postRemember) // sätter cookies
	{
	
     	$un = $this->getUsernameInput();   
    	$pw =  $this->getPasswordInput();
		 
        if ($postRemember) // If $postRemember hhar krysat för så körs if satsen
        {
        
          $this->cookieStorage->save(self::$uniqueID, $_SESSION[self::$uniqueID], true);
          $this->cookieStorage->save(self::$username, $un);  
          $this->cookieStorage->save(self::$password, $this->sessionHelper->encryptString($pw));

          $this->sessionHelper->setAlert("Inloggning lyckades och vi kommer ihåg dig nästa gång");
        } 
	}
	public function getUsernameCookie() {
		return $this->cookieStorage->getCookieValue(self::$username);
	}
	public function getPasswordCookie() {
		return $this->cookieStorage->getCookieValue(self::$password);
	}
	
    public function checkCookies() {
    
  
    if ($this->cookieStorage->isCookieSet(self::$uniqueID)) // måste fixa lites saker 
    {
        	
        
        if ($this->cookieStorage->getCookieValue(self::$uniqueID) === $this->sessionHelper->setUniqueID() )// Kontrollera om uniqid gäller för den här webbläsare
         {
		  
	          
	          if (!$this->cookieStorage->isCookieValid($this->cookieStorage->getCookieValue(self::$uniqueID)))// Kontrollera att uniqid cookie inte är manipulerad 
	          {
	          	
	            
         		 $this->destroyCookies();
	
	           
	            $this->sessionHelper->setAlert("Wrong information in cookie.");
	            return false;
	          }

	          return true;
			 }
      	   else 
      	   {
     
          $this->cookieStorage->destroy(self::$uniqueID);
          $this->cookieStorage->destroy(self::$username);
          $this->cookieStorage->destroy(self::$password);
		  

          $this->sessionHelper->setAlert("Wrong information in cookie.");
          return false;
          }
      } 
      else 
      {
        return false;
      }
     }

  }
