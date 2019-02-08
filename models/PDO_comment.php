<?php

namespace Rochefort\Classes;
require_once('PDO_manager.php');

class PDO_comment extends PDO_manager
{							//inDB...
	private $id;			//com_id 			int 				P_KEY
	private $author;		//com_author	 	varchar(60) 		(default: Anon)		
	private $htmlText;		//com_text 			text
	private $flag;			//com_flag			int
	private $muted;			//com_muted			tinyint 			(bool)
	private $timeStamp;		//com_modifier		timestamp 			INDEX				DESC
	private $part;			//com_part_id 		int					INDEX				F_KEY

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
	* ...		(when a user posts a new comment)
	* @param int $_part
	* @param string $_htmlText
	* @param string [optional] $_author default=null
	* @return ...
	*/
	public function createComment($_part, $_htmlText, $_author = null) 
	{
		
	}
	/**
	* [External test of: ]					[]
	* Conditions: 
	*
	* 
	*/

	/**
	* ...		(when user puts a flag on the comment)
	* @param int $_id
	* @return ...
	*/
	public function updateFlag($_id, $__default = false) 
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
	* ...		(when admin decides to mute the comment)
	* @param int $_id
	* @param bool $_muted
	* @return ...
	*/
	public function updateMuted($_id, $_muted, $__default = false) 
	{
		
	}
	/**
	* [External test of: ]					[]
	* Conditions: 
	*
	* 
	*/

	/**
	* ...		(when user/admin requests a group of comments)
	* @param int [optional] $_part default=-1
	* @param bool [optional] $flagOrder (else: dateOrder DESC) default=false
	* @param bool [optional] $visibleRange (0:notOnly;1:mutedOnly;2:both) default=0
	* @return ...
	*/
	public function getComments($_part = -1, $flagOrder = false, $visibleRange = 0, $__default = false)
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