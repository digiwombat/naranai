<?php
	require_once('hibbity/dbinfo.php');

	$id = abs($_POST["group_id"]);
	if( USER_LEVEL < GROUP_EDIT ) {
		header("Location: " . BASE_URL . "/group/view/" . $id);
		exit();
	}
	if( (!isset($_POST['name_field']) || empty($_POST['name_field'])))
	{
		header("Location: " . BASE_URL . "/group/list");
		exit();
	}

	$group_active = 0;
	$group_name = mysql_real_escape_string($_POST["name_field"]);
	$group_description = strip_tags(mysql_real_escape_string($_POST["description"]));
	$group_active = abs($_POST['active']);

	if(!$id)
	{
		$sql = "INSERT INTO `groups`(group_name, description, active) VALUES('" . $group_name . "', '" . $group_description . "', " . $group_active . ")";
		mysql_query($sql) or die($sql);
	}
	else
	{
		$sql = "UPDATE `groups` SET group_name = '" . $group_name . "', description = '" . $group_description . "', active = " . $group_active . " WHERE id = " . $id;
		mysql_query($sql) or die($sql);
	}
	header("Location: " . BASE_URL . "/group/view/" . $id);

?>