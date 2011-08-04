<?php
	require_once('hibbity/dbinfo.php');
	if($_GET['random'])
	{
		$sql = "SELECT id FROM images ORDER BY RAND() LIMIT 1";
		$get = mysql_query($sql);
		$rand = mysql_result($get, 0);
		header("Location: " . BASE_URL . "/post/view/" . $rand);
		exit();
	}
	if($_POST['q'])
	{	
		$q = mysql_real_escape_string($_POST['q']);
		$tags = explode(' ', $q);
		foreach($tags as $tag)
		{
			$sql = "SELECT `newtag` FROM `aliases` WHERE oldtag = '" . $tag . "'";
			$get = mysql_query($sql);
			if(mysql_num_rows($get) > 0)
			{
				$proper = mysql_result($get, 0);
				if($proper != '')
				{
					$q = str_replace($tag, $proper, $q);
				}
			}
		}
		header("Location: " . BASE_URL . "/post/list/" . $q);
	}
	else
	{
		header("Location: " . BASE_URL . "/post/list");
	}

?>