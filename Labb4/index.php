<?php
//Marco villegas 
// Använde error koden för att fel ikoden skulle visas 
/*error_reporting(E_ALL);
ini_set('display_errors', 'On');*/

//ladar in min classer jag ska använda i min applikation
require_once("controller/LoginController.php");
require_once("view/LayoutView.php");

$control = new \controller\LoginController(); // skapar ett Controller objekt 

$content = $control->doLogin(); // kör min login funktion i Controller klassen

$view = new \view\LayoutView();  // skapar ett HTMLView 

$view->showHTML($content);// kör min showHTML funktion i klassen HTMLView

