<?php

namespace Rochefort\Classes;

require_once('PDO_manager.php');

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
	* ...		(when admin creates a new chapter)
	* @param int $order
	* @param String $title
	* @return Boolean connection/request
	*/
	public function createChapter($order, $title) 
	{
		if ($this->dbConnect(true))
		{
			if ($order !== null && $title !== null)
			{
				$result = -1;
				try
				{
					$request = $this->getConnection()->prepare('INSERT INTO chapters(chap_order, chap_title) 
																VALUES(?, ?)');
					$result = $request->execute(array($order, $title));
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
			return true;
		}
		//Connection error...
		return false;
	}
	/**
	* [External test of: createChapter]					[0.0.5.2 PASSED]
	* Conditions: any particular...
	*
	* require_once('models/PDO_chapter.php');
	* use Rochefort\Classes\PDO_chapter;
	*
	* $PDO_test = new PDO_chapter();
	*
	* echo 'DB connection: ' . var_export($PDO_test->createChapter(null, null), true);
	* $PDO_test = null;
	* 
	*/

	/**
	* ...		(when admin modifies the chapter)
	* @param int $id
	* @param int $order
	* @param String $title
	* @return Boolean connection/request
	*/
	public function updateChapter($id, $order, $title) 
	{
		if ($this->dbConnect(true))
		{
			if ($id !== null && $order !== null && $title !== null)
			{
				$result = -1;
				try
				{
					$request = $this->getConnection()->prepare('UPDATE chapters 
																SET chap_order = ?, chap_title = ? 
																WHERE chap_id = ?');
					$result = $request->execute(array($order, $title, $id));
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
			else { Error_manager::setErr('Les informations du chapitre sont invalides...'); }
			// Default blank response...
			return true;
		}
		//Connection error...
		return false;
	}
	/**
	* [External test of: updateChapter]					[0.0.5.2 PASSED]
	* Conditions: any particular...
	*
	* require_once('models/PDO_chapter.php');
	* use Rochefort\Classes\PDO_chapter;
	*
	* $PDO_test = new PDO_chapter();
	*
	* echo 'DB connection: ' . var_export($PDO_test->updateChapter(null, null, null), true);
	* $PDO_test = null;
	*/

	/**
	* ...		(when admin deletes the chapter)
	* @param int $id
	* @return Boolean connection/request
	*/
	public function deleteChapter($id) 
	{
		if ($this->dbConnect(true))
		{
			if ($id !== null)
			{
				$result = -1;
				try
				{
					$request = $this->getConnection()->prepare('DELETE FROM chapters 
																WHERE chap_id = ?');
					$result = $request->execute(array($id));
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
			return true;
		}
		//Connection error...
		return false;
	}
	/**
	* [External test of: deleteChapter]					[0.0.5.2 PASSED]
	* Conditions: any particular...
	*
	* require_once('models/PDO_chapter.php');
	* use Rochefort\Classes\PDO_chapter;
	*
	* $PDO_test = new PDO_chapter();
	*
	* echo 'DB connection: ' . var_export($PDO_test->deleteChapter(null), true);
	* $PDO_test = null;
	*/

	/**
	* ...		(when ux requests the navigation)
	* @return array(PDO_Chapter) List of...
	*/
	public function getAllChapters() 
	{
		if ($this->dbConnect())
		{
			$result = null;
			try
			{
				$result = $this->getConnection()->query('SELECT chap_title FROM chapters 
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
			return true;
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
	* echo 'DB connection: ' . var_export($PDO_test->getAllChapters(), true);
	* $PDO_test = null;
	*/

	protected function dbRelease()
	{
		
	}
}

?>