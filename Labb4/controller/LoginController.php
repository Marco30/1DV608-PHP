<?php

namespace controller;

//Marco villegas 
//ladar in min classer jag ska använda
require_once("view/LoginView.php");
require_once("model/LoginModel.php");

require_once("view/MessageView.php");
require_once("model/User.php");
require_once("model/UserRepository.php");
require_once("view/RegisterView.php");

class LoginController
{
	private $view; 
	private $model; 
	
	private $registerView; 
	private $user;
	private $userRepository;
	private $messageView;
	
	public function __construct()// konsturktor som skapar mina två objekt jag ska använda
	{
		$this->view = new \view\LoginView();
		$this->model = new \model\LoginModel(); 	
		
			$this->registerView = new \view\RegisterView();
		$this->messageView = new \view\MessageView();
		$this->user = new \model\User();
		$this->userRepository = new \model\UserRepository();
	}
	
		// sköter registreringen av nu användare. 
	public function registration(){
	
	     
		$name = $this->registerView->getName(); 
		$password1 = $this->registerView->getPassword1();
		$password2 = $this->registerView->getPassword2();
				
				//Meddelanden
		$errorName = $this->messageView->errorNameMessage();
		$errorPassword = $this->messageView->errorPasswordMessage();
		$errorNoMatchPassword = $this->messageView->errorNoMatchPasswordMessage();
		$errorUsernameExist = $this->messageView->errorUserAlreadyExistMessage(); 
		$errorTagInUsername = $this->messageView->errorTagInUsernameMessage(); 
		$newUserCreated = $this->messageView->newUserCreatedMessage();
		
		// validering av användarnamn och lösenord.  
		if($this->user->name($name) === true && $this->user->password($password1) === true)
		{ 
		    
			if(!$this->user->checkIfPasswordMatch($password2))
			{ // kollar om lösenorden matchar varandra. 
				return $this->registerView->doRegisterView("",$errorNoMatchPassword, $name);
				
			}
			else
			{
			    
			    if($this->userRepository->checkIfExist($this->user))// kollar om användarnamn inte finns ledigt. 
			    { 
					return $this->registerView->doRegisterView($errorUsernameExist,"",$name);
				}
							
				if($this->user->tagInName())// kollar efter tags i användarnamnet, tar bort eventuella tags som finns. 
				{ 
					return $this->registerView->doRegisterView($errorTagInUsername,"",$this->user->getUserName());
				}
							
				$this->userRepository->create($this->user); // användarens uppgifter är godkända, lägger till användare i databasen.
				$this->view->SetUsername($this->user->getUserName());
				return $this->view->showLogin($newUserCreated);
		    }
		    
		}
		else
		{
		    
			if($this->user->name($name) === true && $this->user->password($password1) === false)
			{ // lösenordet går inte igenom valideringen.
				return $this->registerView->doRegisterView("",$errorPassword, $name);
			}
				
			if($this->user->name($name) === false && $this->user->password($password1) === true)
			{ // användarnamnet går inte igenom valideringen.
				return $this->registerView->doRegisterView($errorName,"",$name);
			}
			
			return $this->registerView->doRegisterView($errorName,$errorPassword,$name); // varken användarnamnet eller lösenordet går igenom valideringen.
		}
	}
	
	
	public function doLogin()// min loggin funktion 
	{
			//Meddelande skickas med till LoginView för utskrift
			$loggedIn = $this->messageView->loggedInMessage();
			
		$usernameMissing = $this->messageView->usernameMissingMessage();
		$passwordMissing = $this->messageView->passwordMissingMessage();
		$wrongInput = $this->messageView->wrongInputMessage();
		$loggout = $this->messageView->loggoutMessage();
$allgood = $this->messageView->allgoodMessage();
		
			// Om man klickat på Registrera ny användare i Login.	
		if($this->view->register()){
			return $this->registerView->doRegisterView("","","");
		}
			
		// Om man väljer registrera i registreringsformuläret. 
		if($this->view->registerNewUser()){
				return $this->registration();
		}
		
		$this->model->sessionStart();//startar en session 


					
			if($this->model->checkIfLoggedIn())//Kontrollerar om man är inloggad eller inte  
			{
				
				if($this->view->pressedLogout())//Kontrollerar om man tryckt på logga ut 
				{
					$this->model->sessionDestroy();//Tar bort session
					return $this->view->showLogin($loggout);//visar login formulären  
				}
				else
				{
				return $this->view->showLoginSuccessful("");//visar att man är inlogad  
				}
			}
	 		else// Om användaren väljer att logga in, Kontrollerar input i formuläret, och väljer efter resultatet vilket innehåll som skall returneras till HTMLView
	 		{ 
			
				if($this->view->pressedLogin())// Kontrollerar om man tryckt på login knapen 
				{
					$message = $this->view->controllInput();//Kontrollerar om man fyllt i båda rutorna i formulären, lösenord och användarenamn  
					//var_dump($message);
					if($message === $allgood)
					{
		
						if($this->model->checkUserExists($this->view->getUsernameInput(),$this->view->getPasswordInput()))// Kontrollerar om man mattat in rätt lösenord och användare namn  
						{
							
						return $this->view->showLoginSuccessful($loggedIn);//Visar att man är inloggad
						
							
						}
						else// Else satsen körs om man mattat in fell lösenord och användar namn    
						{
							return $this->view->showLogin($wrongInput); 
						}
								
					}
					else
					{
						//var_dump($message);
						return $this->view->showLogin($message);// visar bara fel och login formulären 	
					}
				
				}
				else// Ej valt att logga in. 
				{ 
					return $this->view->showLogin("");
				}    
			} 	

	}
}

