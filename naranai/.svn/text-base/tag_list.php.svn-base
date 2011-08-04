<?php

require_once('hibbity/dbinfo.php');


if(isset($use_small))
{
	
}
else
{
	$sql = mysql_query("select * from tags");
	echo '["';
	while($run = mysql_fetch_assoc($sql))
	{
		echo $run["tag"] . '", "';
	}
	echo '"]';
}

?>