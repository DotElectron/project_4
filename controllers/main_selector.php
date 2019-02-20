<?php

namespace Rochefort\Controllers;
require_once('models/Error_manager.php');
use Rochefort\Classes\Error_manager;

if (isset($activeDebug)) { Error_manager::setErr('* * * Main - Rewrite Url * * *'); }

//Administrator treatments...
if (isset($_GET['uChap']))
{
	// Load the entire chapters module...
	if (isset($activeDebug)) { Error_manager::setErr('[uChap: valid test]'); }
	include_once('views/backend/chapters.php');

}
else if (isset($_GET['uPart']))
{
	// Load the entire parts module...
	if (isset($activeDebug)) { Error_manager::setErr('[uPart: valid test]'); }
	include_once('views/backend/parts.php');

}
else if (isset($_GET['uComm']))
{
	//Load the entire commentaries module...
	if (isset($activeDebug)) { Error_manager::setErr('[uComm: valid test]'); }
	include_once('views/backend/comments.php');

}
else if (isset($_GET['iChap']))
{
	// Load the specified chapter (as a list of embedded parts + comments)...
	if (isset($activeDebug)) { Error_manager::setErr('[iChap: valid test >>> ' . var_export($_GET['iChap'], true) .']'); }
	include_once('views/frontend/reading.php');

}
else
{
	// Default view at the main screen (user): the "about" location...
	if (isset($activeDebug)) { Error_manager::setErr('[blank test]'); }
	include_once('views/about.php');
}

?>