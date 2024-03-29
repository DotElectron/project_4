<?php

namespace Forteroche\Classes;
require_once('PDO_manager.php');

class PDO_chapter extends PDO_manager
{							//inDB...
	private $id;			//chap_id 			int 				P_KEY
	private $order;			//chap_order		int 				UNIQUE			(base 0)
	private $title;			//chap_title 		varchar(255) 		UNIQUE

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
	final protected function setTitle($_title) 
	{
		$this->title = $_title;
	}
	public function getTitle($strip = true) 
	{
		if ($strip) { return (self::htmlSecure($this->title, true, true)); }
		else { return ($this->title); }
	}

	// --------------------------------
	// --------------------------------

	function __construct($_title = null)
	{
		global $activeTest;
		if ($_title !== null)
		{
			if ($this->hasConnection() || $this->dbConnect())
			{	
				try
				{
					$statement = ' WHERE chap_title = ?';
					if ($_title === '?')
					{
						// Particular case: get last id...
						$statement = ' ORDER BY chap_order DESC LIMIT 1';
					}

					$request = $this->getConnection()->prepare('SELECT *
																FROM chapters'
																. $statement);
					if ($request->execute(array($_title)) > 0)
					{
						$result = $request->fetch();
						$this->setId($result['chap_id']);
						$this->setOrder($result['chap_order']);
						$this->setTitle($result['chap_title']);
					}
				}
				catch (\PDOException $err) 
				{
					Error_manager::setErr('Failed to load chapter: ' . $err->getCode() . ' - ' . $err->getMessage());
				}
			}
			else { Error_manager::setErr('Erreur sur le chapitre : connexion impossible à la base de données !'); }
		}
		else if (isset($activeTest))
		{ 
			Error_manager::setErr('[Empty Constructor]'); 
		}
		else
		{
			Error_manager::setErr('Aucun chapitre ne peut persister sans titre dans la base...'); 
		}
	}

	// --------------------------------
	// --------------------------------

