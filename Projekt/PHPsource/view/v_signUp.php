<?php
namespace view;

  class SignUp 
  {
    private $model;
	private $sessionHelper;
	
	private static $username = "SignUp::UserName";
	private static $password = "SignUp::Password";
	private static $repeatPw = "SignUp::repeatPw";
	private static $signUpBtn = "SignUp::signUpBtn";
	private static $actionSignUp = "signUp";
	private static $getAction = "action";
	private $errorMessage = "";
	private $unValue = "";

    public function __construct(\model\UserRepository $model) 
    {
      $this->model = $model;
	  $this->sessionHelper = new \helper\SessionHelper();
    }
	
	public function showSignUp () 
	{
		
		$ret = "<h2>Sign Up</h2>";
	
		$ret .= "<div id='signUpView'>";
	    $ret .= "
		  <form action='?" . self::$getAction . "=" . self::$actionSignUp ."' method='post'>
		  	<label for='" . self::$username . "'>Username</label>
		    <input type='text' name='" . self::$username . "' placeholder='Username' value='$this->unValue' maxlength='30'>
		    <br />
		    <label for='" . self::$password . "'>Password</label>
		    <input type='password' name='" . self::$password . "' placeholder='Password' value='' maxlength='30'>
		    <br />
		    <label for='" . self::$repeatPw . "'>Repeat password</label>
		    <input type='password' name='" . self::$repeatPw . "' placeholder='Password' value='' maxlength='30'>
		    <br />
		    <input type='submit' value='Sign up' name='" . self::$signUpBtn. "' id='submit'>
		  </form>";
	   $ret .= "<div class='errorMessage'><p>".$this->sessionHelper->getAlert() ."</p></div>";
	   $ret .= "</div><br />";
	  

      return $ret;
	}
	
	public function didUserPressSignUp () 
	{
		if (isset($_GET[self::$getSignUp]))
    {
        return true;   
	}
		return false;
	}
	
	public function SignUpAttempt() 
	{
		if (isset($_POST[self::$signUpBtn]))
			return true;
		return false;
	}
	
	public function getUsernameInput()
	{
		if($this->SignUpAttempt()) 
		{		
			return $this->sessionHelper->makeSafe($_POST[self::$username]);
		}
	}
	
	public function getPasswordInput()
	{
		if($this->SignUpAttempt()) 
		{
			return $this->sessionHelper->makeSafe($_POST[self::$repeatPw]);
		}
	}
		
	public function validateInput() 
	{  
	  if ($this->SignUpAttempt()) 
	  {
	  						
	  	$un = $_POST[self::$username];
		$pw = $_POST[self::$password];		
	  		
	  	// kontrollerar att användarnamn/lösenord inte är toma
		 if (empty($un)) 
		 {
		      $this->errorMessage ="Användarnamnet har för få tecken. Minst 3 tecken <br /> ";
			
		 }
			
		if (empty($pw)) 
		{
		      $this->errorMessage .= "Lösenordet har för få tecken. Minst 6 tecken <br />";			
		}
		
		if (isset($un))
		{
				$this->unValue = strip_tags($un);
			} 
		
		//kontrollerar så att inga html tagar finns med 
		if ($un!= strip_tags($un)) 
		{
   			$this->errorMessage = "Användarnamnet innehåller ogiltiga tecken <br />";
		}
		
		//kontrollerar att lösenord matchar 
		if (!empty($_POST[self::$repeatPw])) 
		{
		
			 if(!empty($_POST[self::$password]))
			 {
	
				if (!$this->isPasswordMatch()) 
				{	
					$this->errorMessage = "Lösenorden matchar inte <br />";
				}	
			 }
		}

		return $this->errorMessage;
	  }
	}
	
	public function isPasswordMatch()
	{
	    	
			if (strcmp($_POST[self::$password], $_POST[self::$repeatPw]) === 0) 
					return true;

			if(isset($_POST[self::$username])) 
			{
					$this->unValue = $_POST[self::$username];
			 }
	return false;
	
	}
}