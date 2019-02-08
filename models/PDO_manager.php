<?php

namespace Rochefort\Classes;
require_once('Error_manager.php');

abstract class PDO_manager
{
	private $db = null;
	private $acc = false;
	// Internal function - optional arg: 
	// ($__default = false) => used to report test from the connection response...
	
	function getConnection() 
	{
		return $this->db;
	}
	function hasConnection()
	{
		return ($this->db !== null);
	}
	function asAdmin()
	{
		return $this->acc;
	}
	// function rollBack()
	// {
	// 	if (hasConnection())
	// 	{
	// 		$this->db->rollBack();
	// 	}
	// }

	/**
	* Etablished a PDO connection with the reader (user) or writer (admin) account
	* @param bool [optional] $asWriter default=false
	* @return bool statement about the connection
	*/
	protected function dbConnect($asWriter = false) 
	{
		global $activeDebug;
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
	    }
	    finally
	    {
			//Debug...
			if (isset($activeDebug) && $this->hasConnection()) { Error_manager::setErr('ConnectTo: ' . $account); }
	    	//Release data...
        	unset($config);
        	unset($account);
        	unset($password);
	    }
		return ($this->db !== null);
	}
	/**
	* [External test of: dbConnect]					[0.0.4.2 PASSED]
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

	abstract protected function dbRelease();
}

?>