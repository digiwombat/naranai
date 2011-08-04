<?php
	require_once("../hibbity/dbinfo.php");
	require_once('../lib/functions.php');
	if(!isadmin($_COOKIE['user_id']))
	{
		header("Location: " . BASE_URL . "/post/list");	
		exit();
	}
	
	$id  = abs($_GET["user_majiggle"]);
	$status = $_GET["status"];
	switch($status)
	{
		case 'ban':
			$level = 0;
			break;
		case 'user':
			$level = 1;
			break;
		case 'admin':
			$level = 10;
			break;
		default:
			$level = 1;
	}
	if(is_numeric($id))
	{
		$sql = "UPDATE `users` SET `user_level` = " . $level . " WHERE `id` = " . $id;
		mysql_query($sql);
	}
	header("Location: " . BASE_URL . "/admin/users");
?>