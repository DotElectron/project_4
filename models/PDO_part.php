<?php

namespace Rochefort\Classes;
require_once('PDO_manager.php');

class PDO_part extends PDO_manager
{							//inDB...
	private $id;			//part_id 			int 				P_KEY
	private $order;			//part_order		int 				UNIQUE			(base 0)
	private $subtitle;		//part_subtitle 	varchar(255) 		
	private $htmlText;		//part_text			text
	private $timeStamp;		//part_modifier		timestamp 			
	private $chapter;		//part_chap_id 		int 				INDEX			F_KEY

	// --------------------------------
	// --------------------------------

	private function setId($_id) 
	{
		$this->id = $_id;
	}
	public function getId() 
	{
		return ($this->id);
	}
	private function setOrder($_order) 
	{
		$this->order = $_order;
	}
	public function getOrder() 
	{
		return ($this->order);
	}
	private function setSubtitle($_subtitle) 
	{
		$this->subtitle = $_subtitle;
	}
	public function getSubtitle() 
	{
		return ($this->subtitle);
	}
	private function setHtmlText($_htmlText) 
	{
		$this->htmlText = $_htmlText;
	}
	public function getHtmlText()
	{
		return ($this->htmlText);
	}
	private function setTimeStamp($_timeStamp) 
	{
		$this->timeStamp = $_timeStamp;
	}
	public function getTimeStamp()
	{
		return ($this->timeStamp);
	}
	private function setChapter($_chapter) 
	{
		$this->chapter = $_chapter;
	}
	public function getChapter() 
	{
		return ($this->chapter);
	}

	// --------------------------------
	// --------------------------------

