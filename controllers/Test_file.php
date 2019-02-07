<?php

	require_once('models/Error_manager.php');
	use Rochefort\Classes\Error_manager;

	// --------------------------------
	// --------------------------------

	//Empty test: DB connection...
	Error_manager::setErr('------- BLANK "CHAP" TEST -------');
	require_once('models/PDO_chapter.php');
	use Rochefort\Classes\PDO_chapter;
	$PDO_test = new PDO_chapter();
	//(Optional section)
	// Error_manager::setErr('DB connection-CheckOne: ' . var_export($PDO_test->isExist(null, true), true));
	// Error_manager::setErr('DB connection-CheckOrder: ' . var_export($PDO_test->isClean(null, null, true), true));
	// Error_manager::setErr('DB connection-fetchId-Title: ' . var_export($PDO_test->getIdByTitle(null, true), true));
	// Error_manager::setErr('DB connection-fetchId-Order: ' . var_export($PDO_test->getIdByOrder(null, true), true));
	// Error_manager::setErr('DB connection-fetchTitle-Id: ' . var_export($PDO_test->getTitleById(null, true), true));
	//(Necessary section)
	Error_manager::setErr('DB connection-create: ' . var_export($PDO_test->createChapter(null, null, true), true));
	Error_manager::setErr('DB connection-update: ' . var_export($PDO_test->updateChapter(null, null, null, true), true));
	Error_manager::setErr('DB connection-delete: ' . var_export($PDO_test->deleteChapter(null, true), true));
	Error_manager::setErr('DB connection-fetchAll: ' . var_export($PDO_test->getAllChapters(true), true));
	
	//Data test : DB operations...
	Error_manager::setErr('------- DATA "CHAP" TEST -------');
	Error_manager::setErr('DB-create--Primary: ' . var_export($PDO_test->createChapter(0, 'Primary chapter'), true));
	Error_manager::setErr('DB-create--Secondary: ' . var_export($PDO_test->createChapter(1, 'Secondary chapter'), true));
	Error_manager::setErr('DB-create--Next: ' . var_export($PDO_test->createChapter(3, 'Next chapter'), true));
	Error_manager::setErr('DB-create--Last: ' . var_export($PDO_test->createChapter(6, 'Last chapter'), true));
	Error_manager::setErr('DB-update++Next: ' . var_export($PDO_test->updateChapter('Next chapter', 2, 'Third chapter'), true));
	Error_manager::setErr('DB-delete--Last: ' . var_export($PDO_test->deleteChapter('Last chapter'), true));
	Error_manager::setErr('DB-create--Pri-Sec: ' . var_export($PDO_test->createChapter(1, 'Pri-Sec chapter'), true));
	$PDO_data = $PDO_test->getAllChapters();
	if ($PDO_data)
	{
		foreach ($PDO_data as $row)
		{
			Error_manager::setErr('DB-fetchAll: ' . $row['chap_title']);
		}
	}

	//Data test : Clean DB...
	Error_manager::setErr('------- DATA "CHAP" CLEAN -------');
	$PDO_chap_test = $PDO_test;		//use to next Tests...
	Error_manager::setErr('DB-delete--Pri-Sec: ' . var_export($PDO_test->deleteChapter('Pri-Sec chapter'), true));
	Error_manager::setErr('DB-delete--Secondary: ' . var_export($PDO_test->deleteChapter('Secondary chapter'), true));
	Error_manager::setErr('DB-delete--Third: ' . var_export($PDO_test->deleteChapter('Third chapter'), true));
	$PDO_data = null;
	$PDO_test = null;

	// --------------------------------
	// --------------------------------

	//Empty test: DB connection...
	Error_manager::setErr('------- BLANK "PART" TEST -------');
	require_once('models/PDO_part.php');
	use Rochefort\Classes\PDO_part;
	$PDO_test = new PDO_part();
	//(Optional section)
	// Error_manager::setErr('DB connection-nextOrder: ' . var_export($PDO_test->nextOrder(true), true));
	//(Necessary section)
	Error_manager::setErr('DB connection-create: ' . var_export($PDO_test->createPart(null, null, null, true), true));

	//Data test : DB operations...
	Error_manager::setErr('------- DATA "PART" TEST -------');
	$PDO_class = new PDO_chapter('Primary chapter');
	Error_manager::setErr('DB-create--First: ' . var_export($PDO_test->createPart($PDO_class->getId(), 'A new story...'), true));
	Error_manager::setErr('DB-create--Second: ' . var_export($PDO_test->createPart($PDO_class->getId(), 'About a world of...', 'Single way'), true));

	//Data test : Clean DB...
	Error_manager::setErr('------- DATA "PART" CLEAN -------');
	Error_manager::setErr('DB-delete--First: ' . var_export($PDO_test->deletePart(0), true));
	Error_manager::setErr('DB-delete--First: ' . var_export($PDO_test->deletePart(1), true));
	Error_manager::setErr('------- DATA "CHAP" CLEAN -------');
	Error_manager::setErr('DB-delete--Primary: ' . var_export($PDO_chap_test->deleteChapter('Primary chapter'), true));
	$PDO_data = null;
	$PDO_test = null;
	
?>