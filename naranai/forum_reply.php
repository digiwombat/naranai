<?php
	require_once('hibbity/dbinfo.php');
	if (USER_LEVEL < FORUM_REPLY || !is_numeric($_POST['topic_id'])) 
	{
    	header("Location: " . BASE_URL . "/post/list");
		exit();
	}
	
	
	
	$id 	= abs($_POST["topic_id"]);
	$reply 	= strip_tags(mysql_real_escape_string($_POST["reply"]));
	
	$user 		= 1;
	if(isset($_COOKIE["user_id"]) && $_COOKIE["user_id"] == $_POST["user_id"])
	{
		$user = mysql_real_escape_string($_COOKIE["user_id"]);
	}
	else
	{
		header("Location: " . BASE_URL . "/post/list");
		exit();
	}
	if(!$id || !$reply)
	{
		header("Location: " . BASE_URL . "/post/list");
		exit();
	}
	
	$sql = "INSERT INTO `forum_posts`(
								   topic,
								   user_id,
								   ip,
								   posted_at,
								   post
								  )
						VALUES	  (
								   " . $id . ",
								   '" . $user . "',
								   '" . $_SERVER['REMOTE_ADDR'] . "',
								   '" . date('Y-m-d H:i:s') . "',
								   '" . $reply . "'
								   );";
	mysql_query($sql);
	header("Location: " . BASE_URL . "/forum/view/" . $id);
	exit();
	
?>