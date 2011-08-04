<?php
	require_once("../hibbity/dbinfo.php");
	require_once('../lib/functions.php');
	if(!isadmin($_COOKIE['user_id']))
	{
		header("Location: " . BASE_URL . "/post/list");	
		exit();
	}
	
	
	$id  = $_GET["picture_id_number"];
	
	$sql = "select * from images where id = " . $id;
	$get = mysql_query($sql);
	$run = mysql_fetch_assoc($get);
	$hash = $run['hash'];
	$ab = substr($hash, 0, 2);
	$thumb_name = SITE_DIR . "/thumbs/" . $ab . "/" . $hash;
	$image_name = SITE_DIR . "/images/" . $ab . "/" . $hash;
	
	$sql = "SELECT tag_id FROM image_tags WHERE image_id = " . $id;
	$get = mysql_query($sql);
	while($runner = mysql_fetch_assoc($get))
	{
		$sql_tag = "UPDATE `tags` SET `count` = `count` - 1 WHERE `id` = '" . $runner['tag_id'] . "'";
		mysql_query($sql_tag);
	}
	unlink($thumb_name);
	unlink($image_name);
	$sql = "DELETE FROM images WHERE id = " . $id . " LIMIT 1";
	mysql_query($sql);
	$sql = "DELETE FROM image_tags WHERE image_id = " . $id;
	mysql_query($sql);
	$sql = "DELETE FROM image_groups WHERE image_id = " . $id ;
	mysql_query($sql);
	$sql = "DELETE FROM comments WHERE image_id = " . $id;
	mysql_query($sql);
	$sql = "DELETE FROM notes WHERE image_id = " . $id;
	mysql_query($sql);
	$sql = "DELETE FROM tag_histories WHERE image_id = " . $id;
	mysql_query($sql);

	if(abs($_GET["frommain"]) != 1)
	{
		header("Location: " . BASE_URL . "/post/list");
	}
?>