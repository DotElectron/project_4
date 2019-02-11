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
	private function setAuthor($_author) 
	{
		$this->author = $_author;
	}
	public function getAuthor() 
	{
		return ($this->author);
	}
	private function setHtmlText($_htmlText) 
	{
		$this->htmlText = $_htmlText;
	}
	public function getHtmlText() 
	{
		return ($this->htmlText);
	}	
	private function setFlag($_flag) 
	{
		$this->flag = $_flag;
	}
	public function getFlag() 
	{
		return ($this->flag);
	}
	private function setMuted($_muted) 
	{
		$this->muted = $_muted;
	}
	public function getMuted() 
	{
		return ($this->muted);
	}
	private function setTimeStamp($_timeStamp) 
	{
		$this->timeStamp = $_timeStamp;
	}
	public function getTimeStamp()
	{
		return ($this->timeStamp);
	}
	private function setPart($_part) 
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
		global $activeDebug;
		if ($_id !== null)
		{
			if ($this->hasConnection() || $this->dbConnect())
			{	
				try
				{
					$request = $this->getConnection()->prepare('SELECT *
																FROM comments 
																WHERE com_id = ?');
					if ($request->execute(array($_id)) > 0)
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
		else if (isset($activeDebug))
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
	* ...		(when a user posts a new comment)
	* @param int $_part
	* @param string $_htmlText
	* @param string [optional] $_author default=Anonyme
	* @return bool connection/request
	*/
	public function createComment($_part, $_htmlText, $_author = '', $__default = false) 
	{
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
			else { Error_manager::setErr('Un commentaire doit être rattaché à un épisode et avoir un contenu...'); }
			// Default blank response...
			return $__default;
		}
		//Connection error...
		return false;
	}
	/**
	* [External test of: createComment]					[0.0.9.2 PASSED]
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
	* @return bool connection/request
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
	* @return bool connection/request
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
	* ...		(when BETA TEST deletes form part)
	* @param int $_part
	* @return bool connection/request
	*/
	public function deleteAllComments($_part, $__default = false) 
	{
		global $activeDebug;
		if (isset($activeDebug))
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
																	WHERE com_part_id = ?');
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
				else { Error_manager::setErr('L\'épisode des commentaires doit être spécifié...'); }
				// Default blank response...
				return $__default;
			}
		}
		//Connection error...
		return false;
	}
	/**
	* [External test of: deleteAllComments]					[0.0.9.2 PASSED]
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
	public function deleteMuteComments($_part, $__default = false) 
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
																WHERE com_muted = 1
																AND com_part_id = ?');
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
			else { Error_manager::setErr('L\'épisode des commentaires masqués doit être spécifié...'); }
			// Default blank response...
			return $__default;
		}
		//Connection error...
		return false;
	}
	/**
	* [External test of: deleteMuteComments]					[0.0.9.2 PASSED]
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
	* @param int [optional] $_part default=-1
	* @param bool [optional] $flagOrder (else: dateOrder DESC) default=false
	* @param bool [optional] $visibleRange (0:notOnly;1:mutedOnly;2:both) default=0
	* @return bool connection/request
	*/
	public function getCommentsOfPart($_part = -1, $flagOrder = false, $visibleRange = 0, $__default = false)
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