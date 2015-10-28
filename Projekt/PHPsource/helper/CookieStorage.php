<?php
  namespace helper;

  require_once("PHPsource/helper/FileStorage.php");

  class CookieStorage
  {
    private $fileStorage;

    public function __construct()
    {
      $this->fileStorage = new \helper\FileStorage();
    }


    public function isCookieSet($name) //Kontrollerar om cookien är satt
    {
      if (isset($_COOKIE[$name]))
        return true;

      return false;
    }

 
    public function getCookieValue($name) // Få Cookie värde
    {
      return $_COOKIE[$name];
    }

 
    public function isCookieValid($name) // Kontrollerar om en cookie är giltig och tar bort filen om inte
    {
      if ($this->fileStorage->getFileContent($name) > time()) 
      {
        return true;
      }

      $this->fileStorage->removeFile($name);
      return false;
    }

  
    public function save($name, $string, $uniq = false) // Spara kaka cookie
    {
      $time = time() + 60 * 60 * 24 * 30;

      if ($uniq)
      {
        $this->fileStorage->setFileContent($string, $time);
      }

      setcookie($name, $string, $time, "/");

      return true;
    }

  
    public function destroy($name) // Deletes cookie
    {
     if (isset($_COOKIE[$name]))
      	setcookie($name, "", time() -1, "/");
      return true;
    }
  }
