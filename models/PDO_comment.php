<?php

namespace Rochefort\Classes;
require_once('PDO_manager.php');

class PDO_comment extends PDO_manager
{							//inDB...
	private $id;			//com_id 			int 				P_KEY
	private $author;		//com_author	 	varchar(60) 		(default: Anonyme)		
	private $htmlText;		//com_text 			text
	private $flag;			//com_flag			int
	private $muted;			//com_muted			tinyint(1)			(bool)
	private $timeStamp;		//com_modifier		timestamp 			INDEX				DESC
	private $part;			//com_part_id 		int					INDEX				F_KEY

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
	final protected function setAuthor($_author) 
	{
		$this->author = $_author;
	}
	public function getAuthor() 
	{
		return ($this->author);
	}
	final protected function setHtmlText($_htmlText) 
	{
		$this->htmlText = $_htmlText;
	}
	public function getHtmlText() 
	{
		return ($this->htmlText);
	}	
	final protected function setFlag($_flag) 
	{
		$this->flag = $_flag;
	}
	public function getFlag() 
	{
		return ($this->flag);
	}
	final protected function setMuted($_muted) 
	{
		$this->muted = $_muted;
	}
	public function getMuted() 
	{
		return ($this->muted);
	}
	final protected function setTimeStamp($_timeStamp) 
	{
		$this->timeStamp = $_timeStamp;
	}
	public function getTimeStamp()
	{
		return ($this->timeStamp);
	}
	final protected function setPart($_part) 
	{
		$this->part = $_part;
	}
	public function getPart() 
	{
		return ($this->part);
	}

	// --------------------------------
	// --------------------------------

	function __construct($_id = null)
	{
		global $activeTest;
		if ($_id !== null)
		{
			if ($this->hasConnection() || $this->dbConnect())
			{	
				try
				{
					$statement = ' WHERE com_id = ?';
					if ($_id === '?')
					{
						// Particular case: get last id...
						$statement = ' ORDER BY com_id DESC LIMIT 1';
					}
					$request = $this->getConnection()->prepare('SELECT *
																FROM comments' 
																. $statement);
					if ((is_numeric($_id) && $request->execute(array($_id)) > 0)
						|| ($_id === '?' && $request->execute() > 0))
					{
						$result = $request->fetch();
						$this->setId($result['com_id']);
						$this->setAuthor($result['com_author']);
						$this->setHtmlText($result['com_text']);
						$this->setFlag($result['com_flag']);
						$this->setMuted($result['com_muted']);
						$this->setTimeStamp($result['com_modifier']);
						$this->setPart($result['com_part_id']);

					}
				}
				catch (\PDOException $err) 
				{
					Error_manager::setErr('Failed to load comment: ' . $err->getCode() . ' - ' . $err->getMessage());
				}
			}
			else { Error_manager::setErr('Erreur sur le commentaire : connexion impossible à la base de données !'); }
		}
		else if (isset($activeTest))
		{ 
			Error_manager::setErr('[Empty Constructor]'); 
		}
		else
		{ 
			Error_manager::setErr('Aucun commentaire ne peut persister sans identifiant dans la base...'); 
		}
	}

	// --------------------------------
	// --------------------------------

	/**
	* ...		(internal existancial request about the chapter)
	* @param int $_id
	* @return bool Comment exists...
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
																FROM comments 
																WHERE com_id = ?');
					if ($request->execute(array($_id)) > 0)
					{
						$result = $request->fetchColumn();
					}
				}
				catch (\PDOException $err) 
				{
					Error_manager::setErr('Failed to load comment: ' . $err->getCode() . ' - ' . $err->getMessage());
				}
				finally
				{
					return ($result > 0);
				}
			}
			else if (!(isset($activeTest))) { Error_manager::setErr('Aucun identifiant abstrait ne peut persister dans la base...'); }
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
	* require_once('models/PDO_comment.php');
	* use Rochefort\Classes\PDO_comment;
	*
	* $PDO_test = new PDO_comment();
	*
	* echo 'DB connection: ' . var_export($PDO_test->isExist(null, true), true);
	* $PDO_test = null;
	*/

	// --------------------------------
	// --------------------------------

