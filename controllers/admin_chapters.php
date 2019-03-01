<?php

namespace Forteroche\Controllers;
require_once('models/Error_manager.php');
use Forteroche\Classes\Error_manager;

require_once('models/PDO_chapter.php');
use Forteroche\Classes\PDO_chapter;

if (isset($_POST['admLastData']))
{
	if (isset($activeDebug)) { Error_manager::setErr('* * * Admin Actions * * *'); }

	//Administrator treatments...
	if (isset($_POST['admChapter'])
		&& $_POST['admChapter'] !== $_POST['admLastData'])
	{
		// An (title) update request was sent...
		$chapterClass = new PDO_chapter(PDO_chapter::htmlSecure($_POST['admLastData'], false, true));
		if (isset($activeDebug)) { Error_manager::setErr('Admin: get chapter < ' . $chapterClass->getTitle() . ' (' . $chapterClass->getOrder() . ')'); }
		//Prepare data...
		$admChapter = PDO_chapter::htmlSecure($_POST['admChapter'], false, true);
		if (is_numeric($admChapter))
		{
			$admChapter .= '¤';
		}
		if ($chapterClass->getId()
			&& $chapterClass->updateChapter($chapterClass->getId(), 
										 	$chapterClass->getOrder(), 
										 	$admChapter))
		{
			$chapterClass = new PDO_chapter($admChapter);
			if (isset($activeDebug)) { Error_manager::setErr('Admin: update chapter >>> ' . $chapterClass->getTitle()); }
			else { Error_manager::setErr('Chapitre actualisé : "' . $chapterClass->getTitle() . '"'); }
		}
		elseif (isset($activeDebug)) { Error_manager::setErr('Admin: failed to update chapter ! [' . $chapterClass->getTitle() . ']'); }
		else { Error_manager::setErr('Actualisation impossible depuis : "' . htmlspecialchars($_POST['admLastData']) . '"'); }
		$admChapter = null;
	}
	else if (isset($_POST['admNewChapter']))
	{
		// A creation request was sent...
		$chapterClass = new PDO_chapter('¤');
		//Prepare data...
		$admNewChapter = PDO_chapter::htmlSecure($_POST['admNewChapter'], false, true);
		if (is_numeric($admNewChapter))
		{
			$admNewChapter .= '¤';
		}
		if ($chapterClass->createChapter($_POST['admLastData'], 
										 $admNewChapter))
		{
			$chapterClass = new PDO_chapter($admNewChapter);
			if (isset($activeDebug)) { Error_manager::setErr('Admin: create chapter >>> ' . $chapterClass->getTitle() . ' (' . $chapterClass->getOrder() . ')'); }
			else { Error_manager::setErr('Chapitre créé : "' . $chapterClass->getTitle() . '"'); }
		}
		elseif (isset($activeDebug)) { Error_manager::setErr('Admin: failed to create chapter ! [' . $chapterClass->getTitle() . ']'); }
		else { Error_manager::setErr('Création impossible pour : "' . $admNewChapter . '"'); }
		$admNewChapter = null;
	}
	else if (isset($_POST['admDelChapter']))
	{
		// A delete request was sent...
		$chapterClass = new PDO_chapter('¤');
		$admLastData = PDO_chapter::htmlSecure($_POST['admLastData'], false, true);
		if ($chapterClass->deleteChapter($admLastData))
		{
			if (isset($activeDebug)) { Error_manager::setErr('Admin: delete chapter >>> ' . $admLastData); }
			else { Error_manager::setErr('Chapitre supprimé : "' . $admLastData . '"'); }
		}
		elseif (isset($activeDebug)) { Error_manager::setErr('Admin: failed to delete chapter ! [' . $admLastData . ']'); }
		else { Error_manager::setErr('Suppression impossible pour : "' . $admLastData . '"'); }
	}
	else if (isset($_POST['admMoveChapter']))
	{
		// An (reorder) update request was sent...
		$admLastData = PDO_chapter::htmlSecure($_POST['admLastData'], false, true);
		$chapterClass = new PDO_chapter($admLastData);
		if (isset($activeDebug)) { Error_manager::setErr('Admin: get chapter < ' . $chapterClass->getTitle() . ' (' . $chapterClass->getOrder() . ')'); }
		if ($chapterClass->getId()
			&& $chapterClass->updateChapter($chapterClass->getId(), 
											htmlspecialchars($_POST['admMoveChapter']), 
											$chapterClass->getTitle(false)))
		{
			$chapterClass = new PDO_chapter(htmlspecialchars($_POST['admLastData']));
			if (isset($activeDebug)) { Error_manager::setErr('Admin: update chapter >>> ' . $chapterClass->getTitle() . ' (' . $chapterClass->getOrder() . ')'); }
			else { Error_manager::setErr('Chapitre déplacé : "' . $chapterClass->getTitle() . '"'); }
		}
		elseif (isset($activeDebug)) { Error_manager::setErr('Admin: failed to update chapter ! [' . $chapterClass->getTitle() . ']'); }
		else { Error_manager::setErr('Déplacement impossible depuis : "' . $admLastData . '"'); }
	}
}

?>