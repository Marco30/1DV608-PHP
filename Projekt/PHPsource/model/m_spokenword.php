<?php
namespace model;

class SpokenWord 
{
	private $SpokenWordID;
	private $name;
	private $notes;

	
	public function __construct($name, $iSpokenWordID = null, $owner = null, $notes = null) 
	{
		if (empty($name)) 
		{
			throw new Exception('Name of SpokenWord cannot be empty.');
		}
		
		$this->name = $name; 
		$this->SpokenWordID = $iSpokenWordID;  
		$this->owner = $owner;  
		$this->notes = $notes; 
		
	}
	
	public function equals(SpokenWord $other) // används det här 
	{ 
		return (
			$this->getName() == $other->getName() &&
			$this->getSpokenWordID() == $this->getSpokenWordID()
			);
	}
	
	public function getName() 
	{
		return $this->name;
	}
	

	public function setNotes($notes) 
	{
		$this->notes = $notes;
	}
	
	public function getNotes() 
	{
		return $this->notes;
	}
	
	
	public function getSpokenWordID() 
	{
		return $this->SpokenWordID;
	}
	
	public function setOwner(Textcollection $owner) // användas det här 
	{  
		$this->owner = $owner;
	}
	
	public function getOwner() 
	{
		return $this->owner;
	}
	

}
