<?php
	require_once('hibbity/dbinfo.php');
	if( USER_LEVEL < TAG_EDIT ) {
		header("Location: " . BASE_URL . "/tags/list");
		exit();
	}
	$id = abs($_POST["tag_id"]);

	if( (!isset($_POST['name_field']) || empty($_POST['name_field'])) ||
		(!isset($_POST['tag_type']) || empty($_POST['tag_type'])) )
	{
		header("Location: " . BASE_URL . "/tags/list");
		exit();
	}

	$tag_name = trim(strtolower(mysql_real_escape_string($_POST["name_field"])));
	$tag_type = strtolower($_POST['tag_type']);

	$tag_name 	= clean_tags($tag_name);

	switch( $tag_type )
	{
		case 'normal': case 'character': case 'artist': case 'series': case 'company':
			break;
		default:
			$tag_type = 'normal';
			break;
	}
	
	

	if(!$id)
	{
		$sql = "INSERT INTO `tags`(tag, type) VALUES('" . $tag_name . "', '" . $tag_type . "')";
		mysql_query($sql);
	}
	else
	{
		$sql = "UPDATE tags SET tag = '" . $tag_name . "', type = '" . $tag_type . "' WHERE id = " . $id;
		mysql_query($sql);
	}
	
	header("Location: " . BASE_URL . "/tags/list");

?>