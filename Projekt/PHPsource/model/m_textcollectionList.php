<?php

namespace model;

require_once("m_textcollection.php");


class TextcollectionList 
{
	private $TextcollectionList;
	
	public function __construct() 
	{
		$this->TextcollectionList = array();
	}
	

	public function toArray() // Returnerar array 
	{
		
		return $this->TextcollectionList;
	}
	

	public function add(Textcollection $iTextcollection) // läger till Textcollection i lista
    {
		if (!$this->contains($iTextcollection))
			$this->TextcollectionList[] = $iTextcollection;
	}
	
	


	public function contains(Textcollection $iTextcollection)// kotrolläara 
	{  // TODO is this used?
		foreach($this->TextcollectionList as $key => $owner) 
		{
			if ($owner->getTextcollectionID() == $iTextcollection->getTextcollectionID() && $owner->getName() == $iTextcollection->getName()) {
				return true;
			}
		}
		
		return false;
	}
}