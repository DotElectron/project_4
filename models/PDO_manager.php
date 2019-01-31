<?php

namespace Rochefort\Classes;

class PDO_manager
{
	private $db;

	/**
	* Etablished a PDO connection with the user (reader) or writer (admin) account
	* @param optional bool $asReader, default = true
	* @return Boolean statement about the connection
	*/
	protected function dbConnect($asReader = true) 
	{
		$db = null;
		try 
    	{
    		//Get the configuration...
    		$conf = parse_ini_file('../private/config.ini'); 
    		$account = null;
    		$password = null;
    		if ($asReader)
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
        	$db = new PDO('mysql:host=' . $config['servername']
        				  . ';dbname=' . $config['db_name']
        				  . ';charset=' . $config['db_charset'],
        				  $account, $password);
        	$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    } 
	    catch (PDOException $e) 
	    {
	        die('Connection failed: ' . $e->getMessage() . "\n");
	    }
	    finally
	    {
	    	//Release data...
        	unset($config);
        	unset($account);
        	unset($password);
	    }
		return ($this->db !== null);
	}
}

?>