<?php

namespace Forteroche\Controllers;
require_once('models/Error_manager.php');
use Forteroche\Classes\Error_manager;

require_once('models/PDO_part.php');
use Forteroche\Classes\PDO_part;
require_once('models/PDO_comment.php');
use Forteroche\Classes\PDO_comment;

if (isset($_POST['userNewComm'])
	&& isset($_POST['userComment']))
{
	//Form method...
	if (isset($activeDebug)) { Error_manager::setErr('* * * User (form) Actions * * *'); }
	
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
	$usrHtmlText = PDO_comment::htmlSecure($_POST['userComment']);
	$usrShortTitle = substr($usrHtmlText, 0, 60);
	//Send data...
	$CommClass = new PDO_comment('¤');
	if ($CommClass->createComment($usrFromPart,
									$usrHtmlText,
									$usrAuthor))
	{
		if (isset($activeDebug)) 
		{ 		
			$CommClass = new PDO_comment('?');
			Error_manager::setErr('User: create Comm >>> ' . $usrShortTitle . ' (by ' . $CommClass->getAuthor() 
															. ' | n°' . $CommClass->getId() . ' in part: ' . $usrFromPart .')');
		}
		else { Error_manager::setErr('commentaire créé : "' . $usrShortTitle . '"'); }
	}
	elseif (isset($activeDebug)) { Error_manager::setErr('User: failed to create Comm ! [' . $usrShortTitle . ']'); }
	else { Error_manager::setErr('Création impossible pour : "' . $usrShortTitle . '"'); }
	$usrAuthor = null;
	$usrFromPart = null;
	$usrHtmlText = null;
	$CommClass = null;
}

?>

