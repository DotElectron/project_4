<?php

namespace Rochefort\Classes;
require_once('Error_manager.php');

final class userType
{
	private function __construct() {}		//Force no instanciation...

	const GUEST_USER = 0;
	const STANDARD_USER = 1;
	const ADMINISTRATOR = 2;
}

final class User_manager
{
	private $accountType = null;		//as userType (enum int value)
	private $accountTitle = null;		//as userName (string value)

	private function setAccountType($_accountType)
	{
		$this->accountType = $_accountType;
	}
	public function getAccountType()
	{
		return $this->accountType;
	}
	private function setAccountTitle($_accountTitle)
	{
		$this->accountTitle = $_accountTitle;
	}
	public function getAccountTitle()
	{
		return $this->accountTitle;
	}

	function __construct($asUserType = -1, $userData = null)
	{
		//Define the account type...
		if (is_numeric($asUserType) 
			&& ($asUserType >= 0 && $asUserType <= 2))
		{
			$this->setAccountType($asUserType);
		}
		else { $this->setAccountType(-1); }

		//Update from the account type...
		switch ($asUserType)
		{
			case userType::STANDARD_USER:
				if (!(empty($userData)))
				{
					$this->setAccountTitle($userData);
				}
				else { $this->setAccountType(-1); }
				break;
			case userType::ADMINISTRATOR:
				if ($this->isValidPassword($userData))
				{
					$this->setAccountTitle('Jean Rochefort');
				}
				else { $this->setAccountType(-1); }
				break;
			default:	//Force 'userType::GUEST_USER'
				$this->setAccountTitle('Invité');
				break;
		}
	}

	public function hasValidAccount()
	{
		return ($this->accountType >= 0
				&& $this->accountType <= 2);
	}

	private function isValidPassword($blockData)
	{
		try
		{
			global $activeTest;
			$config = parse_ini_file('private/config.ini'); 
			if (isset($activeTest)) 
			{ 
				return password_verify($blockData, $config['test_hash']); 
			}
			else { return password_verify($blockData, $config['pass_hash']); }
		}
		catch (\PDOException $err) 
		{
			Error_manager::setErr('Unabled to hash data: ' . $err->getCode() . ' - ' . $err->getMessage());
			return false;
		}
	}
}

?>