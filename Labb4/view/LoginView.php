<?php
//Marco villegas 

namespace view;

class LoginView
{
	
    private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';
	private static $keep = 'LoginView::KeepMeLoggedIn';
	private static $messageId = 'LoginView::Message';
	
	private static $newUser = 'LoginView::RegisterNewUser';
	
	private $username;
	private $messageView;

	
	public function __construct()
	{
		$this->messageView = new \view\MessageView();
	}
	
		public function SetUsername($username1)// Funktion som kontrollerar om användaren har tryckt på login knapen  
	{
 	   $this->username =  $username1;	
	}
	
	
	public function pressedLogin()// Funktion som kontrollerar om användaren har tryckt på login knapen  
	{
		if(isset($_POST['LoginView::Login']))// om isset($_POST["login"]) är true så körs if satsen som betyder att post knapen har tryckt på 
		{
			return true;
		}
		else// om post knappen är otryckt så får vi till baks falls
		{
			return false;
		}	
	}
	
	public function pressedLogout()// Funktion som kontrollerar om användaren har tryckt på logga ut knapen  
	{
		if(isset($_POST['LoginView::Logout']))
		{
			return true;
		}else
		{
			return false;
		}	
	}
	
	public function getUsernameInput()//Funktion som ger oss användarnamnet som mattas in i formulären 
	{
		 $this->username  = $_POST['LoginView::UserName'];// variabeln $username till delas värdet som finns i $_POST["username"] 
		return $this->username ;
	}
	
	public function getPasswordInput()//Funktion som ger oss password som mattas in i formulären 
	{
		$password = $_POST['LoginView::Password'];
		return $password; 
	}
	

	

	public function controllInput()//Funktion som Kontrollerar de inskrivna värden i formuläret 	
	{
		//Följande två funktioner kallar på det två funktioner som finns här ovan för att få användarnamn och lösenord    
		$username = $this->getUsernameInput(); 
		$password = $this->getPasswordInput();
		
		$usernameMissing = $this->messageView->usernameMissingMessage();
		$passwordMissing = $this->messageView->passwordMissingMessage();
		$wrongInput = $this->messageView->wrongInputMessage();
		$loggout = $this->messageView->loggoutMessage();
		$allgood = $this->messageView->allgoodMessage();

		
		if($password === "" && $username === "")// if och else satser som jag använder för att kontrollerar att både användarnamn och lösenord är i fyllda        
		{
			return $usernameMissing; 
		}
		else if($password === "")
		{
			return $passwordMissing;
		}
		else if($username === "")
		{
			return $usernameMissing;
		}
		else
		{
			return $allgood;
		}		
	}
	
	
	public function showLogin($message)	// HTML Innehållet som visas om man inte är inloggad
	{
				//<div id="link"><p><form action="?register" method="post"><input type="submit" name="reg" value = "Register a new user"></form></p></div>
		///<a href='. self::$registerurl .'>Register a new user</a>
		$content = '
		<div id="link"><p><form action="?register" method="post"><input type="submit" name="reg" value = "Register a new user"></form></p></div>
		<h2>Not logged in</h2>
		<form method="post" > 
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . $this->username .'" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					
					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>' ;
		
		return $content; 
	}
	
		//Funktion som kollar om användaren tryckt på registrera
	public function register(){
		if (isset($_POST['reg'])){
			return true;
		} 
		else {
			return false;
		}	
	}
	
	//Funktion som kollar om användaren tryckt på registrera ny användare
	public function registerNewUser(){
		if (isset($_POST['RegisterView::Register'])) {
			return true;
		} 
		else {
			return false;
		}	
	}
	
	
	public function showLoginSuccessful($message)// HTML Innehållet som visas om man inte är inloggad
	{
		
			$content = '
			<h2>Logged in</h2>
			<form  method="post" >
				<p id="' . self::$messageId . '">' . $message .'</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
		
		return $content; 
	}
}
