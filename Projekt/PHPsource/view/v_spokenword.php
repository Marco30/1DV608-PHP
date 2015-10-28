<?php
namespace view;

require_once('./PHPsource/model/m_spokenword.php');

class SpokenWordView
{
	public static $getLocation = 'SpokenWord';
	
	private static $name = 'name';
	private static $TextcollectionID = 'TextcollectionID';
	private static $textarea = 'textarea';
	
	private $sessionHelper;
	
	function __construct() 
	{
		$this->sessionHelper = new \helper\SessionHelper();
	}
	

	 // fyller SpokenWord modelen med info från view
	public function getSpokenWordV()
	{
		if($this->getName() != NULL) 
		{
			$SpokenWordName = $this->getName();
			return new \model\SpokenWord($SpokenWordName);
		}
	}
	

	 // hämtar texten man skrivit 
	public function getNotes() 
	{
		
		if(isset($_POST[self::$textarea]))
		{
			return $_POST[self::$textarea];
		}
		
		return "";
	}
	
	// hämntat SpokenWordID
	public function getVSpokenWordID() 
	{
		if (isset($_GET[self::$getLocation])) 
		{  
			return $_GET[self::$getLocation];
		}
		
		return NULL;
	}
	

	 // skapar HTML formulär för att lägga till text i collection
	public function getForm(\model\Textcollection $owner) 
	{
		$iTextcollectionID = $owner->getTextcollectionID();
		$html = "<div id='addSong'>";
		$html .= "<h1>Add Spoken Word to ". $owner->getName()."</h1>";
		$html .= "<form action='?action=".NavigationView::$actionAddSpokenWord."' method='post'>";
		$html .= "<input type='hidden' name='".self::$TextcollectionID."' value='$iTextcollectionID' />";
		$html .= "<label for='" . self::$name . "'>Name: </label>";
		$html .= "<input type='text' name='".self::$name."' />";
		$html .= "<input type='submit' value='Add Chapter' id='submit'/>";
		$html .= "<div class='errorMessage'><p>". $this->sessionHelper->getAlert()."</p></div>";
		$html .= "</form>";
		$html .= "</div>";
		return $html;
	}
	
//hämtar ut namnet från formulär här ovan
	public function getName() 
    {
		if (isset($_POST[self::$name])) 
        {
			return $_POST[self::$name];
		}
		return null;
	}
	

	 // hämtar den unika id som användare har för att kunna lägga till en ny text i collection
	public function getOwner() 
	{
		if (isset($_POST[self::$TextcollectionID])) 
		{
			return $_POST[self::$TextcollectionID];
		}
		return NULL;
	}

	 // Skapar HTMLen behövs för att visa en text i collection med alla detaljer
	public function show(\model\SpokenWord $iSpokenWord, \model\Textcollection $iTextcollection) 
	{
			
		$view = new \view\NavigationView(); 
		
		//ta bort knap
		$html = "<a href='?".NavigationView::$action."=".NavigationView::$actionDeleteSpokenWord."&amp;".self::$getLocation."=" .
					urlencode($iSpokenWord->getSpokenWordID()) ."' class='deleteBtnSong '> Delete Spoken Word Chapter </a>";
		$html .= "<div id='songOverview'>";
		$html .=  $view->getTextcollectionBreadCrum($iTextcollection);
		$html .= '<h1>' . $iSpokenWord->getName() . '</h1>';
		
		
		$html .="<h3>Spoken Word Text</h3>";
		// formulär där man skriver sin Spokenword text
		$html .= "<form action='?".NavigationView::$action."=".NavigationView::$actionSaveNotes."&amp;".self::$getLocation."=" . 
					urlencode($iSpokenWord->getSpokenWordID()) ."' method='post'>";
		$html .= '<input type="submit" name="submitNotes" value="Save notes" id="saveNotes" class="submit" />';			
		$html .= '<textarea name="'.self::$textarea.'" id="notes" spellcheck="false" maxlength="1000">' 
		. htmlspecialchars($iSpokenWord->getNotes()). '</textarea>';
		
		$html .= "<div class='errorMessage'><p>". $this->sessionHelper->getAlert() ."</p></div>";
		$html .= "</form>";				
		$html .= '</div>';
		
		return $html;
	}	
}

