<?php
  namespace view;

  class HTMLView {

   
		public function echoHTML($title, $body, $htmlMenu, $script) 
		{
			if ($body === NULL)
			{
				throw new \Exception("HTMLView::echoHTML does not allow body to be null");
			}

			$head  = '<link rel="stylesheet" type="text/css" href="css/main.css">';

			$html = "
				<!DOCTYPE html>
				<html>
				<head>
				<meta charset=\"utf-8\">
				<title>".$title."</title>
			 $head;
				</head>
				<body>";
			$html .= "<div id='page'> ";
			$html .= "<div id='fluid'>
						<div id='column-right'> ";
			$html .= $body;
			$html .= "	</div>
					</div>";
			
			$html .="<div id='fixed-width'> 
				<div id='column-left'>";
			$html .= NavigationView::getLogo();
			$html .= $htmlMenu;
			$html .= "</div>"; 
			$html .= "</div>"; 
			
			$html .= "</div></div>"; 
			$html .= $script;
			$html .= "</body>
				</html>";
				
			echo $html;
		}
}
