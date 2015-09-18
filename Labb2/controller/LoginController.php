<?php
//Marco villegas 
//ladar in min classer jag ska använda
require_once("view/LoginView.php");
require_once("model/LoginModel.php");

class LoginController
{
	private $view; 
	private $model; 
	
	public function __construct()// konsturktor som skapar mina två objekt jag ska använda
	{
		$this->view = new LoginView();
		$this->model = new LoginModel(); 	
	}
	
	
	public function doLogin()// min loggin funktion 
	{
		
		$this->model->sessionStart();//startar en session 


					
			if($this->model->checkIfLoggedIn())//Kontrollerar om man är inloggad eller inte  
			{
				
				if($this->view->pressedLogout())//Kontrollerar om man tryckt på logga ut 
				{
					$this->model->sessionDestroy();//Tar bort session
					return $this->view->showLogin("Bye bye!");//visar login formulären  
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
					if($message === "Usernames and passwords are entered")
					{
		
						if($this->model->checkUserExists($this->view->getUsernameInput(),$this->view->getPasswordInput()))// Kontrollerar om man mattat in rätt lösenord och användare namn  
						{
							
						return $this->view->showLoginSuccessful("Welcome");//Visar att man är inloggad
						
							
						}
						else// Else satsen körs om man mattat in fell lösenord och användar namn    
						{
							return $this->view->showLogin("Wrong name or password"); 
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

