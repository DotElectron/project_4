<?php

namespace Rochefort\Controllers;
require_once('models/Error_manager.php');
use Rochefort\Classes\Error_manager;

require_once('models/PDO_chapter.php');
use Rochefort\Classes\PDO_chapter;
require_once('models/PDO_part.php');
use Rochefort\Classes\PDO_part;

if (isset($_POST['admRegister']))
{
	if (isset($activeDebug)) { Error_manager::setErr('* * * Admin Actions * * *'); }
	
	//Administrator treatments...
	if (isset($_GET['part'])
		&& $_GET['part'] !== 'new')
	{
		// An 'update' request was sent...
		$admFromPart = htmlspecialchars($_GET['part']);
		$PartClass = new PDO_part($admFromPart);
		//Prepare data...
		$admFromChapter = null;
		if (isset($_GET['chapter'])
			&& $_GET['chapter'] !== 'draft')
		{
			$chapterClass = new PDO_chapter(htmlspecialchars($_GET['chapter']));
			$admFromChapter = $chapterClass->getId();
			$chapterClass = null;
		}
		$admSubtitle = null;
		if (!(empty($_POST['admSubtitle'])))
		{
			$admSubtitle = PDO_part::htmlSecure($_POST['admSubtitle'], false, true);
		}
		$admHtmlText = null;
		if (isset($_POST['admHtmlText'])
			&& !(empty($_POST['admHtmlText'])))
		{
			$admHtmlText = PDO_part::htmlSecure($_POST['admHtmlText']);
		}
		$admShortTitle = null;
		if ($admSubtitle !== null) 
		{ 
			$admShortTitle = $admSubtitle; 
		}
		else if ($admHtmlText !== null)
		{
			$admShortTitle = substr($admHtmlText, 0, 60);
		}
		//Send data...
		if ($PartClass->updatePart($admFromPart,
								   $admFromChapter,
								   $admSubtitle,
								   $admHtmlText))
		{
			if (isset($activeDebug)) 
			{ 
				$PartClass = new PDO_part($admFromPart);
				if ($admFromChapter === null)
				{
					$admFromChapter = "draft";
				}
				Error_manager::setErr('Admin: update Part >>> ' . $admShortTitle . ' (n°' . $PartClass->getOrder() . ' in chap: ' . $admFromChapter .')');
				$PartClass = null;
			}
			else { Error_manager::setErr('Episode actualisé : "' . $admShortTitle . '"'); }
		}
		elseif (isset($activeDebug)) { Error_manager::setErr('Admin: failed to update Part ! [' . $admShortTitle . ']'); }
		else { Error_manager::setErr('Actualisation impossible pour : "' . $admShortTitle . '"'); }
		$admFromChapter = null;
		$admSubtitle = null;
		$admHtmlText = null;
		$admShortTitle = null;
		$admFromPart = null;
	}
	else if (!(isset($_GET['part']))
			|| $_GET['part'] === 'new')
	{
		// A 'create' request was sent...
		$PartClass = new PDO_part(null, '¤');
		//Prepare data...
		$admFromChapter = null;
		if (isset($_GET['chapter'])
			&& $_GET['chapter'] !== 'draft')
		{
			$chapterClass = new PDO_chapter(htmlspecialchars($_GET['chapter']));
			$admFromChapter = $chapterClass->getId();
			$chapterClass = null;
		}
		$admSubtitle = null;
		if (!(empty($_POST['admSubtitle'])))
		{
			$admSubtitle = PDO_part::htmlSecure($_POST['admSubtitle'], false, true);
		}
		$admHtmlText = null;
		if (isset($_POST['admHtmlText'])
			&& !(empty($_POST['admHtmlText'])))
		{
			$admHtmlText = PDO_part::htmlSecure($_POST['admHtmlText']);
		}
		$admShortTitle = null;
		if ($admSubtitle !== null) 
		{ 
			$admShortTitle = $admSubtitle; 
		}
		else if ($admHtmlText !== null)
		{
			$admShortTitle = substr($admHtmlText, 0, 60);
		}
		//Send data...
		if ($PartClass->createPart($admFromChapter,
								   $admHtmlText,
								   $admSubtitle))
		{
			$PartClass = new PDO_part('?', "¤");
			$_GET['part'] = $PartClass->getOrder();	//Partial: not in url...
			if (isset($activeDebug)) 
			{ 		
				if ($admFromChapter === null)
				{
					$admFromChapter = "draft";
				}
				Error_manager::setErr('Admin: create Part >>> ' . $admShortTitle . ' (n°' . $PartClass->getOrder() . ' in chap: ' . $admFromChapter .')');
			}
			else { Error_manager::setErr('Episode créé : "' . $admShortTitle . '"'); }
			$PartClass = null;
		}
		elseif (isset($activeDebug)) { Error_manager::setErr('Admin: failed to create Part ! [' . $admShortTitle . ']'); }
		else { Error_manager::setErr('Création impossible pour : "' . $admShortTitle . '"'); }
		$admFromChapter = null;
		$admSubtitle = null;
		$admHtmlText = null;
		$admShortTitle = null;
	}
}
else if (isset($_POST['admDelPart']))
{
	if (isset($activeDebug)) { Error_manager::setErr('* * * Admin Actions * * *'); }
	
	// A 'delete' request was sent...
	if (!(empty($_POST['admDelPart']))
		&& $_POST['admDelPart'] !== 'new')
	{
		$admFromPart = htmlspecialchars($_POST['admDelPart']);
		$PartClass = new PDO_part(null, '¤');
		if ($PartClass->deletePart($admFromPart))
		{
			if (isset($activeDebug)) { Error_manager::setErr('Admin: delete Part >>> n°' . $admFromPart); }
			else { Error_manager::setErr('Episode supprimé : n°' . $admFromPart); }
		}
		elseif (isset($activeDebug)) { Error_manager::setErr('Admin: failed to delete Part ! [n°' . $admFromPart . ']'); }
		else { Error_manager::setErr('Suppression impossible pour : n°' . $admFromPart); }
	}
	else { Error_manager::setErr('L\'épisode ne peut pas être supprimer...'); }
}
else if (isset($_POST['admMovePart']))
{
	if (isset($activeDebug)) { Error_manager::setErr('* * * Admin Actions * * *'); }
	
	// An 'changeOrder' request was sent...
	$admFromPart = htmlspecialchars($_POST['admMovePart']);
	$PartClass = new PDO_part($admFromPart);
	if (isset($activeDebug)) { Error_manager::setErr('Admin: get Part < n°' . $admFromPart); }
	$admMoveBefore = null;
	if (isset($_POST['admMoveBefore']))
	{
		$admMoveBefore = htmlspecialchars($_POST['admMoveBefore']);
	}
	if ($PartClass->changeOrder($admFromPart, 
								$admMoveBefore))
	{
		$PartClass = new PDO_part($admMoveBefore);
		$_GET['part'] = $PartClass->getOrder();		//Partial: not in url...
		if (isset($activeDebug)) { Error_manager::setErr('Admin: reorder Part >>> n°' . $PartClass->getOrder() . ' (from n°' . $admFromPart . ')'); }
		else { Error_manager::setErr('Episode déplacé vers : "' . $PartClass->getOrder() . '"'); }
	}
	elseif (isset($activeDebug)) { Error_manager::setErr('Admin: failed to reorder Part ! [' . $admFromPart . ']'); }
	else { Error_manager::setErr('Déplacement impossible depuis : "' . $admFromPart . '"'); }
}

?>

