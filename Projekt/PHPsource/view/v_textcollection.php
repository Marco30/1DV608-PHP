<?php
namespace view;

class TextcollectionView 
{
	public	static $getLocation = "Textcollection";
	private static $getSpokenWord= "SpokenWord";
	private static $name = 'name';

	
	private $sessionHelper = 'sessionHelper'; 
	
	public function __construct()
	{
		$this->sessionHelper = new \helper\SessionHelper();
	}
	
//Hämtar TextcollectionID från url, return varierar 
	public function getTextcollectionID() 
	{
		if (isset($_GET[self::$getLocation])) 
		{
			return $_GET[self::$getLocation];
		}
		
		return NULL;
	}
	

	///Hämtar SpokenWorID från url
	public function getSpokenWord() 
	{
		if (isset($_GET[self::$getSpokenWord])) 
		{
			return $_GET[self::$getSpokenWord];
		}
		
		return null;
	}
	
//Returnerar namnet som Textcollection har fåt i formulären 
	public function getFormData()
	{
		if (isset($_POST[self::$name])) 
		{
			return ($_POST[self::$name]);
		}
		
		return NULL;
	}
	
	// Hämtar formulär som ska användas när du lägger till ett nytt Textcollection.
	public function getForm() 
	{
		
		$html = "<div id='addInstrument'>";
		$html .= "<h1>Add a Spoken Word Collection</h1>";
		$html .= "<form method='post' action='?action=".NavigationView::$actionAddTextcollection."'>";
		$html .= "<label for='" . self::$name . "'>Name: </label>";
		$html .= "<input type='text' name='" . self::$name . "' placeholder='' value='' maxlength='50'><br />";
		$html .= "<input type='submit' value='Add Collection' id='submit' />";
		$html .= "</form>";
		$html .= "<div class='errorMessage'><p>".$this->sessionHelper->getAlert() ."</p></div>";
		$html .= "</div>";
		
		
		return $html;
	}
	
//Skapar HTML som behövs för att visa en poesicollection med en lista med under kapitel/poesitexter 
	public function show(\model\Textcollection $iTextcollection)
	{

		$SpokenWordArray = $iTextcollection->getSpokenWord()->toArray();
		
		$html = '<h1>' . $iTextcollection->getName() . '</h1>';
		
		//delete button
		$html .= "<a href='?".NavigationView::$action."=".NavigationView::$actionDeleteTextcollection."&amp;".self::$getLocation."=" .
					urlencode($iTextcollection->getTextcollectionID()) ."' class = 'deleteBtn'> Delete Spoken Word Collection</a>";  // TODO- FIX REALLY NEEDS confirm
		
		$html .= "<div id='songList'>";
		
		// add Spoken Word text bouton
		$html .= "<a href='?".NavigationView::$action."=".NavigationView::$actionAddSpokenWord."&amp;".self::$getLocation."=" .
					urlencode($iTextcollection->getTextcollectionID())."'>Add Chapter</a>";
		
		//det här utrymmet är menad för kommentarer, andra användare kan lämna komentarer om just den här samlingen. det är inte färdig utvecklad
		$html .="<br /><br /><h2>Messages</h2>";
		$html.="<p>I like the part that says: You can't climb the mountain of success with your hands in your pockets</p>";
		
		//visar felmedelande text rad
		$html.="<p>" . $this->sessionHelper->getAlert(). "</p>";

		$html .= "</div>";

		return $html;
	}	
	

	 
	 //visar alla Textcollection, i en lista 
	public function showAllTextcollection( \model\TextcollectionList $iTextcollectionList, $iTextcollectionID) 
	{
		
		$checked="";	

		$html = "<h1>My Spoken Word collections</h1>";
		
		$html .= "<div id='showAllInstruments'>";
		
		//fi satsen visar bara lägt Textcollection knappen om det inte finns Textcollection annars körs else och formuläret 
		if (count($iTextcollectionList->toArray()) > 0) 
		{
			$html .= "<a href='?".NavigationView::$action."=".NavigationView::$actionAddTextcollection."' id='addButton'>Add Spoken Word Text</a>";
		}
		if (count($iTextcollectionList->toArray()) == 0) 
		{
			$html .="<div id='addInstrumentIfzero'><p>You have no Spoken Word collection</p>";
			$html .= $this->getForm() . "</div>";
		}
		else 
		{
		
			$html .= "<form method='post' action='?action=".NavigationView::$actionSetMainTextcollection."'>";
			$html .= "<ul id='instrumentlist'>";
			
			foreach ($iTextcollectionList->toArray() as $iTextcollection) 
			{
				$html .= "<li><a href='?action=".NavigationView::$actionShowTextcollection."&amp;".self::$getLocation."=" .
						urlencode($iTextcollection->getTextcollectionID()) ."'><span class='headline'>" .
						$iTextcollection->getName() ."</span>";
						
						
				$html .= "<p><span>Number of Chapter: </span>" . count($iTextcollection->getSpokenWord()->toArray())."</p>";
			

			};
			
			$html .= "</ul></form></div>";
		}
		return $html;
	}
	
}
