<?php

//Marco villegas 
//lyckades koppla upp mig till min lokala databas men inte till min host databas på nätet, improviserad med text fil som databas

namespace model;


class UserRepository {
	
	private static $userID = "userID"; 
	private static $password = "password";
	private static $name = "name";
	private $table = "Login";
	

	public function create(User $user) 	// lägger till användaren i text filen som agerar databas 
	{
		
		$file = ('model/DB.txt');
// öpaner text filen för att få data
$fh = fopen($file, 'a+') or die("can't open file");
$string = $user->getUserName() . "\r\n" . $user->getPassword() . "\r\n";
fwrite($fh, $string);
fclose($fh);

	
	}
	

	public function checkIfExist(User $user)	// Kollar om användarnamet redan finns i text filen som agerar databas, vid registrering
	{
		
		  $lines = file("model/DB.txt");
            
            // blir true när text raden hittas 
            $found = false;
            
            foreach($lines as $line)
            {
        
              if(strpos($line, $user->getUserName()) !== false)
              {
                $found = true;
                //echo $line;
                return true;
              }
              
            }
            // om den inte finns körs den här if satsen
            if(!$found)
            {
              //echo 'No match found';
              return false;
            }
	 
	    
	}

   
	public function checkBeforeLogin($name, $password) // Kollar så att användarnamn och lösenord stämmer med informationen i text filen som agerar databas
	{
		
		
		 $lines = file("model/DB.txt");
            
            // blir true när testen hittas
            $found = false;
           // var_dump($name);
            
            foreach($lines as $line)
            {
        
              if(strpos($line, $name) !== false)
              {
                $found = true;
                //echo $line;
              }
              
            }
            
            if(!$found)// använd för test om text namn inte hittas 
            {
              //echo 'No name match found';
            }
         
           // $lines = file("DB.txt");
            
            // Store true when the text is found
            $found2 = false;
            
            foreach($lines as $line)
            {
        
             // if(strpos($line, md5($password)) !== false)
             if(strpos($line, $password) !== false)
              {
                $found2 = true;
                //echo $line;
              }
              
            }

            if(!$found2)// användes för test om text inte hittas 
            {
              //echo 'No password match found';
            }
            
            
            if($found2 === true && $found === true)// om användarnamn och lösenord finns körs if satsen
            {
            return true;	
            }
            else
            {
            	return false;
            }
		
	}

}
