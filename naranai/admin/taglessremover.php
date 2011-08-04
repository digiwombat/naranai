<?php

	require_once('../hibbity/dbinfo.php');
	if(!isadmin($_COOKIE['user_id']))
	{
		header("Location: " . BASE_URL . "/post/list");	
		exit();
	}
	$tag_to_delete = 'naruto';
	$id  = 94;
	
	echo "Removing all untagged files.<br />";
	
	$sql = "SELECT hash, id FROM `images` WHERE `id` NOT IN (SELECT image_id FROM image_tags)";
	$get = mysql_query($sql);
	while($run = mysql_fetch_assoc($get))
	{
		$ab = substr($run['hash'], 0, 2);
		$thumb_name = SITE_DIR . "/thumbs/" . $ab . "/" . $run['hash'];
		$image_name = SITE_DIR . "/images/" . $ab . "/" . $run['hash'];
		unlink($thumb_name);
		echo "Removed thumb for " . $run['id'] . "<br />";
		unlink($image_name);
		echo "Removed image for " . $run['id'] . "<br />";
		$delsql = "DELETE FROM `images` WHERE `id` = " . $run['id'] . " LIMIT 1";
		mysql_query($delsql);
		echo "Removed db entry for " . $run['id'] . "<br />";
		$delsql = "DELETE FROM `image_tags` WHERE `id` =" . $run['id'];
		mysql_query($delsql);
		echo "Removed tags for " . $run['id'] . "<br />";
		$delsql = "DELETE FROM `image_groups` WHERE `id` =" . $run['id'];
		mysql_query($delsql);
		echo "Removed groups for " . $run['id'] . "<br />";
		$delsql = "DELETE FROM `tag_history` WHERE `id` =" . $run['id'];
		mysql_query($delsql);
		echo "Removed history for " . $run['id'] . "<br />";
		$delsql = "DELETE FROM `comments` WHERE `id` =" . $run['id'];
		mysql_query($delsql);
		echo "Removed comments for " . $run['id'] . "<br />";
		$delsql = "DELETE FROM `notes` WHERE `id` =" . $run['id'];
		mysql_query($delsql);
		echo "Removed notes for " . $run['id'] . "<br />";
	}
	/*
	$sql = "SELECT id, tag, count FROM `tags`";
	$get = mysql_query($sql);
	while($run = mysql_fetch_assoc($get))
	{	
		
		$countsql = "SELECT id FROM `image_tags` WHERE tag_id = " . $run['id'];
		$countget = mysql_query($countsql);
		$count 	  = mysql_num_rows($countget);
		echo "Checked tag count for " . $run['tag'] . "<br />";
		if($count != $run['count'])
		{
			$resetsql = "UPDATE `tags` SET `count` = " . $count . " WHERE id = " . $run['id'];
			mysql_query($resetsql);
			echo "Changed tag count for " . $run['tag'] . "<br />";
		}
	}*/
?>