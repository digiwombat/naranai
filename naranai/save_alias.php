<?php
	require_once('hibbity/dbinfo.php');
	if( USER_LEVEL < TAG_EDIT ) {
		header("Location: " . BASE_URL . "/aliases/list");
		exit();
	}
	$id = abs($_POST["alias_id"]);

	if( (!isset($_POST['oldtag']) || empty($_POST['oldtag'])) ||
		(!isset($_POST['newtag']) || empty($_POST['newtag'])) )
	{
		header("Location: " . BASE_URL . "/aliases/list");
		exit();
	}

	$oldtag = trim(strtolower(mysql_real_escape_string($_POST["oldtag"])));
	$newtag = trim(strtolower(mysql_real_escape_string($_POST['newtag'])));
	$reason = mysql_real_escape_string($_POST['reason']);
	
	$oldtag 	= clean_tags($oldtag);
	$newtag 	= clean_tags($newtag);
	
	$sql = "INSERT IGNORE INTO `tags`(tag) VALUES('" . $newtag . "')";
	mysql_query($sql);
	if(!$id)
	{
		$sql = "INSERT INTO `aliases`(oldtag, newtag, reason) VALUES('" . $oldtag . "', '" . $newtag . "', '" . $reason . "')";
		mysql_query($sql);
	}
	else
	{
		$sql = "UPDATE `aliases` SET oldtag = '" . $oldtag . "', newtag = '" . $newtag . "', reason = '" . $reason . "' WHERE id = " . $id;
		mysql_query($sql);
	}
	
	header("Location: " . BASE_URL . "/aliases/list");

?>