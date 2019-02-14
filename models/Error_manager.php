<?php

namespace Rochefort\Classes;

final class Error_manager
{
	private function __construct() {}		//Force no instanciation...

	private static $err;
	public static function setErr($_err) 
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
	}
	private static function getErr() 
	{
		return (self::$err);
	}
	private static function clearErr() 
	{
		self::$err = null;
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