<?php
	require_once("../hibbity/dbinfo.php");
	require_once('../lib/functions.php');
	if(!isadmin($_COOKIE['user_id']))
	{
		header("Location: " . BASE_URL . "/tags/list");	
		exit();
	}
	
	$id  = $_GET["picture_id_number"];
	if(is_numeric($id))
	{
		$sql = "DELETE FROM image_groups WHERE image_id = " . $id;
		mysql_query($sql);
	}
	header("Location: " . BASE_URL . "/post/view/" . $id);
?>