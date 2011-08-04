<?php
	require_once('../hibbity/dbinfo.php');
	
	if(isset($_POST['user_approval_hash']) && preg_match('/^[A-Fa-f0-9]{32}$/' , $_POST['user_approval_hash']))
	{
		$hash = mysql_real_escape_string($_POST['user_approval_hash']);
		$sql = "UPDATE `users` SET `approved` = 1 WHERE approval_code = '" . $hash . "' AND `approved` = 0 LIMIT 1";
		mysql_query($sql);
		if(mysql_affected_rows() <= 0)
		{
			header("Location: " . BASE_URL . "/post/list");
			exit();
		}
		else
		{
			header("Location: " . BASE_URL . "/login");
			exit();
		}
	}
?>