<?php
	require_once('../../hibbity/dbinfo.php');
	if($_GET['do'] == 'db')
	{
		parse_mysql_dump('naranai.sql');
		echo 'Complete.';
		exit();
	}
	
	if($_GET['do'] == 'colors')
	{
		parse_mysql_dump('colors.sql');
		echo 'Complete.';
		exit();
	}
	
	if($_GET['do'] == 'settings')
	{
		if(!is_dir(SITE_DIR . '/feed_cache/'))
		{
			mkdir(SITE_DIR . '/feed_cache/', 0777);
		}
		if(!is_dir(SITE_DIR . '/images/'))
		{
			mkdir(SITE_DIR . '/images/', 0777);
		}
		if(!is_dir(SITE_DIR . '/thumbs/'))
		{
			mkdir(SITE_DIR . '/thumbs/', 0777);
		}
		$settings = array('permissions_upload' => 0,
							'permissions_tag_edit' => 1,
							'permissions_group_edit' => 1,
							'permissions_image_edit' => 1,
							'permissions_forum_view' => 0,
							'permissions_forum_reply' => 1,
							'permissions_forum_add' => 1);

		foreach($settings as $name => $value)
		{
			$sql = "INSERT IGNORE INTO config (name, value) VALUES ('" . $name . "', '" . $value . "');";
			mysql_query($sql);
		}
		echo "Complete.";
		exit();
	}
	
	if($_GET['do'] == 'user')
	{
		$username = $_GET['user'];
		$password = md5($username . $_GET['pass']);
		$sql = "INSERT INTO users (name, pass, user_level, approved) VALUES ('" . $username . "', '" . $password . "', 11, 1);";
		mysql_query($sql);
		echo "Complete.";
		exit();
	}
	
	function parse_mysql_dump($url)
	{
   		$handle = @fopen($url, "r");
		$query = "";
		while(!feof($handle)) {
			$sql_line = fgets($handle);
			if (trim($sql_line) != "" && strpos($sql_line, "--") === false) {
				$query .= $sql_line;
				if (preg_match("/;[\040]*\$/", $sql_line)) {
					$result = mysql_query($query) or die(mysql_error());
					$query = "";
				}
			}
		}
	}
?>