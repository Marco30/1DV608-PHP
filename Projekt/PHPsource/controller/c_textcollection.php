<?php

namespace controller;


require_once("./PHPsource/view/v_textcollection.php");
require_once("./PHPsource/view/v_spokenword.php");
require_once("./PHPsource/model/m_textcollectionList.php");
require_once('./PHPsource/model/m_textcollectionRepository.php');
require_once('./PHPsource/helper/sessionHelper.php');
require_once('./PHPsource/model/m_validation.php');

class TextcollectionController
{
	private $sessionHelper;
	private $validation;		
	//model
	private $TextcollectionRepository;
	//view
	private $TextcollectionView;
	private $navigationView;


	public function __construct() 
	{
		$this->TextcollectionView = new \view\TextcollectionView();
		$this->navigationView = new \view\NavigationView();
		$this->TextcollectionRepository = new \model\TextcollectionRepository();
		$this->sessionHelper = new \helper\SessionHelper();
		$this->validation = new \model\Validation();
	}


	public function show() 
	{
		
		$iTextcollectionID = $this->TextcollectionView->getTextcollectionID(); 
		
		//save instrumentID in session
		$this->sessionHelper->setHTextcollectionID($iTextcollectionID);
		
		$iTextcollectionID = $this->sessionHelper->getHTextcollectionID($iTextcollectionID);
		
		$owner = $this->TextcollectionRepository->get($iTextcollectionID);   
	  
		return $this->TextcollectionView->show($owner);
	}

	public function showSpokenWordMenu () 
	{
			
			
			$iTextcollectionID = $this->sessionHelper->getHTextcollectionID();
			
			$sessionUsername = $this->sessionHelper->getUsername();
			
			
			if ($iTextcollectionID == 0)
			{
				return $this->navigationView->showMenuLoggedIn($sessionUsername, $showSongList = false); 
			}
			
			$owner = $this->TextcollectionRepository->get($iTextcollectionID);
				
			$this->navigationView->showSpokenWordMenu($owner);
			
			return $this->navigationView->showMenuLoggedIn($sessionUsername); 
	}
	
	

	public function showAllTextcollection()
	{
		$username = $this->sessionHelper->getUsername();
		$mainTextcollectionID = $this->TextcollectionRepository->getMainTextcollection($this->sessionHelper->getUsername());
		
		return $this->TextcollectionView->showAllTextcollection($this->TextcollectionRepository->toList($username), $mainTextcollectionID);
	}
	
	

	public function addTextcollection() 
	{
		if (strtolower($_SERVER['REQUEST_METHOD']) == 'post') 
		{
			$name = $this->TextcollectionView->getFormData();    // får namnet input från formuläret
			
			
			
			if($this->validation->validateName($name))//Bara läger collection om validering är sant
			{
								
				//läger till  collection till DB 
				$iTextcollectionID = $this->TextcollectionRepository->add($this->sessionHelper->getName(), $this->sessionHelper->getUsername());
				
				if($iTextcollectionID == null) 
				{
				\view\NavigationView::RedirectToAddTextcollection();
					
				}
				else 
				{
				\view\NavigationView::RedirectToTextcollection($iTextcollectionID);
				}
				
				
			}
			else
			{
				return $this->TextcollectionView->getForm();
			}	
			
		} 
		else 
		{
			return $this->TextcollectionView->getForm();
		}
	}
	

	
	public function deleteTextcollection()
	{
		
			$iTextcollectionID = $this->sessionHelper->getHTextcollectionID();
			$iTextcollection = $this->TextcollectionRepository->get($iTextcollectionID);
			
			if (true)// ska fröska göra hinna göra en bekräftelse funktion inan if satsen
			{   

			
				$this->TextcollectionRepository->delete($iTextcollection , $this->sessionHelper->getUsername());// bort collection från databasen
				
				\view\NavigationView::RedirectHome();
				
		  	 }else 
		  	 {
		   		 \view\NavigationView::RedirectToTextcollection($iTextcollectionID);
		   }		
	}

}
