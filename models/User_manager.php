<?php

namespace Rochefort\Classes;

final class userType
{
	private function __construct() {}		//Force no instanciation...

	const GUEST_USER = 0;
	const STANDARD_USER = 1;
	const ADMINISTRATOR = 2;
}

final class User_manager
{
	private $accountType;		//as userType (enum value)
	private function setAccountType($_accountType)
	{
		$this->$accountType = $_accountType;
	}
	public function getAccountType()
	{
		return $this->$accountType;
	}

	function __construct($asUserType, $userName = null)
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
				if ($userName !== null)
				{
					//Set/Get Cookie...
					//... (frontend value: '$userName')
				}
				break;
			case userType::ADMINISTRATOR:
				//Get Admin pass...
				//... (frontend value: 'Jean Rochefort')
				break;
			default:		//Force 'userType::GUEST_USER'
				//... (default frontend value: 'Invité')
				break;
		}
	}

	function isValidPassword()
	{
		// if (password_hash($_POST['SendPwd'], PASSWORD_DEFAULT));)
	}
}

?>