<?php
namespace controller;

require_once('./PHPsource/view/v_navigation.php');
require_once('./PHPsource/view/v_htmlBody.php');
require_once('./PHPsource/controller/c_textcollection.php');
require_once('./PHPsource/controller/c_spokenword.php');
require_once('./PHPsource/controller/c_signIn.php');
require_once('./PHPsource/controller/c_signUp.php');
require_once('Settings.php');


class Navigation
{
		
	private $htmlBody;
	

	public function doControll() 
	{
		$this->htmlBody = new \view\HTMLBody();	
		$view = new \view\NavigationView(); 
		$TextcollectionController= new TextcollectionController();
		
		$controller;

		try 
		{
			
			$controller = new SignIn();
			
			// Kontroll logga in status och skapa hemsida om användaren inte har loggat in	
		
				$this->htmlBody->setBody($controller->viewPage());
				$this->htmlBody->setMenu($view->getBaseMenuStart()); 

			
		
			if ($view->getAction() == $view::$actionSignUp) // Kontrollerar om användaren vill att registrera sig
			{
				$signUpController = new SignUp();
				$this->htmlBody->setBody($signUpController->viewPage());
				$this->htmlBody->setMenu($view->getBaseMenuStart()); 
			}
					
			if ($controller->userIsSignedIn() == false)
				return $this->htmlBody; 
			

		

			switch ($view::getAction()) //kör switch när användaren är inloggad
			{
						
				# visar all Textcollection	
				case $view::$actionShowAll:
					$controller = new TextcollectionController();
					$this->htmlBody->setBody($controller->showAllTextcollection());
					$this->htmlBody->setMenu($controller->showSpokenWordMenu());
					return $this->htmlBody;
					break;	
					
				# läga till Textcollection 
				case $view::$actionAddTextcollection:
					$controller = new TextcollectionController();
					$this->htmlBody->setBody($controller->addTextcollection());
					$this->htmlBody->setMenu($controller->showSpokenWordMenu());
					return $this->htmlBody;
					break;
				
				# visa Textcollection
				case $view::$actionShowTextcollection:
					$controller = new TextcollectionController();
					$this->htmlBody->setBody($controller->show());
					$this->htmlBody->setMenu($controller->showSpokenWordMenu());
					return $this->htmlBody;
					break;
					
				# ta bort Textcollection
				case $view::$actionDeleteTextcollection:
					$controller = new TextcollectionController();
					$this->htmlBody->setBody($controller->deleteTextcollection());
					$this->htmlBody->setMenu($controller->showSpokenWordMenu());
					return $this->htmlBody;
				
				# läg till SpokenWord
				case $view::$actionAddSpokenWord:
					$controller = new SpokenWordController();
					$this->htmlBody->setBody($controller->addSpokenWord());
					$this->htmlBody->setMenu($TextcollectionController->showSpokenWordMenu());
					return $this->htmlBody;
				
				# visa SpokenWord	
				case $view::$actionShowSpokenWord:
					$controller = new SpokenWordController();
					$this->htmlBody->setBody($controller->showSpokenWord());
					$this->htmlBody->setMenu($TextcollectionController->showSpokenWordMenu());
					return $this->htmlBody;
					
				# läg till SpokenWord text 
				case $view::$actionSaveNotes:
					$controller = new SpokenWordController();
					$this->htmlBody->setBody($controller->saveNotes());
					$this->htmlBody->setMenu($TextcollectionController->showSpokenWordMenu());
					return $this->htmlBody;
				
				# ta bort SpokenWord		
				case $view::$actionDeleteSpokenWord:
					$controller = new SpokenWordController();
					$this->htmlBody->setBody($controller->deleteSpokenWord());
					$this->htmlBody->setMenu($TextcollectionController->showSpokenWordMenu());
					return $this->htmlBody;
				
				# hem sidan för i loga användare
				default :   
					$controller = new TextcollectionController();
					$this->htmlBody->setBody($controller->showAllTextcollection());
					$this->htmlBody->setMenu($controller->showSpokenWordMenu());
					return $this->htmlBody;
					break;
			}
		} 
		catch (\Exception $e)
		{

			error_log($e->getMessage() . "\n", 3, \Settings::$ERROR_LOG);
			if (\Settings::$DO_DEBUG) 
			{
				throw $e;
			} else 
			{
				\view\NavigationView::RedirectToErrorPage();
				die();
			}
		}
	}
}
