<?php
	require_once('hibbity/dbinfo.php');
	if( USER_LEVEL < GROUP_EDIT ) {
		exit();
	}
	$order = split(',', $_POST['order']);
	foreach($order as $order => $image)
	{
		$sql = "UPDATE `image_groups` SET `image_order` = " . abs($order) . " WHERE image_id = " . abs($image) . " AND group_id = " . abs($_POST['group_id']) . " LIMIT 1";
		mysql_query($sql);
	}
?>