<?php
namespace view;

// användas för att seta och hämta de olika html sidorna 

class HTMLBody 
{
	
	private $body;
	private $menu;
	private $script;
	

	public function setBody($body) 
	{
		
		$this->body = $body;
	}
	

	public function getBody() 
	{
		return $this->body;
	}
	
	
	public function setMenu($menu) 
	{
		$this->menu = $menu;
	}
	
	

	public function getMenu() 
	{ 
		return $this->menu;
	}
	
	public function setScript($script) 
	{
		$this->script = $script;
	}
	
	public function getScript() 
	{  
		if(!empty($this->script))
			return $this->script;
		
		return "";
	}
}

