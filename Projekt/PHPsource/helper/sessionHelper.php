<?php
  namespace helper;

  class SessionHelper 
  {
    private static $sessionAlert = 'sessionAlert';
	public static $TextcollectionID = 'instrumentID';
	private static $sessionName = 'name';
	private static $username = 'username';
	private static $ceatedUsername = 'ceatedUsername';  


   
    public function getAlert() // Få en varning från session larmsystem
    {
      if (isset($_SESSION[self::$sessionAlert])) 
      {
        $ret = $_SESSION[self::$sessionAlert];
        unset($_SESSION[self::$sessionAlert]);
      } else {
        $ret = "";
      }

      return $ret;
    }


    public function setAlert($string) // Ställ en varning till session larmsystem
    {
      $_SESSION[self::$sessionAlert] = $string;
      return true;
    }
    

public function getUsername() 
{
      if (isset($_SESSION[self::$username])) 
      {
        $ret = $_SESSION[self::$username];
      } else {
        $ret = "";
      }

      return $ret;
    }

	 public function setUsername($string) 
	 {
      $_SESSION[self::$username] = $string;
      return true;
    }

public function getCreatedUsername() 
{
      if (isset($_SESSION[self::$ceatedUsername]))
      {
        $ret = $_SESSION[self::$ceatedUsername];
        unset($_SESSION[self::$ceatedUsername]);
      } else 
      {
        $ret = "";
      }

      return $ret;
    }

	 public function setCreatedUsername($string) 
	 {
      $_SESSION[self::$ceatedUsername] = $string;
      return true;
    }

	public function getHTextcollectionID() 
	{
      if (isset($_SESSION[self::$TextcollectionID])) 
      {
        $ret = $_SESSION[self::$TextcollectionID];
      } else {
        $ret = "";
      }

      return $ret;
    }


	 public function setHTextcollectionID($string) 
	 {
      $_SESSION[self::$TextcollectionID] = $string;
      return true;
    }
	 
	 public function unsetSession() 
	 {
      if (isset($_SESSION[self::$TextcollectionID]))
       unset($_SESSION[self::$TextcollectionID]);
    }

	
	public function setName($string) 
	{
      $_SESSION[self::$sessionName] = $string;
      return true;
    }


    public function getName() // hämtar namn från ession
    {
      if (isset($_SESSION[self::$sessionName])) 
      {
        $ret = $_SESSION[self::$sessionName];
        unset($_SESSION[self::$sessionName]);
      } else {
        $ret = "";
      }

      return $ret;
    }


    public function makeSafe($var)// tar bort tagar 
    {
      $var = trim($var);
      $var = stripslashes($var);
      $var = htmlentities($var);
      $var = strip_tags($var);

      return $var;
    }


    public function setUniqueID() // Skapa en unik identifierare
    {
      return sha1($_SERVER["REMOTE_ADDR"] . $_SERVER["HTTP_USER_AGENT"]);
    }

 
    public function encryptString($var) //Krypterar sträng
    {
      return sha1($var);
    }
  }
