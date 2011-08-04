<?php
	require_once('hibbity/dbinfo.php');
	if($_POST['find_tag'])
	{	
		$find_tag = mysql_real_escape_string($_POST['find_tag']);
		$type = '';
		if($_POST['type'] != 'tag')
		{
			$type = mysql_real_escape_string($_POST['type']) . '/';
		}
		$tags = explode(' ', $find_tag);
		header("Location: " . BASE_URL . "/tags/list/" . $type . $tags[0]);
	}
	else
	{
		header("Location: " . BASE_URL . "/tags/list");
	}

?>