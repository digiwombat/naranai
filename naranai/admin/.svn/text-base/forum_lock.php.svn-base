<?php
	require_once("../hibbity/dbinfo.php");
	require_once('../lib/functions.php');
	if(!isadmin($_COOKIE['user_id']))
	{
		header("Location: " . BASE_URL . "/forum/list");	
		exit();
	}
	
	$id  = $_GET["forum_post_number"];
	if(is_numeric($id))
	{
		$sql = "UPDATE `forum_posts` SET `locked` = locked ^ 1 WHERE `id` = " . $id;
		mysql_query($sql);
	}
	header("Location: " . BASE_URL . "/forum/list");
?>