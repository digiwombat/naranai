<?php
	require_once('../hibbity/dbinfo.php');
	
	if( (!is_numeric($_POST['edit_tags'])) ||
		(!is_numeric($_POST['edit_groups'])) ||
		(!is_numeric($_POST['uploads'])) ||
		!isadmin($_COOKIE['user_id'])
	   )
	{
		header("Location: " . BASE_URL . "/post/list");
		exit();
	}
	
	$settings = array('permissions_upload' => abs($_POST["uploads"]),
					'permissions_comments' => abs($_POST["comments"]),
					'permissions_group_edit' => abs($_POST["edit_groups"]),
					'permissions_tag_edit' => abs($_POST["edit_tags"]),
					'permissions_image_edit' => abs($_POST["edit_images"]),
					'permissions_forum_view' => abs($_POST["forum_view"]),
					'permissions_forum_add' => abs($_POST["forum_add"]),
					'permissions_forum_reply' => abs($_POST["forum_reply"]),
					'tag_editor' => mysql_real_escape_string($_POST["editor_style"]));

	foreach($settings as $name => $value)
	{
		$sql = "INSERT INTO config (name, value) VALUES ('" . $name . "', '" . $value . "') ON DUPLICATE KEY UPDATE value = '" . $value . "';";
		mysql_query($sql);
	}
	
	header("Location: " . BASE_URL . "/admin/settings");

?>