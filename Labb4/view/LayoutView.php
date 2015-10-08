<?php
//Marco villegas 
namespace view;

require_once('view/DateTimeView.php');

class LayoutView{

	public function showHTML($content)// Funktion som visar HTML 
	{
		
		if($content === NULL){
			throw new Exception("LayoutView::showHTML does not allow body to be null");
		}
			
	
		$dtv = new \view\DateTimeView();
		
			echo '
		<!DOCTYPE html>
		<html>
			<head>
			<title>Login</title>
			<meta charset ="utf-8" />
			</head>
			<body>
			<h1>Assignment 2</h1>
			' . $content . '
			' . $dtv->show() . '
			</body>
		</html>';
		
	}
}
