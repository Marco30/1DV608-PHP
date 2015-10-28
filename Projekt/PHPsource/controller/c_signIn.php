<?php
  namespace controller;

  require_once("PHPsource/model/m_signIn.php");
  require_once("PHPsource/view/v_signIn.php");
  require_once("PHPsource/helper/sessionHelper.php");
   require_once("PHPsource/view/v_navigation.php");

  class SignIn 
  {
    private $model;
    private $view;
    private $sessionHelper;
	private static $username = "SignIn::Username"; 
	private $signedInStatus;

    public function __construct() 
    {
      $this->model = new \model\SignIn();
      $this->view = new \view\SignIn($this->model);
      $this->sessionHelper = new \helper\SessionHelper();
    }

    public function viewPage()
    {   
    	

      if ($this->model->userIsSignedIn() || $this->view->checkCookies()) // Kontrollera om användaren har loggat in med sessionen eller med cookies
      {
			
	       
	        if ($this->view->SignOutAttempt()) //Kontrollera om användaren tryckte logga ut
	        {
	        	         
			  
	          if ($this->model->signOut() || $this->view->signOut())
	          {
	          	$this->view->destroyCookies();
	            $this->signedInStatus = false;
	       		$this->sessionHelper->setAlert("You have signed out successfully."); 
			  return $this->view->showHomepage();
	          }
        }
		if($this->view->checkCookies())
		{  
				$this->sessionHelper->setUsername($this->view->getUsernameCookie());
			}

      
      $this->signedInStatus = true;//Användaren är inloggad och har inte tryck logga ut
	  } 
      
      else 
      {	 
	  		$this->signedInStatus = false;    

		    
	  		if (strtolower($_SERVER['REQUEST_METHOD']) == 'post') // Om användaren försökte logga in
	  		{
	       
		         $userDetails = $this->view->getFormData();    // Får namnet input från formuläret
		        
		          
		        if ($this->model->signIn($userDetails[0], $userDetails[1], $userDetails[2]))
		        {
						
					
					$this->view->setCookies($this->view->rememberUser());
					$this->sessionHelper->setUsername($userDetails[0]);
					$this->signedInStatus = true;
					
				
					return $this->view->showHomepage();
				 }
	
				else 
				{
					return $this->view->showSignIn();
				}
		    }
			else if ($this->view->hasUserChosenSignInpage()) {

					return $this->view->showSignIn();
				}
		}	
   
	return $this->view->showHomepage();
	}

	public function userIsSignedIn() 
	{
		if ($this->signedInStatus)
			return true;		
		
		return false;
	}
 }