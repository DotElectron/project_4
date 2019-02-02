<?php

namespace Rochefort\Classes;

require_once('PDO_manager.php');

class PDO_part extends PDO_manager
{							//inDB...
	private $id;			//part_id 			int 				P_KEY
	private $order;			//part_order		int 				UNIQUE
	private $subtitle;		//part_subtitle 	varchar(255) 		
	private $htmlText;		//part_text			text
	private $timeStamp;		//part_modifier		timestamp 			
	private $chapter;		//part_chap_id 		int 				INDEX				F_KEY

	function setId($_id) 
	{
		$this->id = $_id;
	}
	function getId() 
	{
		return ($this->id);
	}
	function setSubtitle($_subtitle) 
	{
		$this->subtitle = $_subtitle;
	}
	function getSubtitle() 
	{
		return ($this->subtitle);
	}
	function setHtmlText($_htmlText) 
	{
		$this->htmlText = $_htmlText;
	}
	function getHtmlText()
	{
		return ($this->htmlText);
	}
	function setTimeStamp($_timeStamp) 
	{
		$this->timeStamp = $_timeStamp;
	}
	function getTimeStamp()
	{
		return ($this->timeStamp);
	}
	function setChapter($_chapter) 
	{
		$this->chapter = $_chapter;
	}
	function getChapter() 
	{
		return ($this->chapter);
	}

	/**
	* ...
	* @param ...
	* @return ...
	*/
	public function createPart($chapter, $subtitle, $html) 
	{
		if ($this->dbConnect())
		{
			
		}
	}
	/**
	* [External test of: ]					[]
	* Conditions: 
	*
	* 
	*/

	/**
	* ...
	* @param ...
	* @return ...
	*/
	public function updatePart($id, $chapter, $subtitle, $html) 
	{
		
	}
	/**
	* [External test of: ]					[]
	* Conditions: 
	*
	* 
	*/

	/**
	* ...
	* @param ...
	* @return ...
	*/
	public function changeOrder($id, $order, $chapter) 
	{
		
	}
	/**
	* [External test of: ]					[]
	* Conditions: 
	*
	* 
	*/

	/**
	* ...
	* @param ...
	* @return ...
	*/
	public function deletePart($id) 
	{
		
	}
	/**
	* [External test of: ]					[]
	* Conditions: 
	*
	* 
	*/

	/**
	* ...
	* @param ...
	* @return ...
	*/
	public function getPartsOfChapter($chapter) 
	{
		
	}
	/**
	* [External test of: ]					[]
	* Conditions: 
	*
	* 
	*/

	protected function dbRelease()
	{

	}
}

?>