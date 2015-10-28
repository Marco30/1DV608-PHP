<?php
  namespace helper;

  class FileStorage 
  {
    private static $path = "db/";

    
    public function getFileContent($fileName)// Får filen innehåll
    {
      if (file_exists(self::$path . $fileName)) 
      {
        return file_get_contents(self::$path . $fileName);
      }

      return false;
    }


    public function setFileContent($fileName, $value) //Spara innehållet i en fil
    {
      file_put_contents(self::$path . $fileName, $value);

      return true;
    }

 
    public function removeFile($fileName)//  Tar bort fil
    {
      unlink(self::$path . $fileName);

      return true;
    }
  }
