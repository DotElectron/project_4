<?php

namespace Rochefort\Controllers;
require_once('models/Error_manager.php');
use Rochefort\Classes\Error_manager;

require_once('models/User_manager.php');
use Rochefort\Classes\UserType; 
$userName = 'Invité';
$admin = false;
$guest = true;

require_once('models/PDO_chapter.php');
use Rochefort\Classes\PDO_chapter;
$chapterList = null;

if (isset($_SESSION['accType']))
{
	if (isset($_SESSION['accTitle']))
	{
		//Get it to report in nav...
		$userName = $_SESSION['accTitle'];
	}
	//Report the current account type...
	$admin = ($_SESSION['accType'] == userType::ADMINISTRATOR);
	$guest = ($_SESSION['accType'] == userType::GUEST_USER);

	//Call the associated view...
	include_once('views/navbar.php');

	if ($_SESSION['accType'] == userType::ADMINISTRATOR)
	{
		//Administrator menu...
		//...

		//Call the associated view...
		include_once('views/backend/navbar.php');
	}
	else
	{
		//Standard(Guest) menu...
		$chapterClass = new PDO_chapter('x');
		$chapterList = $chapterClass->getAllChapters();
		$chapterClass = null;

		//Call the associated view...
		include_once('views/frontend/navbar.php');
	}
}

?>