<?php
namespace view;

/**
 * Class containing static methods and functions for navigation.
 */
class NavigationView 
{
	public static $id = 'id';
	public static $actionDefault = 'default';
	public static $action = "action"; 
	
	public static $actionSignUp = 'signUp';
	public static $actionSignIn = 'signIn';
	
	//Textcollection
	public static $actionAddTextcollection = 'add';
	public static $actionShowTextcollection = 'show';
	public static $actionDeleteTextcollection = 'deleteTextcollection';
	public static $actionShowAll = 'showAll';
	public static $actionSetMainTextcollection = 'mainTextcollection';
	
	//SpokenWord
	public static $actionAddSpokenWord = 'addSpokenWord';
	public static $actionShowSpokenWord = 'showSpokenWord';
	public static $actionDeleteSpokenWord = 'deleteSpokenWord';
	public static $actionSaveNotes = 'saveNotes';

	
	private $SpokenWordMenu = "";
	

  
	public function getBaseMenuStart() // visar menyn när man inte är in logad
	{
		$html = "<div id='menu'>
					<ul>"; 	
		$html .= "<li><a href='?".SignIn::$getAction."=".SignIn::$actionSignIn."'>Sign in</a></li>";  
		$html .= "<li><a href='?".self::$action."=".self::$actionSignUp."'>Sign up</a></li>"; 
		$html .= "</ul></div>";
		return $html;
	}	
	
	

// visar menyn när man är inlogad
	public function showMenuLoggedIn($username, $showSpokenWordList = true)
	{
		$html = "<div id='menu'>
					<ul>";
		$html .= self::showBaseMenu($username);
		if($showSpokenWordList)
			$html .= $this->SpokenWordMenu;
		$html .= "</ul></div>";
		return $html;
	}
	
	
	public static function showBaseMenu($username)
	{
		$html  = "<li class ='username'>" . ucfirst($username) ."</li>"; 
		$html .= "<li><a href='?".self::$action."=".self::$actionShowAll."'>My Spoken Word Collections</a></li>";  
		$html .= "<li><a href='?".self::$action."=".self::$actionAddTextcollection."'>Add Spoken Word Collection</a></li>";
		$html .= "<li><a href='?".self::$action."=".SignIn::$actionSignOut."'>Sign out</a></li>";
		return $html;
	}
	
	// visar Textcollection menyn med under rubriker 
	public function showSpokenWordMenu(\model\Textcollection $iTextcollection) 
	{
		$SpokenWordArray = $iTextcollection->getSpokenWord()->toArray();
		$view = new \view\NavigationView();

		$menu = $view->getTextcollectionButton($iTextcollection);
		
		if (empty($SpokenWordArray)) {
			$menu .= "<li id='noInstruments'>You have no Chapter <br /> in this Collections</li>";
		}
		
		// läg till spoken word knap 
			$menu .= "<li><a href='?".self::$action."=".self::$actionAddSpokenWord."&amp;".TextcollectionView::$getLocation."=" .
					urlencode($iTextcollection->getTextcollectionID())."'>Add Chapter</a></li>";
					
		$menu .= "<li><ul id='songMenu'>";
		foreach($SpokenWordArray as $iSpokenWord) {
			$menu .= "<li><a href='?".NavigationView::$action."=".NavigationView::$actionShowSpokenWord;
			$menu .= "&amp;".TextcollectionView::$getLocation."=" .
					urlencode($iTextcollection->getTextcollectionID());
			$menu .= "&amp;".SpokenWordView::$getLocation."=" .
					urlencode($iSpokenWord->getSpokenWordID()) ."'>".$iSpokenWord->getName()."</a></li>";
		}
			
		$menu .= "</ul></li>";	
		
		$this->SpokenWordMenu = $menu;
	}	
	
	

	public static function getLogo()	//visar sid logo som länkar till index
	{
		$html = "<div id='logo'>";
		$html .= "<a href='./". "'><img src='images/logo.png' alt='logo' />  
		</a>";  
		return $html;
	}
	
	
	public static function getAction() 
	{
		if (isset($_GET[self::$action]))
			return $_GET[self::$action];
		
		return self::$actionDefault;   
	}
	
	public static function getId() 
	{   
		if (isset($_GET[self::$id])) {
			return $_GET[self::$id];
		}
		
		return NULL;
	}
	

	public static function getTextcollectionButton($iTextcollection) 
	{
		$button ="<li><a href='?action=".NavigationView::$actionShowTextcollection."&amp;".TextcollectionView::$getLocation."=" .
					urlencode($iTextcollection->getTextcollectionID()) ."' id='instrumentBtn'>" .
					$iTextcollection->getName()."</a></li>";
		return $button;
	}
	
	public static function getTextcollectionBreadCrum($iTextcollection) {
		$button ="<a href='?action=".NavigationView::$actionShowTextcollection."&amp;".TextcollectionView::$getLocation."=" .
					urlencode($iTextcollection->getTextcollectionID()) ."' id='instrumentBreadcrum'>" .
					$iTextcollection->getName()."</a>";
		return $button;	
	}
	

	public static function RedirectHome() // Omdirigerar hem
	{
		header('Location: /' . \Settings::$ROOT_PATH. '');
	}

	
	public static function RedirectToErrorPage() // Omdirigerar till error sidan finns int just, ska fixa
	{
		header('Location: /' . \Settings::$ROOT_PATH. '/error.html');
	}
	

	public static function RedirectToSignUp() // Omdirigerar till logan in efter man registrerat sig  
	{
		header('Location: /' . \Settings::$ROOT_PATH. '?'.self::$action.'='.self::$actionSignIn);
	}
	

	public static function RedirectToTextcollection($iTextcollectionID) // Omdirigerar till word collection man valt
	{
		header('Location: /' . \Settings::$ROOT_PATH . '?'.self::$action.'='.self::$actionShowTextcollection.'&'. TextcollectionView::$getLocation. '='.$iTextcollectionID);
	}
	

	public static function RedirectToSpokenWord($iSpokenWordID) // Omdirigerar till spoken word text man valt  
	{
		header('Location: /' . \Settings::$ROOT_PATH . '?'.self::$action.'='.self::$actionShowSpokenWord.'&'. SpokenWordView::$getLocation. '='.$iSpokenWordID);
	}  
	
	
	public static function RedirectToAddSpokenWord() // Omdirigerar lägt till SW 
	{
		header('Location: /' . \Settings::$ROOT_PATH . '?'.self::$action.'='.self::$actionAddSpokenWord);
	} 

	
	public static function RedirectToAddTextcollection() // Omdirigerar till lägt till collection
	{
		header('Location: /' . \Settings::$ROOT_PATH . '?'.self::$action.'='.self::$actionAddTextcollection);
	} 
	

	public static function RedirectToShowAllTextcollection() // Omdirigerar till sidan som vissar alla collections
	{
		header('Location: /' . \Settings::$ROOT_PATH . '?'.self::$action.'='.self::$actionShowAll);
	} 
	
}
