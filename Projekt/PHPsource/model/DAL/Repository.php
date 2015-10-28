<?php
namespace model\DAL;

require_once("Settings.php");

abstract class Repository 
{
	
	protected $dbConnection;
	protected $dbTable;
	
	protected function connection() // skapar connetction till min databas 
	{
		if ($this->dbConnection == null)
			$this->dbConnection = new \PDO(\Settings::$DB_CONNECTION, \Settings::$DB_USERNAME, \Settings::$DB_PASSWORD);
		
		$this->dbConnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		
		return $this->dbConnection;
	}
	
	
	public function query($sql, $params = null , $lastID = false) // vad som händer här 
	{  
		$db = $this -> connection();

		$query = $db -> prepare($sql);
		$result;
		if ($params != NULL) 
		{
			if (!is_array($params)) 
			{
				$params = array($params);
			}

			$result = $query -> execute($params);
		} 
		else 
		{
			$result = $query -> execute();
		}
		if ($lastID)
		{
			return $db->lastInsertId(); 
		}
		if ($query->rowCount() > 1)
		{
			return $result -> fetchAll();
		}

		return null;
		
	}

}
