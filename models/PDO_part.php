<?php

namespace Forteroche\Classes;
require_once('PDO_manager.php');

class PDO_part extends PDO_manager
{							//inDB...
	private $id;			//part_id 			int 				P_KEY
	private $order;			//part_order		int 				UNIQUE			(base 0)
	private $subtitle;		//part_subtitle 	varchar(255) 		UNIQUE			(allow null)
	private $htmlText;		//part_text			text
	private $timeStamp;		//part_modifier		timestamp 			
	private $chapter;		//part_chap_id 		int 				INDEX			F_KEY

	// --------------------------------
	// --------------------------------

	final protected function setId($_id) 
	{
		$this->id = $_id;
	}
	public function getId() 
	{
		return ($this->id);
	}
	final protected function setOrder($_order) 
	{
		$this->order = $_order;
	}
	public function getOrder() 
	{
		return ($this->order);
	}
	final protected function setSubtitle($_subtitle) 
	{
		$this->subtitle = $_subtitle;
	}
	public function getSubtitle($strip = true) 
	{
		if ($strip && $this->subtitle !== null) 
		{ 
			return (self::htmlSecure($this->subtitle, true, true)); 
		}
		else { return ($this->subtitle); }
	}
	final protected function setHtmlText($_htmlText) 
	{
		$this->htmlText = $_htmlText;
	}
	public function getHtmlText()
	{
		return (self::htmlSecure($this->htmlText, true));
	}
	final protected function setTimeStamp($_timeStamp) 
	{
		$this->timeStamp = $_timeStamp;
	}
	public function getTimeStamp()
	{
		return ($this->timeStamp);
	}
	final protected function setChapter($_chapter) 
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
		global $activeTest;
		if (($_order !== null && is_numeric($_order)) 
			|| $_subtitle !== null)
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
					else if ($_order === '?')
					{
						$compValue = ($this->nextOrder() - 1);
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
		else if (isset($activeTest))
		{ 
			Error_manager::setErr('[Empty Constructor]'); 
		}
		else
		{
			Error_manager::setErr('Aucun épisode ne peut persister sans position (ou sous-titre) dans la base...'); 
		}
	}

	// --------------------------------
	// --------------------------------

