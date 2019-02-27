<?php

namespace Rochefort\Classes;
require_once('Error_manager.php');

$SQL_Version = null;

abstract class PDO_manager
{
	private $db = null;
	private $acc = false;
	// Internal function - optional arg: 
	// ($__default = false) => used to report test from the connection response...

	public function getConnection() 
	{
		return $this->db;
	}
	public function hasConnection()
	{
		return ($this->db !== null);
	}
	public function asAdmin()
	{
		return $this->acc;
	}

	/**
	* Etablished a PDO connection with the reader (user) or writer (admin) account
	* @param bool [optional] $asWriter default=false
	* @return bool statement about the connection
	*/
	final protected function dbConnect($asWriter = false) 
	{
		global $SQL_Version;
		global $activeDebug;
		global $activeTest;
		$this->db = null;
		$this->acc = false;
		try 
		{
			//Get the configuration...
			$config = parse_ini_file('private/config.ini'); 
			$account = null;
			$password = null;
			if (!$asWriter)
			{
				$account = $config['reader'];
				$password = $config['reader_pwd'];
				$config['writer_pwd'] = null;
			}
			else 
			{  
				$account = $config['writer'];
				$password = $config['writer_pwd']; 
				$config['reader_pwd'] = null;
			}
			//Etablished connection...
			$this->db = new \PDO('mysql:host=' . $config['server_name']
								. ';dbname=' . $config['db_name']
								. ';charset=' . $config['db_charset'],
								$account, $password,
								array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
			$this->acc = $asWriter;	
		} 
		catch (\PDOException $err) 
		{
			Error_manager::setErr('Unabled to finalize connection: ' . $err->getCode() . ' - ' . $err->getMessage());
			$this->dbRelease();
		}
		finally
		{
			//Debug...
			if ((isset($activeDebug) || isset($activeTest)) && $this->hasConnection()) 
			{ 
				if ($SQL_Version === null) 
				{ 
						$SQL_Version = $this->db->getAttribute(\PDO::ATTR_SERVER_VERSION);
						Error_manager::setErr('* * * SQL version: ' . $SQL_Version . ' * * *');
				}
				$accType = '';
				if ($config['reader'] === $config['writer'])
				{
					//Particular Case: only one account available...
					$account = str_replace(range(0,9), '', $account);
					if ($this->acc) { $accType = ' [asWriter]'; }
					else { $accType = ' [asReader]'; }
				}
				Error_manager::setErr('ConnectTo(' . str_replace('Rochefort\Classes\\PDO_', '', get_class($this)) . '): ' . $account . $accType); 
			}
			//Release data...
			unset($config);
			unset($account);
			unset($password);
		}
		return ($this->db !== null);
	}
	/**
	* [External test of: dbConnect]					
	* Conditions: without 'abstract' & 'protected' scope 
	*
	* require_once('models/PDO_manager.php');
	* use Rochefort\Classes\PDO_manager;
	*
	* $PDO_test = new PDO_manager();
	*
	* echo $PDO_test->dbConnect();
	* $PDO_test = null;
	*/

	protected function dbRelease()
	{
		if ($this->db !== null)
		{
			$this->db = null;
			$this->acc = false;
		}
	}

	// --------------------------------
	// --------------------------------

	public static function htmlSecure($htmlContent, $unlock = false, $force = false)
	{
		if ($unlock)
		{
			// Database to html...
			if ($force)
			{
				//To unsafe html component...
				return strip_tags($htmlContent);
			}
			else
			{
				//To secured html component...
				return trim(preg_replace('/\s+/', ' ', html_entity_decode($htmlContent)));
			}
		}
		else
		{
			if ($force)
			{
				//Remove restricted characters... (accents allowed & treated by unicode chars)
				$htmlContent = preg_replace('/[^\p{L}a-zA-Z0-9\$\_\-\*\'\(\) ]+/u', '', $htmlContent);
				//From unsafe html to database...
				return strip_tags(str_replace(array('javascript:', '"'), '', $htmlContent));
			}
			else
			{
				//From secured html to database...
				return htmlspecialchars(addslashes(preg_replace(array('/\&lt;\/?script\&gt;/', '/javascript:/'), '', $htmlContent)));
			}
		}
	}
}

?>