<?php
	require_once("../hibbity/dbinfo.php");
	require_once('../lib/functions.php');
	if(!isadmin($_COOKIE['user_id']))
	{
		header("Location: " . BASE_URL . "/group/list");	
		exit();
	}
	
	$id  = $_GET["group_id_number"];
	if(is_numeric($id))
	{
		$sql = "DELETE FROM image_groups WHERE group_id = " . $id;
		mysql_query($sql);
		$sql = "DELETE FROM groups WHERE id = " . $id ;
		mysql_query($sql);
	}
	header("Location: " . BASE_URL . "/group/list");
?>