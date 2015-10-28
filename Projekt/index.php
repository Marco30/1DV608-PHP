<?php

// Använde error koden för att fel ikoden skulle visas 
/*error_reporting(E_ALL);
ini_set('display_errors', 'On');*/

//ladar in min classer jag ska använda i min applikation
 
require_once("PHPsource/view/HTMLView.php");
require_once("PHPsource/controller/c_navigation.php");
require_once("PHPsource/view/v_navigation.php");
require_once("PHPsource/controller/c_signIn.php");
require_once("PHPsource/controller/c_signUp.php");
 
session_start();

//Views
$view = new \view\HTMLView();
$nagivationView = new \view\NavigationView();

//Controllers
$navigation = new \controller\Navigation();
$signUpController = new \controller\signUp();


$htmlBody = $navigation->doControll(); 

$view->echoHTML("Music Logbook - Home", $htmlBody->getBody(), $htmlBody->getMenu(), $htmlBody->getScript());

