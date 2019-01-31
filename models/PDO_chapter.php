<?php

namespace Rochefort\Classes;

class PDO_chapter extends PDO_manager
{							//inDB...
	private $id;			//chap_id 			int 				P_KEY
	private $order;			//chap_order		int 				UNIQUE
	private $title;			//chap_title 		varchar(255) 		

	function setId($_id) 
	{
		$this->id = $_id;
	}
	function getId() 
	{
		return ($this->id);
	}
	function setOrder($_order) 
	{
		$this->order = $_order;
	}
	function getOrder() 
	{
		return ($this->order);
	}
	function setTitle($_title) 
	{
		$this->title = $_title;
	}
	function getTitle() 
	{
		return ($this->title);
	}

	/**
	* ...		(when admin create a new chapter)
	* @param ...
	* @return ...
	*/
	public function createChapter($order, $title) 
	{
		
	}
	/**
	* [External test of: ]					[]
	* Conditions: 
	*
	* 
	*/

	/**
	* ...		(when admin modify the chapter)
	* @param ...
	* @return ...
	*/
	public function updateChapter($id, $order, $title) 
	{
		
	}
	/**
	* [External test of: ]					[]
	* Conditions: 
	*
	* 
	*/

	/**
	* ...		(when admin delete the chapter)
	* @param ...
	* @return ...
	*/
	public function deleteChapter($id) 
	{
		
	}
	/**
	* [External test of: ]					[]
	* Conditions: 
	*
	* 
	*/

	/**
	* ...		(when ux request the navigation)
	* @param ...
	* @return ...
	*/
	public function getAllChapters() 
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