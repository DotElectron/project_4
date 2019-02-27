<?php

namespace Rochefort\Controllers;
require_once('models/Error_manager.php');
use Rochefort\Classes\Error_manager;

require_once('models/PDO_part.php');
use Rochefort\Classes\PDO_part;
require_once('models/PDO_comment.php');
use Rochefort\Classes\PDO_comment;

if (isset($_POST['userNewComm']))
{
	if (isset($activeDebug)) { Error_manager::setErr('* * * User Actions * * *'); }
	
	//User treatments...
	if (isset($_POST['userComment']))
	{
		// A 'create' request was sent...
		$usrAuthor = null;
		if (isset($_SESSION['accTitle']))
		{
			$usrAuthor = $_SESSION['accTitle'];
		}
		//Prepare data...
		$usrFromPart = null;
		$partClass = new PDO_part(htmlspecialchars($_POST['userNewComm']));
		$usrFromPart = $partClass->getId();
		$partClass = null;
		
		$usrHtmlText = null;
		$usrShortTitle = null;
		if (isset($_POST['userComment']))
		{
			$usrHtmlText = PDO_comment::htmlSecure($_POST['userComment']);
			$usrShortTitle = substr($usrHtmlText, 0, 60);
		}
		//Send data...
		$CommClass = new PDO_comment('¤');
		if ($CommClass->createComment($usrFromPart,
								   	  $usrHtmlText,
								   	  $usrAuthor))
		{
			
			if (isset($activeDebug)) 
			{ 		
				$CommClass = new PDO_comment('?');
				Error_manager::setErr('Admin: create Part >>> ' . $usrShortTitle . ' (by ' . $CommClass->getAuthor() 
																. ' | n°' . $CommClass->getId() . ' in part: ' . $usrFromPart .')');
			}
			else { Error_manager::setErr('Episode créé : "' . $usrShortTitle . '"'); }
		}
		elseif (isset($activeDebug)) { Error_manager::setErr('Admin: failed to create Part ! [' . $usrShortTitle . ']'); }
		else { Error_manager::setErr('Création impossible pour : "' . $usrShortTitle . '"'); }
		$usrAuthor = null;
		$usrFromPart = null;
		$usrHtmlText = null;
		$CommClass = null;
	}
	elseif (isset($_GET['userAlert']))
	{
		// A 'alert' request was sent...
	}
}

?>

