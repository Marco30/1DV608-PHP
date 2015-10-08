<?php

//Marco villegas 

namespace view;

class MessageView//class som sk a underlätta ändring av meddelanden innehåll
{
	// meddelanden till Registrerings Formulären 
	public function errorNameMessage()
	{
		return "Username has too few characters, at least 3 characters";
	}
	
	public function errorPasswordMessage()
	{
		return "Password has too few characters, at least 6 characters";
	}
	
	public function errorNoMatchPasswordMessage()
	{
		return "Passwords do not match";
	}
	
	public function errorUserAlreadyExistMessage()
	{
		return "User exists, pick another username";
	}
	
	public function errorTagInUsernameMessage()
	{
		return "Username contains invalid characters"; 
	}
	
	public function newUserCreatedMessage(){
		return "Registered new user"; 
	}
	
   // meddelanden till login Formulären 
	
	public function loggedInMessage()
	{
		return "Welcome";
	}
	
	public function usernameMissingMessage()
	{
		return "Username is missing";
	}
	
	public function passwordMissingMessage()
	{
		return "Password is missing";
	}
	
	public function wrongInputMessage()
	{
		return "Wrong name or password";
	}
		public function loggoutMessage()
	{
		return "Bye bye!";
	}
		public function allgoodMessage()
	{
	return "Usernames and passwords are entered";
	}
}
