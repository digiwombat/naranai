<?php


$sql_searcher = mysql_query("select * from tags");
	$tag_search = '["';
	while($run_searcher = mysql_fetch_assoc($sql_searcher))
	{
		$tag_search .= $run_searcher["tag"] . '", "';
	}
	$tag_search .= '"]';

?>