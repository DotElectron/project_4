<?php

namespace Rochefort\Classes;

final class Error_manager
{
	private function __construct() {}		//Force no instanciation...

	private static $err = null;
	public static function setErr($_err, $_force = false) 
	{
		$inErr = '';
		if(stristr($_err, 'false')
		   || stristr($_err, 'failed')
		   || stristr($_err, 'error')
		   || stristr($_err, 'erreur'))  
		{ 
			$inErr = ' style="color:red"'; 
		}
		self::$err .= '<div' . $inErr . '>' . $_err . '</div>';
		self::syncErr();
		if ($_force) { self::displayErr(); }
	}
	private static function getErr() 
	{
		return (self::$err);
	}
	private static function clearErr() 
	{
		self::$err = null;
		unset($_SESSION['manager']);
	}
	private static function syncErr() 
	{
		if (self::$err === null
			&& isset($_SESSION['manager']))
		{
			self::$err = $_SESSION['manager'];
		}
		else
		{
			$_SESSION['manager'] = self::$err;
		}
	}

	/**
	* Return the current errors list...
	* @return String of cumulated errors
	*/
	public static function displayErr() 
	{
		if (self::$err !== null)
		{
			echo self::getErr();
			self::clearErr();
		}
		else { self::syncErr(); }
	}
	/**
	* [External test of: displayErr]					
	* Conditions: ---
	*
	* require_once('models/Error_manager.php');
	* use Rochefort\Classes\Error_manager;
	*
	* Error_manager::setErr('BLANK TEST: is a valid test !');
	* Error_manager::displayErr();
	*/
}

?>