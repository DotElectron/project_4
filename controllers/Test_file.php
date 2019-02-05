<?php

	require_once('models/Error_manager.php');
	use Rochefort\Classes\Error_manager;

	//Empty test: DB connection...
	Error_manager::setErr('------- BLANK TEST -------');
	require_once('models/PDO_chapter.php');
	use Rochefort\Classes\PDO_chapter;
	$PDO_test = new PDO_chapter();
	Error_manager::setErr('DB connection-CheckOne: ' . var_export($PDO_test->isExist(null, true), true));
	Error_manager::setErr('DB connection-CheckOrder: ' . var_export($PDO_test->isClean(null, null, true), true));
	Error_manager::setErr('DB connection-fetchId-Title: ' . var_export($PDO_test->getIdByTitle(null, true), true));
	Error_manager::setErr('DB connection-fetchId-Order: ' . var_export($PDO_test->getIdByOrder(null, true), true));
	Error_manager::setErr('DB connection-create: ' . var_export($PDO_test->createChapter(null, null, true), true));
	Error_manager::setErr('DB connection-update: ' . var_export($PDO_test->updateChapter(null, null, null, true), true));
	Error_manager::setErr('DB connection-delete: ' . var_export($PDO_test->deleteChapter(null, true), true));
	Error_manager::setErr('DB connection-fetchAll: ' . var_export($PDO_test->getAllChapters(true), true));
	
	//Data test : DB operations...
	Error_manager::setErr('------- DATA TEST -------');
	Error_manager::setErr('DB-create--Primary: ' . var_export($PDO_test->createChapter(0, 'Primary chapter'), true));
	Error_manager::setErr('DB-create--Secondary: ' . var_export($PDO_test->createChapter(1, 'Secondary chapter'), true));
	Error_manager::setErr('DB-create--Next: ' . var_export($PDO_test->createChapter(3, 'Next chapter'), true));
	Error_manager::setErr('DB-create--Last: ' . var_export($PDO_test->createChapter(6, 'Last chapter'), true));
	Error_manager::setErr('DB-update++Next: ' . var_export($PDO_test->updateChapter('Next chapter', 2, 'Third chapter'), true));
	Error_manager::setErr('DB-delete--Last: ' . var_export($PDO_test->deleteChapter('Last chapter'), true));
	Error_manager::setErr('DB-create--Pri-Sec: ' . var_export($PDO_test->createChapter(1, 'Pri-Sec Chapter'), true));
	foreach ($PDO_test->getAllChapters() as $row)
	{
		Error_manager::setErr('DB-fetchAll: ' . $row['chap_title']);
	}

	//Data test : Clean DB...
	Error_manager::setErr('DB-delete--Primary: ' . var_export($PDO_test->deleteChapter('Primary chapter'), true));
	Error_manager::setErr('DB-delete--Pri-Sec: ' . var_export($PDO_test->deleteChapter('Pri-Sec chapter'), true));
	Error_manager::setErr('DB-delete--Secondary: ' . var_export($PDO_test->deleteChapter('Secondary chapter'), true));
	Error_manager::setErr('DB-delete--Third: ' . var_export($PDO_test->deleteChapter('Third chapter'), true));
	$PDO_test = null;
	
?>