<?php

namespace Rochefort\Controllers;
require_once('models/Error_manager.php');
use Rochefort\Classes\Error_manager;

require_once('models/PDO_chapter.php');
use Rochefort\Classes\PDO_chapter;

if (isset($_POST['admLastData']))
{
	if (isset($activeDebug)) { Error_manager::setErr('* * * Admin Actions * * *'); }

	//Administrator treatments...
	if (isset($_POST['admChapter'])
		&& $_POST['admChapter'] !== $_POST['admLastData'])
	{
		// An (title) update request was sent...
		$chapterClass = new PDO_chapter($_POST['admLastData']);
		if (isset($activeDebug)) { Error_manager::setErr('Admin: get chapter < ' . $chapterClass->getTitle() . ' (' . $chapterClass->getOrder() . ')'); }
		if ($chapterClass->getId()
			&& $chapterClass->updateChapter($chapterClass->getId(), 
										 	$chapterClass->getOrder(), 
										 	htmlspecialchars($_POST['admChapter'])))
		{
			$chapterClass = new PDO_chapter(htmlspecialchars($_POST['admChapter']));
			if (isset($activeDebug)) { Error_manager::setErr('Admin: update chapter >>> ' . $chapterClass->getTitle()); }
			else { Error_manager::setErr('Chapitre actualisé : "' . $chapterClass->getTitle() . '"'); }
		}
		elseif (isset($activeDebug)) { Error_manager::setErr('Admin: failed to update chapter ! [' . $chapterClass->getTitle() . ']'); }
		else { Error_manager::setErr('Actualisation impossible depuis : "' . htmlspecialchars($_POST['admLastData']) . '"'); }
	}
	else if (isset($_POST['admNewChapter']))
	{
		// A creation request was sent...
		$chapterClass = new PDO_chapter(' ');
		if ($chapterClass->createChapter($_POST['admLastData'], 
										 htmlspecialchars($_POST['admNewChapter'])))
		{
			$chapterClass = new PDO_chapter(htmlspecialchars($_POST['admNewChapter']));
			if (isset($activeDebug)) { Error_manager::setErr('Admin: create chapter >>> ' . $chapterClass->getTitle() . ' (' . $chapterClass->getOrder() . ')'); }
			else { Error_manager::setErr('Chapitre créé : "' . $chapterClass->getTitle() . '"'); }
		}
		elseif (isset($activeDebug)) { Error_manager::setErr('Admin: failed to create chapter ! [' . $chapterClass->getTitle() . ']'); }
		else { Error_manager::setErr('Création impossible pour : "' . htmlspecialchars($_POST['admNewChapter']) . '"'); }
	}
	else if (isset($_POST['admDelChapter']))
	{
		// A delete request was sent...
		$chapterClass = new PDO_chapter(' ');
		if ($chapterClass->deleteChapter($_POST['admLastData']))
		{
			if (isset($activeDebug)) { Error_manager::setErr('Admin: delete chapter >>> ' . htmlspecialchars($_POST['admLastData'])); }
			else { Error_manager::setErr('Chapitre supprimé : "' . htmlspecialchars($_POST['admLastData']) . '"'); }
		}
		elseif (isset($activeDebug)) { Error_manager::setErr('Admin: failed to delete chapter ! [' . htmlspecialchars($_POST['admLastData']) . ']'); }
		else { Error_manager::setErr('Suppression impossible pour : "' . htmlspecialchars($_POST['admLastData']) . '"'); }
	}
	else if (isset($_POST['admMoveChapter']))
	{
		// An (reorder) update request was sent...
		$chapterClass = new PDO_chapter($_POST['admLastData']);
		if (isset($activeDebug)) { Error_manager::setErr('Admin: get chapter < ' . $chapterClass->getTitle() . ' (' . $chapterClass->getOrder() . ')'); }
		if ($chapterClass->getId()
			&& $chapterClass->updateChapter($chapterClass->getId(), 
											htmlspecialchars($_POST['admMoveChapter']), 
											$chapterClass->getTitle()))
		{
			$chapterClass = new PDO_chapter(htmlspecialchars($_POST['admLastData']));
			if (isset($activeDebug)) { Error_manager::setErr('Admin: update chapter >>> ' . $chapterClass->getTitle() . ' (' . $chapterClass->getOrder() . ')'); }
			else { Error_manager::setErr('Chapitre déplacé : "' . $chapterClass->getTitle() . '"'); }
		}
		elseif (isset($activeDebug)) { Error_manager::setErr('Admin: failed to update chapter ! [' . $chapterClass->getTitle() . ']'); }
		else { Error_manager::setErr('Déplacement impossible depuis : "' . htmlspecialchars($_POST['admLastData']) . '"'); }
	}
}

?>