	/**
	* ...		(internal existancial request about the chapter)
	* @param int $_id
	* @return bool Chapter exists...
	*/
	protected function isExist($_id, $__default = false) 
	{
		global $activeTest;
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
				catch (\PDOException $err) 
				{
					Error_manager::setErr('Failed to load chapter: ' . $err->getCode() . ' - ' . $err->getMessage());
				}
				finally
				{
					return ($result > 0);
				}
			}
			else if (!isset($activeTest)) { Error_manager::setErr('Aucun identifiant abstrait ne peut persister dans la base...'); }
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
	* require_once('models/PDO_chapter.php');
	* use Forteroche\Classes\PDO_chapter;
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
	protected function isClean($_order, $_id = null, $__default = false) 
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
																FROM chapters 
																WHERE chap_order = ?
																AND chap_id != ?');
					if ($request->execute(array($_order, $_id)) > 0)
					{
						$result = $request->fetchColumn();
					}
				}
				catch (\PDOException $err) 
				{
					Error_manager::setErr('Failed to find data: ' . $err->getCode() . ' - ' . $err->getMessage());
				}
				finally
				{
					return ($result < 1);
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
	* [External test of: isClean]					
	* Conditions: scope public, not private...
	*
	* require_once('models/PDO_chapter.php');
	* use Forteroche\Classes\PDO_chapter;
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
	protected function getIdByTitle($_title, $__default = false) 
	{
		global $activeTest;
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
				catch (\PDOException $err) 
				{
					Error_manager::setErr('Failed to find chapter: ' . $err->getCode() . ' - ' . $err->getMessage());
				}
				finally
				{
					return $result;
				}
			}
			else if (!isset($activeTest)) { Error_manager::setErr('Aucun chapitre sans titre ne peut persister dans la base...'); }
			// Default blank response...
			return $__default;
		}
		//Connection error...
		return false;
	}
	/**
	* [External test of: getIdByTitle]					
	* Conditions: scope public, not private...
	*
	* require_once('models/PDO_chapter.php');
	* use Forteroche\Classes\PDO_chapter;
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
	protected function getIdByOrder($_order, $__default = false) 
	{
		global $activeTest;
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
				catch (\PDOException $err) 
				{
					Error_manager::setErr('Failed to find chapter: ' . $err->getCode() . ' - ' . $err->getMessage());
				}
				finally
				{
					return $result;
				}
			}
			else if (!isset($activeTest)) { Error_manager::setErr('Aucun chapitre sans position ne peut persister dans la base...'); }
			// Default blank response...
			return $__default;
		}
		//Connection error...
		return false;
	}
	/**
	* [External test of: getIdByOrder]					
	* Conditions: scope public, not private...
	*
	* require_once('models/PDO_chapter.php');
	* use Forteroche\Classes\PDO_chapter;
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
	protected function getTitleById($_id, $__default = false) 
	{
		global $activeTest;
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
				catch (\PDOException $err) 
				{
					Error_manager::setErr('Failed to find chapter: ' . $err->getCode() . ' - ' . $err->getMessage());
				}
				finally
				{
					return $result;
				}
			}
			else if (!isset($activeTest)) { Error_manager::setErr('Aucun chapitre sans titre ne peut persister dans la base...'); }
			// Default blank response...
			return $__default;
		}
		//Connection error...
		return false;
	}
	/**
	* [External test of: getTitleById]					
	* Conditions: scope public, not private...
	*
	* require_once('models/PDO_chapter.php');
	* use Forteroche\Classes\PDO_chapter;
	*
	* $PDO_test = new PDO_chapter();
	*
	* echo 'DB connection: ' . var_export($PDO_test->getTitleById(null, true), true);
	* $PDO_test = null;
	*/

	/**
	* ...		(internal request to return the order of the chapter from his id)
	* @param int $_id
	* @return int $order...
	*/
	protected function getOrderById($_id, $__default = false) 
	{
		global $activeTest;
		if ($this->hasConnection() || $this->dbConnect())
		{
			if ($_id !== null && is_numeric($_id))
			{
				$result = null;
				try
				{
					$request = $this->getConnection()->prepare('SELECT chap_order 
																FROM chapters 
																WHERE chap_id = ?');
					if ($request->execute(array($_id)) > 0)
					{
						$result = $request->fetchColumn();
					}
				}
				catch (\PDOException $err) 
				{
					Error_manager::setErr('Failed to find chapter: ' . $err->getCode() . ' - ' . $err->getMessage());
				}
				finally
				{
					return $result;
				}
			}
			else if (!isset($activeTest)) { Error_manager::setErr('Aucun chapitre sans identifiant ne peut persister dans la base...'); }
			// Default blank response...
			return $__default;
		}
		//Connection error...
		return false;
	}
	/**
	* [External test of: getOrderById]					
	* Conditions: scope public, not private...
	*
	* require_once('models/PDO_chapter.php');
	* use Forteroche\Classes\PDO_chapter;
	*
	* $PDO_test = new PDO_chapter();
	*
	* echo 'DB connection: ' . var_export($PDO_test->getOrderById(null, true), true);
	* $PDO_test = null;
	*/

	// --------------------------------
	// --------------------------------

	/**
	* ...		(when admin creates a new chapter)
	* @param int $_order (base 0)
	* @param string $_title
	* @return bool connection/request
	*/
	final public function createChapter($_order, $_title, $__default = false) 
	{
		global $activeTest;
		if (($this->hasConnection() && $this->asAdmin()) || $this->dbConnect(true))
		{
			if ($_order !== null && is_numeric($_order) && $_title !== null)
			{
				//Check a clean order...
				if (!$this->isClean($_order, $__default))
				{
					//Move it to next position (about order)			//By object ? getChapterBy ?
					$_parseId = $this->getIdByOrder($_order, $__default);
					$this->updateChapter($_parseId, ($_order + 1), 
										 $this->getTitleById($_parseId, $__default), true);
				}

				//Create execution...
				$result = -1;
				try
				{
					$request = $this->getConnection()->prepare('INSERT INTO chapters(chap_order, chap_title) 
																VALUES(?, ?)');
					$result = $request->execute(array($_order, $_title));
				}
				catch (\PDOException $err) 
				{
					Error_manager::setErr('Failed to create chapter: ' . $err->getCode() . ' - ' . $err->getMessage());
				}
				finally
				{
					return ($result > 0);
				}
			}
			else if (!isset($activeTest)) { Error_manager::setErr('Vous devez choisir un titre et une position pour le chapitre...'); }
			// Default blank response...
			return $__default;
		}
		//Connection error...
		return false;
	}
	/**
	* [External test of: createChapter]					
	* Conditions: any particular...
	*
	* require_once('models/PDO_chapter.php');
	* use Forteroche\Classes\PDO_chapter;
	*
	* $PDO_test = new PDO_chapter();
	*
	* echo 'DB connection: ' . var_export($PDO_test->createChapter(null, null, true), true);
	* $PDO_test = null;
	* 
	*/

	/**
	* ...		(when admin modifies the chapter)
	* @param mixed $_id (or string->getIdByTitle)
	* @param int $_order
	* @param string $_title
	* @param bool [optional] $forceOd
	* @return bool connection/request
	*/
	final public function updateChapter($_id, $_order, $_title, $forceOd = false, $__default = false) 
	{
		global $activeTest;
		if (($this->hasConnection() && $this->asAdmin()) || $this->dbConnect(true))
		{
			if ($_id !== null 
				&& $_order !== null && is_numeric($_order)
				&& $_title !== null)
			{
				//Particular case: a string was sent into the $_id variable
				if (!is_numeric($_id))
				{
					$_id = $this->getIdByTitle($_id, $__default);
				}

				//Check a valid ID...
				if ($this->isExist($_id))
				{
					//Check a clean order...
					if (!$this->isClean($_order, $_id, $__default))
					{
						//Define vector...
						$vector = 1;
						$parseOd = $this->getOrderById($_id, $__default);
						if (!$forceOd && $_order > $parseOd) { $vector = -1; }
						//Bufferize vector...
						if ($vector < 0)
						{
							$request = $this->getConnection()->prepare('UPDATE chapters 
																		SET  chap_order = -1
																		WHERE chap_order = ?');
							$request->execute(array($parseOd));
						}
						//Move it to next position (about order)
						$_parseId = $this->getIdByOrder($_order, $__default);
						$this->updateChapter($_parseId, ($_order + $vector), 
											 $this->getTitleById($_parseId, $__default));
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
					catch (\PDOException $err) 
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
			else if (!isset($activeTest)) { Error_manager::setErr('Les informations du chapitre sont invalides...'); }
			// Default blank response...
			return $__default;
		}
		//Connection error...
		return false;
	}
	/**
	* [External test of: updateChapter]					
	* Conditions: any particular...
	*
	* require_once('models/PDO_chapter.php');
	* use Forteroche\Classes\PDO_chapter;
	*
	* $PDO_test = new PDO_chapter();
	*
	* echo 'DB connection: ' . var_export($PDO_test->updateChapter(null, null, null, true), true);
	* $PDO_test = null;
	*/

	/**
	* ...		(when admin deletes the chapter)
	* @param mixed $_id (or string->getIdByTitle)
	* @return bool connection/request
	*/
	final public function deleteChapter($_id, $__default = false) 
	{
		global $activeTest;
		if (($this->hasConnection() && $this->asAdmin()) || $this->dbConnect(true))
		{
			if ($_id !== null)
			{
				//Particular case: a string was sent into the $_id variable
				if (!is_numeric($_id))
				{
					$_id = $this->getIdByTitle($_id, $__default);
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
				catch (\PDOException $err) 
				{
					Error_manager::setErr('Failed to delete chapter: ' . $err->getCode() . ' - ' . $err->getMessage());
				}
				finally
				{
					return ($result > 0);
				}
			}
			else if (!isset($activeTest)) { Error_manager::setErr('Le chapitre doit être spécifié...'); }
			// Default blank response...
			return $__default;
		}
		//Connection error...
		return false;
	}
	/**
	* [External test of: deleteChapter]					
	* Conditions: any particular...
	*
	* require_once('models/PDO_chapter.php');
	* use Forteroche\Classes\PDO_chapter;
	*
	* $PDO_test = new PDO_chapter();
	*
	* echo 'DB connection: ' . var_export($PDO_test->deleteChapter(null, true), true);
	* $PDO_test = null;
	*/

	/**
	* ...		(when ux requests the navigation)
	* @return array All ordered Chapters...
	*/
	final public function getAllChapters($__default = false) 
	{
		if (($this->hasConnection() && !$this->asAdmin()) || $this->dbConnect())
		{
			$result = null;
			try
			{
				$request = $this->getConnection()->prepare('SELECT chap_title 
														   FROM chapters 
														   ORDER BY chap_order ASC');
				if ($request->execute() > 0)
				{
					$result = $request->fetchAll();
					//Html_decode...
					for ($i = 0; $i < count($result); $i++)
					{
						$result[$i]['chap_title'] = self::htmlSecure($result[$i]['chap_title'], true, true);
					}
				}
				
			}
			catch (\PDOException $err) 
			{
				Error_manager::setErr('Failed to load chapters: ' . $err->getCode() . ' - ' . $err->getMessage());
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
	* [External test of: getAllChapters]					
	* Conditions: any particular...
	*
	* require_once('models/PDO_chapter.php');
	* use Forteroche\Classes\PDO_chapter;
	*
	* $PDO_test = new PDO_chapter();
	*
	* echo 'DB connection: ' . var_export($PDO_test->getAllChapters(true), true);
	* $PDO_test = null;
	*/
}

?>