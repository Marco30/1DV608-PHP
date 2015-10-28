<?php
  namespace controller;

  require_once("PHPsource/model/m_userRepository.php");
  require_once("PHPsource/model/m_user.php");
  require_once("PHPsource/view/v_signUp.php");
  require_once("PHPsource/helper/sessionHelper.php");

  class SignUp
  {
    private $model;
    private $view;
	private $sessionHelper;

    public function __construct()
    {
      $this->model = new \model\UserRepository();
      $this->view = new \view\SignUp($this->model);
	  $this->sessionHelper = new \helper\SessionHelper(); 
    }

    public function viewPage()
    {
    		if($this->view->SignUpAttempt()) 
    		{  
    			if ($this->addUser()) //true om användaren har lagt till
    			{ 
    				\view\NavigationView::RedirectToSignUp();
    			}
			}
      		return $this->view->showSignUp();
	}
	
	public function addUser() 
	{   

		try {
			$username  = $this->view->getUsernameInput(); 
			$password  = $this->view->getPasswordInput();
			$errorMessage = $this->view->validateInput();
			
			
			if (!empty($errorMessage))
			{
				$this->sessionHelper->setAlert($errorMessage);
				throw new \Exception();
			}
			
		
			if ($this->model->usernameAlreadyExists($username))// kontrollera i användaren redan finns i databasen
			{
				$this->sessionHelper->setAlert("The username is already taken.");
				throw new \Exception();
			}
			
			$pw = new \model\Password($password);
			$user = new \model\User(uniqid(), $username, $pw);	
			$this->model->add($user);	
			
			return true;

		}
		catch(\Exception $e)
		{
			return false;
		}
		
	} 
  } 
