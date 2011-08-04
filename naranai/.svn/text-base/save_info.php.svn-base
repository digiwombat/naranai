<?php
	
	require_once('hibbity/dbinfo.php');
	
	$id = mysql_real_escape_string($_POST["picture_id"]);
	if( USER_LEVEL < IMAGE_EDIT ) {
		header("Location: " . BASE_URL . "/post/view/" . $id);
		exit();
	}
	if(!$id)
	{
		header("Location: " . BASE_URL . "/post/list");
		exit();
	}
	
	if(!empty($_POST["old_tags"]) && empty($_POST["tag_field"]))
	{
		header("Location: " . BASE_URL . "/post/view/" . $id);
		exit();
	}
	$user_id = 1;
	if(isset($_COOKIE['user_id']))
	{
		$user_id = $_COOKIE['user_id'];
	}
	$old_tags 		= mysql_real_escape_string($_POST["old_tags"]);
	$tags 			= trim(strtolower(mysql_real_escape_string($_POST["tag_field"])));
	$tags 			= clean_tags($tags);
	$source 		= mysql_real_escape_string($_POST["source_field"]);
	$rating 		= mysql_real_escape_string($_POST["rating"]);
	$group 			= mysql_real_escape_string($_POST["group_field"]);
	$frommain		= mysql_real_escape_string($_POST["from_main"]);
	$parent_post	= abs($_POST["parent_post"]);
	
	$urlregex =  "^(https?|ftp)\:\/\/([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?[a-z0-9+\$_-]+(\.[a-z0-9+\$_-]+)*(\:[0-9]{2,5})?(\/([a-z0-9+\$_-]\.?)+)*\/?(\?[a-z+&\$_.-][a-z0-9;:@/&%=+\$_.-]*)?(#[a-z_.-][a-z0-9+\$_.-]*)?\$";
	
	if (!eregi($urlregex, $source)) 
	{
		$source = "";
	}
	
	if($tags != $old_tags)
	{
		$sql = "INSERT INTO `tag_histories`(id, 
											image_id, 
											tags, 
											user_id, 
											date_set, 
											user_ip) 
					VALUES(NULL, 
						   '" . $id . "', 
						   '" . $tags . "', 
						   '" . $user_id . "', 
						   '" . date('Y-m-d H:i:s') . "', 
						   '" . $_SERVER['REMOTE_ADDR'] . "')";
		mysql_query($sql);
	}
	$tag_search = str_replace(" ", "', '", $tags);
	$tags 		= explode(" ", $tags);
	$tags       = array_filter($tags); # Remove all nonscalar values.
	foreach($tags as &$tag)
	{
		$tag = trim($tag);
		$tag = str_replace("/", "-", $tag);
		$tag = str_replace(",", "-", $tag);
		$tag = str_replace('"', '', $tag);
		$tag = str_replace("\n", '', $tag);
		$tag = str_replace("\r", '', $tag);
		if(eregi(':', $tag))
		{
			list($type, $proper) = split(':', $tag);
			$tag_search = str_replace($tag, $proper, $tag_search);
			$tag = $proper;
			switch($type)
			{
				case 'char':
					$type = 'character';
					break;
			}
		}
		$sql = "SELECT newtag FROM `aliases` WHERE oldtag = '" . $tag . "'";
		$get = mysql_query($sql);
		if(mysql_num_rows($get) > 0)
		{
			$proper = mysql_result($get, 0);
			if($proper != '')
			{
				$tag_search = str_replace($tag, $proper, $tag_search);
				$tag = $proper;
			}
		}
		$sql = "SELECT implies FROM `implications` WHERE tag = '" . $tag . "'";
		$get = mysql_query($sql);
		while($run = mysql_fetch_assoc($get))
		{
			$tag_search .= "' ,'" . $run['implies'];
		}
		if($type == '') $type = 'normal';
		$sql = "INSERT IGNORE INTO `tags`(tag, type) VALUES('" . $tag . "', '" . $type . "')";
		mysql_query($sql);
		$type = '';
	}
	
	if($group != "None" && $group != "")
	{
		$sql = "INSERT IGNORE INTO `groups`(group_name, user_id) VALUES('" . $group . "', '" . $user_id . "')";
		mysql_query($sql);
		$sql = "SELECT id FROM `groups` WHERE `group_name` = '" . $group . "'";
		$get = mysql_query($sql);
		$run = mysql_fetch_assoc($get);
		$group_id = $run['id'];
		$sql = "INSERT IGNORE INTO `image_groups`(image_id, group_id) VALUES(" . $id . ", " . $group_id . ")";
		mysql_query($sql);
	}


	$old_tags 	= explode(" ", $old_tags);

	$remove = array();
	foreach($old_tags as $old_tag)
	{
		if(!in_array($old_tag, $tags))
		{
			$remove[] = $old_tag;
		}	
	}
	$remove = array_filter($remove); # Remove all nonscalar values.
	$old_tag_search = implode("', '", $remove);
	$sql = "SELECT id FROM `tags` WHERE `tag` IN ('" . $tag_search . "')";
	$get = mysql_query($sql);
	while($run = mysql_fetch_assoc($get))
	{
		$sql_tag = "INSERT IGNORE INTO `image_tags`(image_id, tag_id) VALUES('" . $id . "', '" . $run['id'] . "')";
		mysql_query($sql_tag);
		if(mysql_affected_rows() > 0)
		{
			$sql_tag = "UPDATE `tags` SET `count` = `count` + 1 WHERE `id` = '" . $run['id'] . "'";
			mysql_query($sql_tag);
		}
	}
	
	$sql = "SELECT id FROM `tags` WHERE `tag` IN ('" . $old_tag_search . "')";
	$get = mysql_query($sql);
	while($run = mysql_fetch_assoc($get))
	{
		$sql = "DELETE FROM `image_tags` WHERE `image_id` = '" . $id . "' AND `tag_id` = '" . $run['id'] . "' LIMIT 1";
		mysql_query($sql);
		if(mysql_affected_rows() > 0)
		{
			$sql_tag = "UPDATE `tags` SET `count` = `count` - 1 WHERE `id` = '" . $run['id'] . "'";
			mysql_query($sql_tag);
		}
	}
	
	if($parent_post == 0 || $parent_post == '')
	{
		$parent_post = "NULL";
	}
	$sql = "UPDATE `images` SET `source` = '" . $source . "', `rating` = " . $rating . ", `parent_post` = " . $parent_post . " WHERE `id` = " . $id;
	mysql_query($sql);

	# Final check; make sure that if there are no tags add "tagme"!
	$sql = "SELECT COUNT(`image_id`) FROM `image_tags` WHERE `image_id` = " . $id;
	$total = mysql_result(mysql_query($sql), 0);
	if( !$total )
	{
		$sql_tag = "INSERT IGNORE INTO `image_tags`(image_id, tag_id) VALUES('" . $id . "', '1')";
		mysql_query($sql_tag);
		if(mysql_affected_rows() > 0)
		{
			$sql_tag = "UPDATE `tags` SET `count` = `count` + 1 WHERE `id` = '1'";
			mysql_query($sql_tag);
		}
	}
	
	if($frommain != 1)
	{
		header("Location: " . BASE_URL . "/post/view/" . $id);
	}

?>