	/**
	* ...		(when a user posts a new comment)
	* @param int $_part
	* @param string $_htmlText
	* @param string [optional] $_author default=Invité
	* @return bool connection/request
	*/
	final public function createComment($_part, $_htmlText, $_author = 'Invité', $__default = false) 
	{
		global $activeTest;
		if (($this->hasConnection() && $this->asAdmin()) || $this->dbConnect(true))
		{
			if ($_part !== null && is_numeric($_part) && $_htmlText !== null)
			{
				//Create execution...
				$result = -1;
				try
				{
					$request = $this->getConnection()->prepare('INSERT INTO comments(com_author, com_text, com_part_id) 
																VALUES(?, ?, ?)');
					$result = $request->execute(array($_author, $_htmlText, $_part));
				}
				catch (\PDOException $err) 
				{
					Error_manager::setErr('Failed to create comment: ' . $err->getCode() . ' - ' . $err->getMessage());
				}
				finally
				{
					return ($result > 0);
				}
			}
			else if (!(isset($activeTest))) { Error_manager::setErr('Un commentaire doit être rattaché à un épisode et avoir un contenu...'); }
			// Default blank response...
			return $__default;
		}
		//Connection error...
		return false;
	}
	/**
	* [External test of: createComment]					
	* Conditions: any particular...
	*
	* require_once('models/PDO_comment.php');
	* use Rochefort\Classes\PDO_comment;
	*
	* $PDO_test = new PDO_comment();
	*
	* echo 'DB connection: ' . var_export($PDO_test->createComment(null, null, null, true), true);
	* $PDO_test = null;
	* 
	*/

	/**
	* ...		(when user puts a flag on the comment)
	* @param int $_id
	* @param bool $flagVector (added/removed)
	* @return bool connection/request
	*/
	final public function updateFlag($_id, $flagVector, $__default = false) 
	{
		global $activeTest;
		if (($this->hasConnection() && $this->asAdmin()) || $this->dbConnect(true))
		{
			if ($_id !== null && is_numeric($_id)
				&& $flagVector !== null && is_bool($flagVector))
			{
				//Check a valid Order...
				if ($this->isExist($_id))
				{
					//Transform value...
					$flagValue = 1;
					if (!$flagVector)
					{
						$flagValue = -1;
					}
					//Update execution...
					$result = -1;
					try
					{
						$request = $this->getConnection()->prepare('UPDATE comments
																	SET com_flag = com_flag + ?
																	WHERE com_id = ?');
						$result = $request->execute(array($flagValue, $_id));
					}
					catch (\PDOException $err) 
					{
						Error_manager::setErr('Failed to update flag statement: ' . $err->getCode() . ' - ' . $err->getMessage());
					}
					finally
					{
						return ($result > 0);
					}
				}
				else { Error_manager::setErr('Le commentaire est invalide...'); return false; }
			}
			else if (!(isset($activeTest))) { Error_manager::setErr('Les informations sur le commentaire sont invalides...'); }
			// Default blank response...
			return $__default;
		}
		//Connection error...
		return false;
	}
	/**
	* [External test of: updateFlag]					
	* Conditions: any particular...
	*
	* require_once('models/PDO_comment.php');
	* use Rochefort\Classes\PDO_comment;
	*
	* $PDO_test = new PDO_comment();
	*
	* echo 'DB connection: ' . var_export($PDO_test->updateFlag(null, null, true), true);
	* $PDO_test = null;
	*/

	/**
	* ...		(when admin decides to mute the comment)
	* @param int $_id
	* @param bool $_muted
	* @return bool connection/request
	*/
	final public function updateMute($_id, $_muted, $__default = false) 
	{
		global $activeTest;
		if (($this->hasConnection() && $this->asAdmin()) || $this->dbConnect(true))
		{
			if ($_id !== null && is_numeric($_id)
				&& $_muted !== null && is_bool($_muted))
			{
				//Check a valid Order...
				if ($this->isExist($_id))
				{
					//Corrective value...		//See 'bindValue'
					//if (!$_muted) { $_muted = 0; }
					//Update execution...
					$result = -1;
					try
					{
						$request = $this->getConnection()->prepare('UPDATE comments
																	SET com_muted = ?
																	WHERE com_id = ?');
						$request->bindValue(1, $_muted, \PDO::PARAM_BOOL);
						$request->bindValue(2, $_id);
						$result = $request->execute();
					}
					catch (\PDOException $err) 
					{
						Error_manager::setErr('Failed to update mute statement: ' . $err->getCode() . ' - ' . $err->getMessage());
					}
					finally
					{
						return ($result > 0);
					}
				}
				else { Error_manager::setErr('Le commentaire est invalide...'); return false; }
			}
			else if (!(isset($activeTest))) { Error_manager::setErr('Les informations sur le commentaire sont invalides...'); }
			// Default blank response...
			return $__default;
		}
		//Connection error...
		return false;
	}
	/**
	* [External test of: updateMute]					
	* Conditions: any particular...
	*
	* require_once('models/PDO_comment.php');
	* use Rochefort\Classes\PDO_comment;
	*
	* $PDO_test = new PDO_comment();
	*
	* echo 'DB connection: ' . var_export($PDO_test->updateMute(null, null, true), true);
	* $PDO_test = null;
	*/

	/**
	* ...		(when BETA TEST deletes from part)
	* @param int [optional] $_part default=-1
	* @return bool connection/request
	*/
	final public function deleteAllComments($_part = -1, $__default = false) 
	{
		global $activeTest;
		if (isset($activeTest))
		{
			if (($this->hasConnection() && $this->asAdmin()) || $this->dbConnect(true))
			{
				if ($_part !== null && is_numeric($_part))
				{
					//Delete execution...
					$result = -1;
					try
					{
						$request = $this->getConnection()->prepare('DELETE 
																	FROM comments 
																	WHERE com_part_id = ? 
																	OR com_part_id IS NULL');
						$result = $request->execute(array($_part));
					}
					catch (\PDOException $err) 
					{
						Error_manager::setErr('Failed to delete comments: ' . $err->getCode() . ' - ' . $err->getMessage());
					}
					finally
					{
						return ($result > 0);
					}
				}
				// Default blank response...
				return $__default;
			}
		}
		//Connection error...
		return false;
	}
	/**
	* [External test of: deleteAllComments]					
	* Conditions: any particular...
	*
	* require_once('models/PDO_comment.php');
	* use Rochefort\Classes\PDO_comment;
	*
	* $PDO_test = new PDO_comment();
	*
	* echo 'DB connection: ' . var_export($PDO_test->deleteAllComments(null, true), true);
	* $PDO_test = null;
	*/

	/**
	* ...		(when admin deletes mute comments from part)
	* @param int $_part
	* @return bool connection/request
	*/
	final public function deleteMuteComments($_part, $__default = false) 
	{
		global $activeTest;
		if (($this->hasConnection() && $this->asAdmin()) || $this->dbConnect(true))
		{
			if ($_part !== null && is_numeric($_part))
			{
				//Delete execution...
				$result = -1;
				try
				{
					$request = $this->getConnection()->prepare('DELETE 
																FROM comments 
																WHERE (com_muted = 1
																AND com_part_id = ?)
																OR com_part_id IS NULL');
					$result = $request->execute(array($_part));
				}
				catch (\PDOException $err) 
				{
					Error_manager::setErr('Failed to delete mute comments: ' . $err->getCode() . ' - ' . $err->getMessage());
				}
				finally
				{
					return ($result > 0);
				}
			}
			else if (!(isset($activeTest))) { Error_manager::setErr('L\'épisode des commentaires masqués doit être spécifié...'); }
			// Default blank response...
			return $__default;
		}
		//Connection error...
		return false;
	}
	/**
	* [External test of: deleteMuteComments]					
	* Conditions: any particular...
	*
	* require_once('models/PDO_comment.php');
	* use Rochefort\Classes\PDO_comment;
	*
	* $PDO_test = new PDO_comment();
	*
	* echo 'DB connection: ' . var_export($PDO_test->deleteMuteComments(null, true), true);
	* $PDO_test = null;
	*/

	/**
	* ...		(when user/admin requests a group of comments)
	* @param int $_part
	* @param bool [optional] $flagOrder (else: dateOrder) default=false
	* @param bool [optional] $visibleRange (0:notMutedOnly;1:mutedOnly;2:both) default=0
	* @return bool All ordered Comments of the part...
	*/
	final public function getCommentsOfPart($_part, $flagOrder = false, $visibleRange = 0, $__default = false)
	{
		if (($this->hasConnection() && !$this->asAdmin()) || $this->dbConnect())
		{
			//Select execution...
			$result = null;
			try
			{
				//Query values insertion...
				$where = ' = ' . $_part;
				if ($_part === null) { $where = ' IS NULL'; }
				$range = '';
				if (is_numeric($visibleRange) & $visibleRange < 2)
				{
					$range = ' AND com_muted = ' . $visibleRange;
				}
				$orderBy = ' com_modifier ';
				if ($flagOrder) 
				{ 
					$orderBy = ' com_flag '; 
					$range .= ' AND com_flag > 0';
				}
				//First version is the user fields...
				$fields = ' com_author, DATE_FORMAT(com_modifier, \'%d/%m/%y %H:%i\') AS com_date_fr, com_text';
				if ($flagOrder || (is_numeric($visibleRange) && $visibleRange > 0) || $_part === null)
				{
					//This version is the admin fields...
					$fields = ' com_flag, com_part_id, com_author, com_text, com_muted ';
				}
				$result = $this->getConnection()->query('SELECT' . $fields 
														. ' FROM comments
															WHERE com_part_id' . $where . $range
														. ' ORDER BY' . $orderBy . 'DESC');
			}
			catch (\PDOException $err) 
			{
				Error_manager::setErr('Failed to load comments: ' . $err->getCode() . ' - ' . $err->getMessage());
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
	* require_once('models/PDO_comment.php');
	* use Rochefort\Classes\PDO_comment;
	*
	* $PDO_test = new PDO_comment();
	*
	* echo 'DB connection: ' . var_export($PDO_test->getCommentsOfPart(null, null, null, true), true);
	* $PDO_test = null;
	*/
}

?>