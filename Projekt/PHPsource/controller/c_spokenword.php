<?php

namespace controller;


require_once("./PHPsource/view/v_spokenword.php");
require_once('./PHPsource/model/m_spokenwordRepository.php');
require_once('./PHPsource/model/m_textcollectionRepository.php');
require_once('./PHPsource/helper/sessionHelper.php');
require_once('./PHPsource/model/m_validation.php');

class SpokenWordController 
{
	private $sessionHelper;
	private $validation;		
	//model
	private $SpokenWordRepository;
	private $TextcollectionRepository;

	//view
	private $SpokenWordView;
	private $navigationView;
	private $TextcollectionView;


	public function __construct()
	{
		$this->SpokenWordRepository = new \model\SpokenWordRepository();
		$this->TextcollectionRepository = new \model\TextcollectionRepository();
		
		$this->navigationView = new \view\NavigationView();
		$this->SpokenWordView = new \view\SpokenWordView();
		$this->TextcollectionView = new \view\TextcollectionView();
		
		$this->sessionHelper = new \helper\SessionHelper();
		$this->validation = new \model\Validation();
	}

	
	public function showSpokenWord()
	{
		
			$iSpokenWord = $this->SpokenWordRepository->get($this->SpokenWordView->getVSpokenWordID());
			
			$iTextcollectionID = $this->sessionHelper->getHTextcollectionID();
			
			if (empty($iTextcollectionID)) 
            {
				$iTextcollectionID = $this->TextcollectionView->getTextcollectionID(); 
				
				//save instrumentID in session
				$this->sessionHelper->setHTextcollectionID($iTextcollectionID);
			}

			$iTextcollectionID = $this->sessionHelper->getHTextcollectionID();
			$iTextcollection = $this->TextcollectionRepository->get($iTextcollectionID);
			
			return $this->SpokenWordView->show($iSpokenWord, $iTextcollection); 
	}	
	

	public function addSpokenWord() // Controller funktion för att lägga till spoken word
	{
		
		$iTextcollectionID = $this->sessionHelper->getHTextcollectionID();
		if (empty($iTextcollectionID))
		{
			$iTextcollectionID = $this->TextcollectionView->getTextcollectionID();  
		}
		
		if (strtolower($_SERVER['REQUEST_METHOD']) == 'post') 
		{
			
			
			if($this->validation->validateName($this->SpokenWordView->getName())) //Bara läger spoken word om validering är sant
			{
				$iSpokenWord = $this->SpokenWordView->getSpokenWordV();
				$iTextcollectionID =	$this->SpokenWordView->getOwner();
				$iSpokenWord->setOwner($this->TextcollectionRepository->get($iTextcollectionID));
				
				$iSpokenWordID = $this->SpokenWordRepository->add($iSpokenWord);
			
				if($iSpokenWordID != null) {
					\view\NavigationView::RedirectToSpokenWord($iSpokenWordID);
				}
			}
		}
		return $this->SpokenWordView->getForm($this->TextcollectionRepository->get($iTextcollectionID));
	
	}  
	
	

	public function saveNotes()// sparar den spoken word texten
	{
			
			
			$notes = $this->SpokenWordView->getNotes();// hämta data från formulär textarea
		
			$iSpokenwordID = $this->SpokenWordView->getVSpokenWordID();	// hämtar SpokenWordID 
			
			$this->SpokenWordRepository->saveNotes($notes, $iSpokenwordID);// sparar till DB
			
			return $this->showSpokenWord();
	}	
	
	public function deleteSpokenWord() // tar bort spoken word från DB
	{
		
			$iTextcollectionID = $this->sessionHelper->getHTextcollectionID();
			$iSpokenWordID =$this->TextcollectionView->getSpokenWord();
			
			if (true)
			{  
				$this->SpokenWordRepository->delete($iSpokenWordID, $iTextcollectionID);
				
				$this->sessionHelper->setAlert("Song was successfully deleted"); 

				\view\NavigationView::RedirectToTextcollection($iTextcollectionID);
				
		  	 }
		  	 else
		  	 {
		    	\view\NavigationView::RedirectToSpokenWord($iSpokenWordID);
		   }
	}
}
