<?php

	require_once('hibbity/dbinfo.php');
	

	if(!isset($_POST['user_id']) || !isset($_POST['image_id'])
	{
		exit();
	}
	$user_id	= mysql_real_escape_string($_POST['user_id']);
	$image_id	= mysql_real_escape_string($_POST['image_id']);
	$type		= $_POST['type'];
	
	if($type == 'add')
	{
		$sql = "INSERT IGNORE INTO `favourites`
							(
							 	image_id,
							  	user_id
							)
							
							VALUES
							(
							 	" . $image_id . ",
							 	" . $user_id . "
							)";
							 	
								  
	}
	else
	{
		$sql = "DELETE from `favourites` WHERE
							`user_id` = " . $user_id . "
						AND 
							`image_id` = " . $image_id;
	}
	
	mysql_query($sql);

?>