	/**
	* ...		(internal request to find the next available order)
	* @return bool next order from count (base 0)...
	*/
	protected function nextOrder($__default = false) 
	{
		if ($this->hasConnection() || $this->dbConnect())
		{
			if (!$__default)
			{
				$result = -1;
				try
				{
					//Order execution...
					$request = $this->getConnection()->prepare('SELECT MAX(part_order)
																FROM parts');
					if ($request->execute() > 0)
					{
						$result = $request->fetchColumn();
						if ($result === null) { $result = 0; }
						else { $result += 1; }
					}
				}
				catch (\PDOException $err) 
				{
					Error_manager::setErr('Failed to get max order: ' . $err->getCode() . ' - ' . $err->getMessage());
				}
				finally
				{
					return ($result);
				}
			}
			// Default blank response...
			return $__default;
		}
		//Connection error...
		return false;
	}
	/**
	* [External test of: nextOrder]					
	* Conditions: scope public, not private...
	*
	* require_once('models/PDO_part.php');
	* use Forteroche\Classes\PDO_part;
	*
	* $PDO_test = new PDO_part();
	*
	* echo 'DB connection: ' . var_export($PDO_test->nextOrder(true), true);
	* $PDO_test = null;
	*/

	/**
	* ...		(internal existancial request about the chapter)
	* @param int $_order
	* @return bool Part exists...
	*/
	protected function isExist($_order, $__default = false) 
	{
		global $activeTest;
		if ($this->hasConnection() || $this->dbConnect())
		{
			if ($_order !== null && is_numeric($_order))
			{
				$result = -1;
				try
				{
					$request = $this->getConnection()->prepare('SELECT COUNT(*) 
																FROM parts 
																WHERE part_order = ?');
					if ($request->execute(array($_order)) > 0)
					{
						$result = $request->fetchColumn();
					}
				}
				catch (\PDOException $err) 
				{
					Error_manager::setErr('Failed to load part: ' . $err->getCode() . ' - ' . $err->getMessage());
				}
				finally
				{
					return ($result > 0);
				}
			}
			else if (!isset($activeTest)) { Error_manager::setErr('Aucune position abstraite ne peut persister dans la base...'); }
			// Default blank response...
			return $__default;
		}
		//Connection error...
		return false;
	}
	/**
	* [External test of: isExist]					
	* Conditions: scope public, not private...
	*
	* require_once('models/PDO_part.php');
	* use Forteroche\Classes\PDO_part;
	*
	* $PDO_test = new PDO_part();
	*
	* echo 'DB connection: ' . var_export($PDO_test->isExist(null, true), true);
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
	final public function createPart($_chapter, $_htmlText, $_subtitle = null, $__default = false) 
	{
		global $activeTest;
		if (($this->hasConnection() && $this->asAdmin()) || $this->dbConnect(true))
		{
			if (($_chapter === null || is_numeric($_chapter)) && $_htmlText !== null)
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
			else if (!isset($activeTest)) { Error_manager::setErr('Un épisode doit être rattaché à un chapitre valide et avoir un contenu...'); }
			// Default blank response...
			return $__default;
		}
		//Connection error...
		return false;
	}
	/**
	* [External test of: createPart]					
	* Conditions: any particular...
	*
	* require_once('models/PDO_part.php');
	* use Forteroche\Classes\PDO_part;
	*
	* $PDO_test = new PDO_part();
	*
	* echo 'DB connection: ' . var_export($PDO_test->createPart(null, null, null, true), true);
	* $PDO_test = null;
	* 
	*/

	/**
	* ... 		(when admin changes the content [chapter's link, subtitle, htmlText])
	* @param int $_order
	* @param int $_chapter
	* @param string $_subtitle
	* @param string $_htmlText
	* @return bool connection/request
	*/
	final public function updatePart($_order, $_chapter, $_subtitle, $_htmlText, $__default = false) 
	{
		global $activeTest;
		if (($this->hasConnection() && $this->asAdmin()) || $this->dbConnect(true))
		{
			if ($_order !== null && is_numeric($_order) 
				&& ($_chapter === null || is_numeric($_chapter))
				&& $_htmlText !== null)
			{
				//Check a valid Order...
				if ($this->isExist($_order))
				{
					//Update execution...
					$result = -1;
					try
					{
						$request = $this->getConnection()->prepare('UPDATE parts
																	SET part_subtitle = ?, part_text = ?, part_chap_id = ?
																	WHERE part_order = ?');
						$result = $request->execute(array($_subtitle, $_htmlText, $_chapter, $_order));
					}
					catch (\PDOException $err) 
					{
						Error_manager::setErr('Failed to update part: ' . $err->getCode() . ' - ' . $err->getMessage());
					}
					finally
					{
						return ($result > 0);
					}
				}
				else { Error_manager::setErr('L\'épisode est invalide...'); return false; }
			}
			else if (!isset($activeTest)) { Error_manager::setErr('Les informations sur l\'épisode sont invalides...'); }
			// Default blank response...
			return $__default;
		}
		//Connection error...
		return false;
	}
	/**
	* [External test of: updatePart]					
	* Conditions: any particular...
	*
	* require_once('models/PDO_part.php');
	* use Forteroche\Classes\PDO_part;
	*
	* $PDO_test = new PDO_part();
	*
	* echo 'DB connection: ' . var_export($PDO_test->updatePart(null, null, null, null, true), true);
	* $PDO_test = null;
	*/

	/**
	* ...		(when admin or ux changes the part order)
	* @param int $last_order
	* @param int $new_order
	* @param int [optional] $recursiveTarget default=-1
	* @return bool connection/request
	*/
	final public function changeOrder($last_order, $new_order, $recursiveTarget = -1, $__default = false) 
	{
		global $activeDebug;
		global $activeTest;
		if (($this->hasConnection() && $this->asAdmin()) || $this->dbConnect(true))
		{
			global $activeDebug;
			if ($last_order !== null && is_numeric($last_order)
				&& $new_order !== null && is_numeric($new_order)
				&& $recursiveTarget !== null && is_numeric($recursiveTarget))
			{
				if ($last_order != $new_order)
				{
					$result = -1;
					try
					{
						//Define vector...
						$vector = 1;
						if ($last_order > $new_order) { $vector = -1; }

						if ($recursiveTarget !== -1)
						{
							//From a delete operation...
							if ($new_order !== $recursiveTarget
								&& $this->isExist($new_order))
							{
								//Prepare next position...
								$this->changeOrder($new_order, ($new_order + $vector), $recursiveTarget, $__default);	
							}
							if (isset($activeDebug))
							{
								Error_manager::setErr('(parsedOp->recursiveReordered: ' 
														. $last_order . ' to:' . $new_order . ' limit:' . $recursiveTarget . ')'); 
							} 
						}
						else
						{
							//From a change request...
							$request = $this->getConnection()->prepare('UPDATE parts 
																		SET  part_order = -1
																		WHERE part_order = ?');
							$request->execute(array($last_order));
							$this->changeOrder($new_order, ($new_order - $vector), $last_order, $__default);
							if (isset($activeDebug))
							{
								Error_manager::setErr('(inFine->recursiveReordered: ' 
														. $last_order . ' to:' . $new_order . ' as single)'); 
							} 
							$last_order = -1;
						}

						//Delete execution...
						$request = $this->getConnection()->prepare('UPDATE parts 
																	SET  part_order = ?
																	WHERE part_order = ?');
						$result = $request->execute(array($new_order, $last_order));
					}
					catch (\PDOException $err) 
					{
						Error_manager::setErr('Failed to reorder part: ' . $err->getCode() . ' - ' . $err->getMessage());
					}
					finally
					{
						return ($result > 0);
					}
				}
				else { Error_manager::setErr('Les positions d\'épisodes doivent être différentes...'); }
			}
			else if (!isset($activeTest)) { Error_manager::setErr('Les positions d\'épisodes doivent être spécifiées...'); }
			// Default blank response...
			return $__default;
		}
		//Connection error...
		return false;
	}
	/**
	* [External test of: changeOrder]					
	* Conditions: any particular...
	*
	* require_once('models/PDO_part.php');
	* use Forteroche\Classes\PDO_part;
	*
	* $PDO_test = new PDO_part();
	*
	* echo 'DB connection: ' . var_export($PDO_test->changeOrder(null, null, null, true), true);
	* $PDO_test = null;
	*/

	/**
	* ...		(when admin deletes the part)
	* @param int $_order
	* @return bool connection/request
	*/
	final public function deletePart($_order, $__default = false) 
	{
		global $activeTest;
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

					try
					{
						//Reorder the parts (if necessary)...
						$last_order = ($this->nextOrder() - 1);
						if ($last_order > 0 
							&& $last_order > $_order)
						{
							$this->changeOrder($last_order, ($last_order - 1), $_order);
						}
					}
					catch (\PDOException $sub_err) 
					{
						Error_manager::setErr('Failed to reorder parts: ' . $sub_err->getCode() . ' - ' . $sub_err->getMessage());
					}
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
			else if (!isset($activeTest)) { Error_manager::setErr('La position de l\'épisode doit être spécifiée...'); }
			// Default blank response...
			return $__default;
		}
		//Connection error...
		return false;
	}
	/**
	* [External test of: deletePart]					
	* Conditions: any particular...
	*
	* require_once('models/PDO_part.php');
	* use Forteroche\Classes\PDO_part;
	*
	* $PDO_test = new PDO_part();
	*
	* echo 'DB connection: ' . var_export($PDO_test->deletePart(null, true), true);
	* $PDO_test = null;
	*/

	/**
	* ...		(when ux requests the navigation)
	* @param int [optional] $_chapter default=null(:draft)
	* @return array All ordered Parts of the chapter...
	*/
	final public function getPartsOfChapter($_chapter = null, $__default = false) 
	{
		if (($this->hasConnection() && !$this->asAdmin()) || $this->dbConnect())
		{
			//Select execution...
			$result = null;
			try
			{
				//Corrective value...
				$statement = ' = ? ';
				if ($_chapter === null)
				{
					// Particular case: get draft parts...
					$statement = ' IS NULL ';
				}
				$request = $this->getConnection()->prepare('SELECT part_subtitle, part_text, part_order
														   FROM parts
														   WHERE part_chap_id' . $statement
														   . 'ORDER BY part_order ASC');
				if ((is_numeric($_chapter) && $request->execute(array($_chapter)) > 0)
					|| ($_chapter === null && $request->execute() > 0))
				{
					$result = $request->fetchAll();
					//Html_decode...
					for ($i = 0; $i < count($result); $i++)
					{
						if ($result[$i]['part_subtitle'] !== null)
						{
							$result[$i]['part_subtitle'] = self::htmlSecure($result[$i]['part_subtitle'], true, true);
						}
						$result[$i]['part_text'] = self::htmlSecure($result[$i]['part_text'], true);
					}
				}
			}
			catch (\PDOException $err) 
			{
				Error_manager::setErr('Failed to load parts: ' . $err->getCode() . ' - ' . $err->getMessage());
			}
			finally
			{
				return $result;
			}
			// Default blank response...
			return $__default;
		}
		//Connection error...
		return false;
	}
	/**
	* [External test of: getPartsOfChapter]					
	* Conditions: any particular...
	*
	* require_once('models/PDO_part.php');
	* use Forteroche\Classes\PDO_part;
	*
	* $PDO_test = new PDO_part();
	*
	* echo 'DB connection: ' . var_export($PDO_test->getPartsOfChapter(null, true), true);
	* $PDO_test = null;
	*/
}

?>