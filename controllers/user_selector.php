<?php

namespace Rochefort\Controllers;
require_once('models/Error_manager.php');
use Rochefort\Classes\Error_manager;
require_once('models/User_manager.php');
use Rochefort\Classes\User_manager; 
use Rochefort\Classes\UserType; 

global $activeDebug;
// $_POST['accHash'] 		From admin request to login...
// $_POST['accUser']		From user request to comment...

// $_SESSION['accType']		Type of the account during the session...
// $_SESSION['accTitle']	Visual name of the user during the session...

// $_COOKIE['session']		Contains the visual name to define "session" expiration...

$currentUser = null;		// variable object defined by the User_manager class...

if (isset($_POST['accHash']))
{
	if (!(isSessionAlive()) 
		&& !(empty($_POST['accHash'])))
	{
		//Administrator requested connection...
		$currentUser = new User_manager(userType::ADMINISTRATOR, 
										htmlspecialchars($_POST['accHash']));
		if (isset($activeDebug)) { Error_manager::setErr('Try ACC [>>Admin]: ' 
														. var_export($currentUser->hasValidAccount(), true)); }
	}
	else
	{
		//Disconnection...
		$currentUser = new User_manager();
	}
}
else if (isSessionExpired() && asAdminSession())
{
	//Standard user connection from last admin account...
	$currentUser = new User_manager(userType::STANDARD_USER, 
									htmlspecialchars($_SESSION['accTitle']));
	if (isset($activeDebug)) { Error_manager::setErr('Try ACC [Admin>>User]: ' 
													. var_export($currentUser->hasValidAccount(), true)); }
}
else if (isset($_POST['accUser'])) 
{
	if (!(isSessionAlive())
		|| ($_SESSION['accTitle'] !== htmlspecialchars($_POST['accUser'])))

	{
		//Standard user requested connection...
		$currentUser = new User_manager(userType::STANDARD_USER, 
										htmlspecialchars($_POST['accUser']));
		if (isset($activeDebug)) { Error_manager::setErr('Try ACC [>>User]: ' 
														. var_export($currentUser->hasValidAccount(), true)); }
	}
}
elseif (isValidSession())
{
	//Catched connection for standard user...
	$currentUser = new User_manager(userType::STANDARD_USER, 
									htmlspecialchars($_COOKIE['session']));
	if (isset($activeDebug)) { Error_manager::setErr('Try ACC [<<User]: ' 
													. var_export($currentUser->hasValidAccount(), true)); }
}
else if (!(isSessionAlive()) 
		|| (isSessionExpired()
			&& asUserSession()))
{
	//Guest connection...
	$currentUser = new User_manager(userType::GUEST_USER);
	if (isset($activeDebug)) { Error_manager::setErr('Try ACC [>>Guest]: ' 
													. var_export($currentUser->hasValidAccount(), true)); }
}
if ($currentUser !== null)
{ 
	if ($currentUser->hasValidAccount())
	{
		$cookTime = time();
		$cookValue  = '';
		$_SESSION['accType'] = $currentUser->getAccountType();
		$_SESSION['accTitle'] = $currentUser->getAccountTitle();
		if ($currentUser->getAccountType() >= userType::STANDARD_USER)
		{
			$cookValue = $currentUser->getAccountTitle();
			if ($currentUser->getAccountType() === userType::ADMINISTRATOR)
			{
				$cookTime += 1800;						//(30 min)
			}
			else { $cookTime += (86400 * 30);			//(30 days)	
		}
		setCookie('session', $cookValue, $cookTime, '/'); }
		if (isset($activeDebug)) { Error_manager::setErr('Account done: ' 
														. $_SESSION['accType'] . ' - '
														. $_SESSION['accTitle']
														. ' [' . $cookValue . ';' . $cookTime . ']'); }
	}
	else 
	{ 
		$currentUser = null; 
		unset($_SESSION['accType']);
		unset($_SESSION['accTitle']);
		if (isset($activeDebug)) { Error_manager::setErr('Account failed !'); }
		header('Refresh:0;');		//Location: ../index.php');"Refresh:0; url=index.php"
	}
}
else if (isset($activeDebug)) { Error_manager::setErr('Active account: ' . $_SESSION['accType'] . ' - ' . $_SESSION['accTitle']); }

function asUserSession()
{
	return (isSessionAlive()
			&& $_SESSION['accType'] == userType::STANDARD_USER);
}

function asAdminSession()
{
	return (isSessionAlive() 
			&& $_SESSION['accType'] == userType::ADMINISTRATOR);
}

function isSessionAlive()
{
	return (isset($_SESSION['accType']));
}

function isSessionExpired()
{
	return (!(isset($_COOKIE['session'])));
}

function isValidSession()
{
	return (!(isSessionExpired())
			&& !(empty($_COOKIE['session'])));
}

// -------------------------
// ------ DEBUG ONLY -------

function dbg_clearSession()
{
	global $activeDebug;
	if (isset($activeDebug))
	{
		unset($_SESSION['accType']);
		unset($_SESSION['accTitle']);
		if (!(isSessionExpired()))
		{
			unset($_COOKIE['session']);
		}
		Error_manager::setErr('Account cleaned !'); 
	}
}

?>