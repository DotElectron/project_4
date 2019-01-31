<?php

namespace Rochefort\Classes;

class PDO_comment extends PDO_manager
{							//inDB...
	private $id;			//com_id 			int 				P_KEY
	private $author;		//com_author	 	varchar(60) 		(default: Anon)		
	private $htmlText;		//com_text 			text
	private $flag;			//com_flag			int
	private $muted;			//com_muted			tinyint 			(bool)
	private $timeStamp;		//com_modifier		timestamp 			INDEX
	private $part;			//com_part_id 		int

	function setId($_id) 
	{
		$this->id = $_id;
	}
	function getId() 
	{
		return ($this->id);
	}
	function setAuthor($_author) 
	{
		$this->author = $_author;
	}
	function getAuthor() 
	{
		return ($this->author);
	}
	function setHtmlText($_htmlText) 
	{
		$this->htmlText = $_htmlText;
	}
	function getHtmlText() 
	{
		return ($this->htmlText);
	}	
	function setFlag($_flag) 
	{
		$this->flag = $_flag;
	}
	function getFlag() 
	{
		return ($this->flag);
	}
	function setMuted($_muted) 
	{
		$this->muted = $_muted;
	}
	function getMuted() 
	{
		return ($this->muted);
	}
	function setPart($_part) 
	{
		$this->part = $_part;
	}
	function getPart() 
	{
		return ($this->part);
	}

	/**
	* ...		(when a user post a new comment)
	* @param ...
	* @return ...
	*/
	public function createComment($auth, $html) 
	{
		
	}
	/**
	* [External test of: ]					[]
	* Conditions: 
	*
	* 
	*/

	/**
	* ...		(when a user post again his comment)
	* @param ...
	* @return ...
	*/
	public function updateComment($id, $html) 
	{
		
	}
	/**
	* [External test of: ]					[]
	* Conditions: 
	*
	* 
	*/

	/**
	* ...		(when user put a flag on the comment)
	* @param ...
	* @return ...
	*/
	public function updateFlag($action) 
	{
		//++ || --
	}
	/**
	* [External test of: ]					[]
	* Conditions: 
	*
	* 
	*/

	/**
	* ...		(when admin decide to mute the comment)
	* @param ...
	* @return ...
	*/
	public function updateMuted($state) 
	{
		
	}
	/**
	* [External test of: ]					[]
	* Conditions: 
	*
	* 
	*/

	/**
	* ...		(when user/admin request a group of comments)
	* @param bool $muted (else: visible), bool $flagOrder (else: dateOrder)
	* @return ...
	*/
	public function getComments($muted, $flagOrder)
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