<?php
	require_once('hibbity/dbinfo.php');
	if( USER_LEVEL < TAG_EDIT ) {
		header("Location: " . BASE_URL . "/aliases/list");
		exit();
	}
	$id = abs($_POST["implication_id"]);

	if( (!isset($_POST['tag']) || empty($_POST['tag'])) ||
		(!isset($_POST['implies']) || empty($_POST['implies'])) )
	{
		header("Location: " . BASE_URL . "/implications/list");
		exit();
	}

	$tag = trim(strtolower(mysql_real_escape_string($_POST["tag"])));
	$implies = trim(strtolower(mysql_real_escape_string($_POST['implies'])));
	$reason = mysql_real_escape_string($_POST['reason']);
	$tag 	= clean_tags($tag);
	$implies 	= clean_tags($implies);
	
	
	$sql = "INSERT IGNORE INTO `tags`(tag) VALUES('" . $tag . "')";
	mysql_query($sql);
	$sql = "INSERT IGNORE INTO `tags`(tag) VALUES('" . $implies . "')";
	mysql_query($sql);
	if(!$id)
	{
		$sql = "INSERT INTO `implications`(tag, implies, reason) VALUES('" . $tag . "', '" . $implies . "', '" . $reason . "')";
		mysql_query($sql);
	}
	else
	{
		$sql = "UPDATE `implications` SET tag = '" . $tag . "', implies = '" . $implies . "', reason = '" . $reason . "' WHERE id = " . $id;
		mysql_query($sql);
	}
	
	header("Location: " . BASE_URL . "/implications/list");

?>