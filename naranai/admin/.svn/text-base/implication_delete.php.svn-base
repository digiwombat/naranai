<?php
	require_once("../hibbity/dbinfo.php");
	require_once('../lib/functions.php');
	if(!isadmin($_COOKIE['user_id']))
	{
		header("Location: " . BASE_URL . "/implications/list");	
		exit();
	}
	
	$id  = $_GET["implication_id_number"];
	if(is_numeric($id))
	{
		$sql = "DELETE FROM implications WHERE id = " . $id ;
		mysql_query($sql);
	}

	header("Location: " . BASE_URL . "/implications/list");
?>