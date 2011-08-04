<?php
	require_once("../hibbity/dbinfo.php");
	require_once('../lib/functions.php');
	if(!isadmin($_COOKIE['user_id']))
	{
		exit();
	}
	
	$id  = $_POST["note_id_number"];
	if(is_numeric($id))
	{
		$sql = "DELETE FROM note_histories WHERE note_id = " . $id;
		mysql_query($sql);
		$sql = "DELETE FROM notes WHERE id = " . $id ;
		mysql_query($sql);
	}
?>