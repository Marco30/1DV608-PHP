<?php
//Marco villegas
namespace view;

class DateTimeView {


	public function show() 
	{


        date_default_timezone_set("Europe/Stockholm");// Sätter vilken tidszon vi är i  
		setlocale(LC_TIME, 'swedish');// sätter klockan till svensktid 
		
	
		$time = date('l, \t\h\e jS \o\f F Y, \T\h\e \t\i\m\e \i\s H:i:s');//ger oss datum månad och tid 
		

		return '<p>' . $time . '</p>';
	}
}