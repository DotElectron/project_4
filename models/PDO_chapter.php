<?php

namespace Rochefort\Classes;

require_once('PDO_manager.php');

class PDO_chapter extends PDO_manager
{							//inDB...
	private $id;			//chap_id 			int 				P_KEY
	private $order;			//chap_order		int 				UNIQUE
	private $title;			//chap_title 		varchar(255) 		UNIQUE

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

	// --------------------------------
	// --------------------------------

	/**
	* ...		(internal existancial request about the chapter)
	* @param int $_id
	* @return bool Chapter exists...
	*/
	function isExist($_id, $_default = false) 
	{
		if ($this->hasConnection() || $this->dbConnect())
		{
			if ($_id !== null && is_numeric($_id))
			{
				$result = -1;
				try
				{
					$request = $this->getConnection()->prepare('SELECT COUNT(*) 
																FROM chapters 
																WHERE chap_id = ?');
					if ($request->execute(array($_id)) > 0)
					{
						$result = $request->fetchColumn();
					}
				}
				catch (PDOException $err) 
				{
					Error_manager::setErr('Failed to load chapter: ' . $err->getCode() . ' - ' . $err->getMessage());
				}
				finally
				{
					return ($result > 0);
				}
			}
			else { Error_manager::setErr('Aucun identifiant abstrait ne peut persister dans la base...'); }
			// Default blank response...
			return $_default;
		}
		//Connection error...
		return false;
	}
	/**
	* [External test of: isExist]					[0.0.6.2 PASSED]
	* Conditions: scope public, not private...
	*
	* require_once('models/PDO_chapter.php');
	* use Rochefort\Classes\PDO_chapter;
	*
	* $PDO_test = new PDO_chapter();
	*
	* echo 'DB connection: ' . var_export($PDO_test->isExist(null, true), true);
	* $PDO_test = null;
	*/

	/**
	* ...		(internal existancial request about the order)
	* @param int $_order
	* @param int [optional] $_id default=-1
	* @return bool Free Order...
	*/
	function isClean($_order, $_id = null, $_default = false) 
	{
		if ($this->hasConnection() || $this->dbConnect())
		{
			if ($_order !== null && is_numeric($_order))
			{
				$result = -1;
				try
				{
					$request = $this->getConnection()->prepare('SELECT COUNT(*)
																FROM chapters 
																WHERE chap_order = ?
																AND chap_id != ?');
					if ($request->execute(array($_order, $_id)) > 0)
					{
						$result = $request->fetchColumn();
					}
				}
				catch (PDOException $err) 
				{
					Error_manager::setErr('Failed to find data: ' . $err->getCode() . ' - ' . $err->getMessage());
				}
				finally
				{
					return ($result < 1);
				}
			}
			else { Error_manager::setErr('Aucune position abstraite ne peut persister dans la base...'); }
			// Default blank response...
			return $_default;
		}
		//Connection error...
		return false;
	}
	/**
	* [External test of: isClean]					[0.0.6.2 PASSED]
	* Conditions: scope public, not private...
	*
	* require_once('models/PDO_chapter.php');
	* use Rochefort\Classes\PDO_chapter;
	*
	* $PDO_test = new PDO_chapter();
	*
	* echo 'DB connection: ' . var_export($PDO_test->isClean(null, null, true), true);
	* $PDO_test = null;
	*/

	// --------------------------------
	// --------------------------------

	/**
	* ...		(internal request to return the id of the chapter from his title)
	* @param string $_title
	* @return int $id...
	*/
	function getIdByTitle($_title, $_default = false) 
	{
		if ($this->hasConnection() || $this->dbConnect())
		{
			if ($_title !== null)
			{
				$result = null;
				try
				{
					$request = $this->getConnection()->prepare('SELECT chap_id 
																FROM chapters 
																WHERE chap_title = ?');
					if ($request->execute(array($_title)) > 0)
					{
						$result = $request->fetchColumn();
					}
				}
				catch (PDOException $err) 
				{
					Error_manager::setErr('Failed to find chapter: ' . $err->getCode() . ' - ' . $err->getMessage());
				}
				finally
				{
					return $result;
				}
			}
			else { Error_manager::setErr('Aucun chapitre sans titre ne peut persister dans la base...'); }
			// Default blank response...
			return $_default;
		}
		//Connection error...
		return false;
	}
	/**
	* [External test of: getIdByTitle]					[0.0.6.2 PASSED]
	* Conditions: scope public, not private...
	*
	* require_once('models/PDO_chapter.php');
	* use Rochefort\Classes\PDO_chapter;
	*
	* $PDO_test = new PDO_chapter();
	*
	* echo 'DB connection: ' . var_export($PDO_test->getIdByTitle(null, true), true);
	* $PDO_test = null;
	*/

	/**
	* ...		(internal request to return the id of the chapter from his order)
	* @param int $_order
	* @return int $id...
	*/
	function getIdByOrder($_order, $_default = false) 
	{
		if ($this->hasConnection() || $this->dbConnect())
		{
			if ($_order !== null && is_numeric($_order))
			{
				$result = null;
				try
				{
					$request = $this->getConnection()->prepare('SELECT chap_id 
																FROM chapters 
																WHERE chap_order = ?');
					if ($request->execute(array($_order)) > 0)
					{
						$result = $request->fetchColumn();
					}
				}
				catch (PDOException $err) 
				{
					Error_manager::setErr('Failed to find chapter: ' . $err->getCode() . ' - ' . $err->getMessage());
				}
				finally
				{
					return $result;
				}
			}
			else { Error_manager::setErr('Aucun chapitre sans position ne peut persister dans la base...'); }
			// Default blank response...
			return $_default;
		}
		//Connection error...
		return false;
	}
	/**
	* [External test of: getIdByOrder]					[0.0.6.2 PASSED]
	* Conditions: scope public, not private...
	*
	* require_once('models/PDO_chapter.php');
	* use Rochefort\Classes\PDO_chapter;
	*
	* $PDO_test = new PDO_chapter();
	*
	* echo 'DB connection: ' . var_export($PDO_test->getIdByOrder(null, true), true);
	* $PDO_test = null;
	*/

	/**
	* ...		(internal request to return the tile of the chapter from his id)
	* @param int $_id
	* @return string $title...
	*/
	function getTitleById($_id, $_default = false) 
	{
		if ($this->hasConnection() || $this->dbConnect())
		{
			if ($_id !== null && is_numeric($_id))
			{
				$result = null;
				try
				{
					$request = $this->getConnection()->prepare('SELECT chap_title 
																FROM chapters 
																WHERE chap_id = ?');
					if ($request->execute(array($_id)) > 0)
					{
						$result = $request->fetchColumn();
					}
				}
				catch (PDOException $err) 
				{
					Error_manager::setErr('Failed to find chapter: ' . $err->getCode() . ' - ' . $err->getMessage());
				}
				finally
				{
					return $result;
				}
			}
			else { Error_manager::setErr('Aucun chapitre sans titre ne peut persister dans la base...'); }
			// Default blank response...
			return $_default;
		}
		//Connection error...
		return false;
	}
	/**
	* [External test of: getTitleById]					[0.0.6.2 PASSED]
	* Conditions: scope public, not private...
	*
	* require_once('models/PDO_chapter.php');
	* use Rochefort\Classes\PDO_chapter;
	*
	* $PDO_test = new PDO_chapter();
	*
	* echo 'DB connection: ' . var_export($PDO_test->getTitleById(null, true), true);
	* $PDO_test = null;
	*/

	// --------------------------------
	// --------------------------------

	/**
	* ...		(when admin creates a new chapter)
	* @param int $_order
	* @param string $_title
	* @return bool connection/request
	*/
	public function createChapter($_order, $_title, $_default = false) 
	{
		if (($this->hasConnection() && $this->asAdmin()) || $this->dbConnect(true))
		{
			if ($_order !== null && is_numeric($_order) && $_title !== null)
			{
				//Check a clean order...
				if (!$this->isClean($_order, $_default))
				{
					//Move it to next position (about order)			//By object ? getChapterBy ?
					$_parseId = $this->getIdByOrder($_order, $_default);
					$this->updateChapter($_parseId, ($_order + 1), 
											$this->getTitleById($_parseId, $_default));
				}

				//Create execution...
				$result = -1;
				try
				{
					$request = $this->getConnection()->prepare('INSERT INTO chapters(chap_order, chap_title) 
																VALUES(?, ?)');
					$result = $request->execute(array($_order, $_title));
				}
				catch (PDOException $err) 
				{
					Error_manager::setErr('Failed to create chapter: ' . $err->getCode() . ' - ' . $err->getMessage());
				}
				finally
				{
					return ($result > 0);
				}
			}
			else { Error_manager::setErr('Vous devez choisir un titre et une position pour le chapitre...'); }
			// Default blank response...
			return $_default;
		}
		//Connection error...
		return false;
	}
	/**
	* [External test of: createChapter]					[0.0.6.2 PASSED]
	* Conditions: any particular...
	*
	* require_once('models/PDO_chapter.php');
	* use Rochefort\Classes\PDO_chapter;
	*
	* $PDO_test = new PDO_chapter();
	*
	* echo 'DB connection: ' . var_export($PDO_test->createChapter(null, null, true), true);
	* $PDO_test = null;
	* 
	*/

	/**
	* ...		(when admin modifies the chapter)
	* @param int $_id (or string->getIdByTitle)
	* @param int $_order
	* @param string $_title
	* @return bool connection/request
	*/
	public function updateChapter($_id, $_order, $_title, $_default = false) 
	{
		if (($this->hasConnection() && $this->asAdmin()) || $this->dbConnect(true))
		{
			if ($_id !== null 
				&& $_order !== null && is_numeric($_order)
				&& $_title !== null)
			{
				//Particular case: a string was sent into the $_id variable
				if (!is_numeric($_id))
				{
					$_id = $this->getIdByTitle($_id, $_default);
				}

				//Check a valid ID...
				if ($this->isExist($_id))
				{
					//Check a clean order...
					if (!$this->isClean($_order, $_id, $_default))
					{
						//Move it to next position (about order)			//By object ? getChapterBy ?
						$_parseId = $this->getIdByOrder($_order, $_default);
						$this->updateChapter($_parseId, ($_order + 1), 
											 $this->getTitleById($_parseId, $_default));
					}

					//Update execution...
					$result = -1;
					try
					{
						$request = $this->getConnection()->prepare('UPDATE chapters 
																	SET chap_order = ?, chap_title = ? 
																	WHERE chap_id = ?');
						$result = $request->execute(array($_order, $_title, $_id));
					}
					catch (PDOException $err) 
					{
						Error_manager::setErr('Failed to update chapter: ' . $err->getCode() . ' - ' . $err->getMessage());
					}
					finally
					{
						return ($result > 0);
					}
				}
				else { Error_manager::setErr('Le chapitre est invalide...'); return false; }
			}
			else { Error_manager::setErr('Les informations du chapitre sont invalides...'); }
			// Default blank response...
			return $_default;
		}
		//Connection error...
		return false;
	}
	/**
	* [External test of: updateChapter]					[0.0.6.2 PASSED]
	* Conditions: any particular...
	*
	* require_once('models/PDO_chapter.php');
	* use Rochefort\Classes\PDO_chapter;
	*
	* $PDO_test = new PDO_chapter();
	*
	* echo 'DB connection: ' . var_export($PDO_test->updateChapter(null, null, null, true), true);
	* $PDO_test = null;
	*/

	/**
	* ...		(when admin deletes the chapter)
	* @param int $_id (or string->getIdByTitle)
	* @return bool connection/request
	*/
	public function deleteChapter($_id, $_default = false) 
	{
		if (($this->hasConnection() && $this->asAdmin()) || $this->dbConnect(true))
		{
			if ($_id !== null)
			{
				//Particular case: a string was sent into the $_id variable
				if (!is_numeric($_id))
				{
					$_id = $this->getIdByTitle($_id, $_default);
				}

				//Delete execution...
				$result = -1;
				try
				{
					$request = $this->getConnection()->prepare('DELETE 
																FROM chapters 
																WHERE chap_id = ?');
					$result = $request->execute(array($_id));
				}
				catch (PDOException $err) 
				{
					Error_manager::setErr('Failed to delete chapter: ' . $err->getCode() . ' - ' . $err->getMessage());
				}
				finally
				{
					return ($result > 0);
				}
			}
			else { Error_manager::setErr('Le chapitre doit être spécifié...'); }
			// Default blank response...
			return $_default;
		}
		//Connection error...
		return false;
	}
	/**
	* [External test of: deleteChapter]					[0.0.6.2 PASSED]
	* Conditions: any particular...
	*
	* require_once('models/PDO_chapter.php');
	* use Rochefort\Classes\PDO_chapter;
	*
	* $PDO_test = new PDO_chapter();
	*
	* echo 'DB connection: ' . var_export($PDO_test->deleteChapter(null, true), true);
	* $PDO_test = null;
	*/

	/**
	* ...		(when ux requests the navigation)
	* @return array All Chapters...
	*/
	public function getAllChapters($_default = false) 
	{
		if (($this->hasConnection() && !$this->asAdmin()) || $this->dbConnect())
		{
			$result = null;
			try
			{
				$result = $this->getConnection()->query('SELECT chap_title 
														 FROM chapters 
														 ORDER BY chap_order ASC');
			}
			catch (PDOException $err) 
			{
				Error_manager::setErr('Failed to load chapters: ' . $err->getCode() . ' - ' . $err->getMessage());
			}
			finally
			{
				return $result;
			}

			// Default blank response...
			return $_default;
		}
		//Connection error...
		return false;
	}
	/**
	* [External test of: getAllChapters]					[0.0.5.2 PASSED]
	* Conditions: any particular...
	*
	* require_once('models/PDO_chapter.php');
	* use Rochefort\Classes\PDO_chapter;
	*
	* $PDO_test = new PDO_chapter();
	*
	* echo 'DB connection: ' . var_export($PDO_test->getAllChapters(true), true);
	* $PDO_test = null;
	*/

	// --------------------------------
	// --------------------------------

	protected function dbRelease()
	{
		
	}
}

?>