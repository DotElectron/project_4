<?php

namespace Forteroche\Controllers;
require_once('../models/Error_manager.php');
use Forteroche\Classes\Error_manager;

require_once('../models/PDO_part.php');
use Forteroche\Classes\PDO_part;
require_once('../models/PDO_comment.php');
use Forteroche\Classes\PDO_comment;

//Cause ajax job: reload session...
session_name('PhpRootSession');
if (session_start(['read_and_close' => true]))
{
	if (isset($_SESSION['activeDebug']))
	{
		//To current file & embbeded...
		$activeDebug = $_SESSION['activeDebug'];
	}
	$altRootPath = "../";		//to downstream 'PDO_manager'

	if (isset($_POST['adminBan'])
		&& isset($_POST['adminIdentifier']))
	{
		//Ajax method...
		if (isset($activeDebug)) { Error_manager::setErr('* * * Admin (ajax) Actions * * *'); }

		// An 'alert' request was sent...
		$commId = htmlspecialchars($_POST['adminIdentifier']);
		$commState = filter_var(htmlspecialchars($_POST['adminBan']), 
								FILTER_VALIDATE_BOOLEAN, 
								FILTER_NULL_ON_FAILURE);
		$stateStr = 'retrait effectif';
		$admStateStr = '';
		if ($commState === false)
		{
			$stateStr = 'retrait annulé';
			$admStateStr = 'un';
		}
		//Send data...
		$CommClass = new PDO_comment('¤');
		if ($CommClass->updateMute($commId, $commState))
		{	
			if (isset($activeDebug))
			{ 		
				Error_manager::setErr('Admin: ' . $admStateStr . 'ban comment (n°' . $commId . ')');
			}
			else { Error_manager::setErr('Commentaire n°' . $commId . ': ' . $stateStr . '.'); }
			$stateStr = null;
			$admStateStr = null;
		}
		elseif (isset($activeDebug)) { Error_manager::setErr('Admin: failed to ' . $admStateStr . 'ban n°' . $commId .'!'); }
		else { Error_manager::setErr('Commande "' . $stateStr . '" en échec sur ce commentaire (n°' . $commId . ')'); }
		unset($altRootPath);
		$CommClass = null;
		$commState = null;
		$commId = null;
	}
	elseif (isset($activeDebug)) { Error_manager::setErr('No POST data detected !!'); }
}
else { Error_manager::setErr('Error: session is down !'); }

//From ajax: reporting method...
Error_manager::displayErr();	// (an echo cmd)

?>

