<?php
	require_once('hibbity/dbinfo.php');
	if( USER_LEVEL < FORUM_POST ) {
		header("Location: " . BASE_URL . "/forum/list");
		exit();
	}
	
	$id = abs($_POST["post_id"]);

	if( !isset($id) && (!isset($_POST['title']) || empty($_POST['title'])))
	{
		header("Location: " . BASE_URL . "/forum/list");
		exit();
	}
	if(!isset($_POST['post']) || empty($_POST['post']))
	{
		header("Location: " . BASE_URL . "/forum/list");
		exit();
	}
	$user_id 		= 1;
	if(isset($_COOKIE["user_id"]) && $_COOKIE["user_id"] == $_POST["user_id"])
	{
		$user_id = mysql_real_escape_string($_COOKIE["user_id"]);
	}
	else
	{
		header("Location: " . BASE_URL . "/forum/list");
		exit();
	}
	
	$title = mysql_real_escape_string($_POST["title"]);
	$post = strip_tags(mysql_real_escape_string($_POST["post"]));
	
	

	if(!$id)
	{
		$sql = "INSERT INTO `forum_posts`(
											title, 
											post,
											posted_at,
											user_id,
											ip
										) 
										VALUES
										(
											'" . $title . "', 
											'" . $post . "', 
											NOW(),
											" . $user_id . ",
											'" . $_SERVER['REMOTE_ADDR'] . "'
										)";
		mysql_query($sql) or die($sql);
	}
	else
	{
		$sql = "UPDATE `forum_posts` SET title = '" . $title . "', post = '" . $post . "', ip = '" . $_SERVER['REMOTE_ADDR'] . "', user_id = " . $user_id . " WHERE `id` = " . $id;
		mysql_query($sql) or die($sql);
	}
	header("Location: " . BASE_URL . "/forum/list/");

?>