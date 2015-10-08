<?php
//Marco villegas 

namespace view;

require_once("view/LoginView.php");

class RegisterView
{ 
	private $loginView;
	
	 private static $Message = 'RegisterView::Message';
  private static $username = 'RegisterView::UserName';
	private static $password = 'RegisterView::Password';
  private static $passwordRepeat = 'RegisterView::PasswordRepeat';
  private static $register = 'RegisterView::Register';

 private static $Messagetext = "";

	public function __construct()
	{
		//$this->loginView = new \view\LoginView();
		$this->loginView = new \view\LoginView();
	}
	
	public function getName()//Funktion som hämtar användarenamnet man ska registrera 
	{
		$name = $_POST['RegisterView::UserName'];
		return $name;
	}
		
	public function getPassword1()//Funktion som hämtar Lösenordet man ska registrera  
	{
		$password1 = $_POST['RegisterView::Password'];
		return $password1;
	}
	
	public function getPassword2()//Funktion 2 som hämtar Lösenordet, använd för att kontrollerar att man kan sitt lösenord  
	{
		$password2 = $_POST['RegisterView::PasswordRepeat'];
		return $password2;
	}
		public function mess($nameMessage, $passwordMessage)//Bara en estetisk funktion som är skapad för att ge oss en fel meddelande string variabel 
	{
		
		
		if(empty($nameMessage) === true && empty($passwordMessage) === true)
	{
	$this->Messagetext;	
	}
	if(empty($nameMessage) === false && empty($passwordMessage) === true)
	{
	$this->Messagetext = $nameMessage;
	}
	if(empty($nameMessage) === true && empty($passwordMessage) === false)
	{
	$this->Messagetext = $passwordMessage;
	}
if(empty($nameMessage) === false && empty($passwordMessage) === false)
		{
		$this->Messagetext =	$nameMessage . "<br>"  . $passwordMessage;
		}
		
		
	}
	
	
	public function doRegisterView($nameMessage, $passwordMessage, $valueName)// visar registrerings formulären 
	{
	
	
	
	$this->mess($nameMessage, $passwordMessage);
		
		 return '
		  <a href="?">Back to login</a>
		   <h2>Not Logged in</h2>
    <h2>Register new user</h2>
      <form method="post">
        <fieldset>
          <legend>Register a new user - Write username and password</legend>
          <p id="'. self::$Message .'">'. $this->Messagetext .'</p>
					<label for="'. self::$username .'" >Username :</label>
					<input type="text" size="20" name='. self::$username .' id='. self::$username .' value="' . $valueName. '" />
					<br/>
					<label for="'. self::$password .'" >Password  :</label>
					<input type="password" size="20" name="'. self::$password .'" id="'. self::$password .'" value="" />
					<br/>
					<label for="'. self::$passwordRepeat .'" >Repeat password  :</label>
					<input type="password" size="20" name="'. self::$passwordRepeat .'" id="'. self::$passwordRepeat .'" value="" />
					<br/>
					<input id="submit" type="submit" name="'. self::$register .'"  value="Register" />
					<br/>
        </fieldset>
      </form>
    ';
		
	}
	
}
