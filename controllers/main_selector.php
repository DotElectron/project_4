<?php

namespace Rochefort\Controllers;
require_once('models/Error_manager.php');
use Rochefort\Classes\Error_manager;

require_once('controllers/user_selector.php'); 

require_once('models/PDO_chapter.php');
use Rochefort\Classes\PDO_chapter;
require_once('models/PDO_part.php');
use Rochefort\Classes\PDO_part;
require_once('models/PDO_comment.php');
use Rochefort\Classes\PDO_comment;

//Administrator treatments...
if (isset($_GET['uChap'])
	&& asAdminSession())
{
	//Verify administrator actions...
	include_once('controllers/admin_chapters.php');

	// Load the entire chapters module...
	$chapterClass = new PDO_chapter('¤');
	$chapterList = $chapterClass->getAllChapters();
	$chapterClass = null;
	if (isset($activeDebug)) 
	{ 
		Error_manager::setErr('* * * Main - Rewrite admin url * * *');
		Error_manager::setErr('[uChap: valid test]'); 
	}
	include_once('views/backend/chapters.php');
	$chapterList = null;
}
else if (isset($_GET['uPart'])
		 && asAdminSession())
{
	//Verify administrator actions...
	include_once('controllers/admin_parts.php');

	// Load the entire parts module...
	$chapterClass = new PDO_chapter('¤');
	$chapterList = $chapterClass->getAllChapters();
	$chapterClass = null;
	$selectedChapter = null;
	$selChapData = null;
	if (isset($_GET['chapter'])
		&& $_GET['chapter'] !== 'draft')
	{
		// A real chapter is active...
		$selectedChapter = htmlspecialchars($_GET['chapter']);
		$chapterClass = new PDO_chapter($selectedChapter);
		$selChapData = $chapterClass->getId();
		$chapterClass = null;
	}
	$partClass = new PDO_part(null, '¤');
	$partList = $partClass->getPartsOfChapter($selChapData); 
	$partClass = null;
	$selectedPart = null;
	$selPartData = null;
	if (isset($_GET['part'])
		&& $_GET['part'] !== 'new')
	{
		// A real part is active...
		$selectedPart = htmlspecialchars($_GET['part']);
		$selPartData = new PDO_part($selectedPart);
	}
	if (isset($activeDebug)) 
	{ 
		Error_manager::setErr('* * * Main - Rewrite admin url * * *');
		Error_manager::setErr('[uPart: valid test]'); 
	}
	include_once('views/backend/parts.php');
}
else if (isset($_GET['uComm'])
		 && asAdminSession())
{
	//Load the entire commentaries module...
	if (isset($activeDebug)) 
	{ 
		Error_manager::setErr('* * * Main - Rewrite admin url * * *');
		Error_manager::setErr('[uComm: valid test]'); 
	}
	include_once('views/backend/comments.php');
}
//Standard treatment...
else if (isSessionAlive()
		&& (isset($_GET['iChap'])
		 	|| asAdminSession()))
{
	// Load the specified [as user] or last [as admin] chapter (list of embedded parts + comments)...
	if (isset($activeDebug)) 
	{ 
		Error_manager::setErr('* * * Main - Rewrite standard url * * *');
		if (!(asAdminSession()))
		{
			Error_manager::setErr('[iChap: valid test >>> ' . var_export($_GET['iChap'], true) .']'); 
		}
		else { Error_manager::setErr('[iChap as Admin: valid test]');  }
	}
	include_once('views/frontend/reading.php');
}
else
{
	// Default view at the main screen (user): the "about" location...
	if (isset($activeDebug)) 
	{ 
		Error_manager::setErr('* * * Main - Root url * * *');
		Error_manager::setErr('[blank test]'); 
	}
	include_once('views/about.php');
}

?>