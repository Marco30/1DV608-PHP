<?php
namespace model;

class SpokenWordList 
{
	private $SpokenWord;
	
	public function __construct() 
	{
		$this->SpokenWord = array();
	}
	
	public function toArray()
	{
		return $this->SpokenWord;
	}
	
	public function add(SpokenWord $iSpokenWord) 
	{
		if (!$this->contains($iSpokenWord))
		{
			$this->SpokenWord[] = $iSpokenWord;
		}
	}
	
	public function contains(SpokenWord $iSpokenWord) 
	{
		foreach($this->SpokenWord as $key => $value) 
		{
			if ($iSpokenWord->equals($value)) 
			{
				return true;
			}
		}
		
		return false;
	}
}