	function __construct($_order = null, $_subtitle = null)
	{
		if ($_order !== null || $_subtitle !== null)
		{
			if ($this->hasConnection() || $this->dbConnect())
			{	
				try
				{
					$compField = 'part_order';
					$compValue = $_order;
					if ($_order === null) 
					{ 
						$compField = 'part_subtitle'; 
						$compValue = $_subtitle;
					}
					$request = $this->getConnection()->prepare('SELECT *
																FROM parts 
																WHERE ' . $compField . ' = ?');
					if ($request->execute(array($compValue)) > 0)
					{
						$result = $request->fetch();
						$this->setId($result['part_id']);
						$this->setOrder($result['part_order']);
						$this->setSubtitle($result['part_subtitle']);
						$this->setHtmlText($result['part_text']);
						$this->setTimeStamp($result['part_modifier']);
						$this->setChapter($result['part_chap_id']);
					}
				}
				catch (\PDOException $err) 
				{
					Error_manager::setErr('Failed to load part: ' . $err->getCode() . ' - ' . $err->getMessage());
				}
			}
			else { Error_manager::setErr('Erreur sur l\'épisode : connexion impossible à la base de données !'); }
		}
		else { Error_manager::setErr('Aucun épisode ne peut persister sans position (ou sous-titre) dans la base...'); }
	}

	// --------------------------------
	// --------------------------------

	/**
	* ...		(internal request to find the next available order)
	* @return bool next order from count (base 0)...
	*/
	private function nextOrder($_default = false) 
	{
		if ($this->hasConnection() || $this->dbConnect())
		{
			if (!$_default)
			{
				$result = -1;
				try
				{
					$request = $this->getConnection()->prepare('SELECT COUNT(part_order) 
																FROM parts');
					if ($request->execute() > 0)
					{
						$result = $request->fetchColumn();
					}
				}
				catch (\PDOException $err) 
				{
					Error_manager::setErr('Failed to count part: ' . $err->getCode() . ' - ' . $err->getMessage());
				}
				finally
				{
					return ($result);
				}
			}
			// Default blank response...
			return $_default;
		}
		//Connection error...
		return false;
	}
	/**
	* [External test of: nextOrder]					[0.0.7.2 PASSED]
	* Conditions: scope public, not private...
	*
	* require_once('models/PDO_part.php');
	* use Rochefort\Classes\PDO_part;
	*
	* $PDO_test = new PDO_part();
	*
	* echo 'DB connection: ' . var_export($PDO_test->nextOrder(true), true);
	* $PDO_test = null;
	*/

	// --------------------------------
	// --------------------------------

	/**
	* ...		(when admin creates a new part)
	* @param int $_chapter
	* @param string $_htmlText
	* @param string [optional] $_subtitle default=null
	* @return bool connection/request
	*/
	public function createPart($_chapter, $_htmlText, $_subtitle = null, $_default = false) 
	{
		if (($this->hasConnection() && $this->asAdmin()) || $this->dbConnect(true))
		{
			if ($_chapter !== null && is_numeric($_chapter) && $_htmlText !== null)
			{
				//Get a clean order...
				$_order = $this->nextOrder();

				//Create execution...
				$result = -1;
				try
				{
					$request = $this->getConnection()->prepare('INSERT INTO parts(part_order, part_subtitle, part_text, part_chap_id) 
																VALUES(?, ?, ?, ?)');
					$result = $request->execute(array($_order, $_subtitle, $_htmlText, $_chapter));
				}
				catch (\PDOException $err) 
				{
					Error_manager::setErr('Failed to create part: ' . $err->getCode() . ' - ' . $err->getMessage());
				}
				finally
				{
					return ($result > 0);
				}
			}
			else { Error_manager::setErr('Un épisode doit être rattaché à un chapitre et avoir un contenu...'); }
			// Default blank response...
			return $_default;
		}
		//Connection error...
		return false;
	}
	/**
	* [External test of: createPart]					[0.0.7.2 PASSED]
	* Conditions: any particular...
	*
	* require_once('models/PDO_part.php');
	* use Rochefort\Classes\PDO_part;
	*
	* $PDO_test = new PDO_part();
	*
	* echo 'DB connection: ' . var_export($PDO_test->createPart(null, null, null, true), true);
	* $PDO_test = null;
	* 
	*/

	/**
	* ...
	* @param ...
	* @return ...
	*/
	public function updatePart($_order, $_chapter, $_subtitle, $_htmlText) 
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
	public function changeOrder($_last_order, $new_order) 
	{
		
	}
	/**
	* [External test of: ]					[]
	* Conditions: 
	*
	* 
	*/

	/**
	* ...		(when admin deletes the chapter)
	* @param int $_id (or string->getIdByTitle)
	* @return bool connection/request
	*/
	public function deletePart($_order, $_default = false) 
	{
		if (($this->hasConnection() && $this->asAdmin()) || $this->dbConnect(true))
		{
			if ($_order !== null && is_numeric($_order))
			{
				//Delete execution...
				$result = -1;
				try
				{
					$request = $this->getConnection()->prepare('DELETE 
																FROM parts 
																WHERE part_order = ?');
					$result = $request->execute(array($_order));

					//Reorder current parts...
					
				}
				catch (\PDOException $err) 
				{
					Error_manager::setErr('Failed to delete part: ' . $err->getCode() . ' - ' . $err->getMessage());
				}
				finally
				{
					return ($result > 0);
				}
			}
			else { Error_manager::setErr('La position de l\'épisode doit être spécifiée...'); }
			// Default blank response...
			return $_default;
		}
		//Connection error...
		return false;
	}
	/**
	* [External test of: deletePart]					[0.0.7.2 PASSED]
	* Conditions: any particular...
	*
	* require_once('models/PDO_part.php');
	* use Rochefort\Classes\PDO_part;
	*
	* $PDO_test = new PDO_part();
	*
	* echo 'DB connection: ' . var_export($PDO_test->deletePart(null, true), true);
	* $PDO_test = null;
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

	// --------------------------------
	// --------------------------------

	protected function dbRelease()
	{

	}
}

?>